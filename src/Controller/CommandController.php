<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Command;
use App\Entity\Customer;
use App\Entity\Haulier;
use App\Entity\ShoppingCart;
use App\Form\CommandType;
use App\Service\EntityManipulation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class CommandController.
 *
 * @category Symfony4
 * @package App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class CommandController extends AbstractController
{
    /**
     * Affiche la page de choix du transporteur.
     *
     * @Route("/choice-haulier", name="choice_haulier")
     *
     * @param Request $request
     * @param Security $security
     * @param EntityManipulation $entityManipulation
     *
     * @return Response
     */
    public function command(Request $request, Security $security, EntityManipulation $entityManipulation): ?Response
    {
        $customer = $security->getUser();
        $shoppingCart = $customer->getShoppingCartNotConfirmed();
        if (!$this->checkCommandExistence($shoppingCart)) {
            $command = new Command();
            $command->setDate(new \DateTime());
            $date = $command->getDate();
            $command->setReference($this->generateReference($date, $customer));
            $shoppingCart->setCommand($command);
        } else {
            $command = $shoppingCart->getCommand();
        }
        $form = $this->createForm(CommandType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $city = $command->getDeliveryCity();
            $postalCode = $command->getDeliveryPostalCode();
            if (strlen($postalCode) === 5 && $this->checkCityExistence($city, $postalCode)) {
                $haulier = $command->getHaulier();
                $command->setHaulier($haulier);
                $command->setTotalPrice($this->fetchCommandTotalPrice($haulier, $customer));
                $command->setCustomer($customer);
                $command->setShoppingCart($shoppingCart);
                $command->setIsPaid(false);
                $command->setDeliveryAddress(ucwords($command->getDeliveryAddress()));
                $command->setDeliveryComplementAddress(ucwords($command->getDeliveryComplementAddress()));
                $command->setDeliveryPostalCode($postalCode);
                $command->setDeliveryCity(ucwords($city));
                $entityManipulation->persistObject($command);
                return $this->render('command/command_detail.html.twig', array(
                    'command' => $command,
                    'shopping_cart_products' => $entityManipulation->findAllProductsInCart($shoppingCart)
                ));
            } else {
                return $this->render('command/command.html.twig', array(
                    'form' => $form->createView(),
                    'text_alert' => 'Le code postal et la ville doivent correspondre.',
                    'class_alert' => 'alert-warning'
                ));
            }
        }
        return $this->render('command/command.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Renvoie le coût total de la commande.
     *
     * @param Haulier $haulier Transporteur sélectionné pour la commande.
     * @param Customer $customer Client à qui appartient la commande.
     *
     * @return float|null
     */
    private function fetchCommandTotalPrice(Haulier $haulier, Customer $customer): ?float
    {
        $shoppingCartPrice = $customer->getShoppingCartNotConfirmed()->getTotalPrice();
        $haulierPrice = $haulier->getPrice();
        return $shoppingCartPrice + $haulierPrice;
    }

    /**
     * Génère la référence de la commande.
     *
     * @param \DateTime $date Date de la commande.
     * @param Customer $customer Client à qui appartient la commande.
     *
     * @return string
     */
    private function generateReference(\DateTime $date, Customer $customer): ?string
    {
        return 'C' . $date->format('ymd') . $customer->getReference() . rand(10, 99);
    }

    /**
     * Vérifie l'existence de la ville saisie dans le formulaire.
     *
     * @param string $name Nom de la ville à vérifier.
     * @param string $postalCode Code postal de la ville à vérifier.
     *
     * @return bool
     */
    private function checkCityExistence(string $name, string $postalCode): bool
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(City::class);
        $result = $repository->findOneBy(array(
            'name' => strtoupper($name),
            'postalCode' => $postalCode
        ));
        return $result !== null;
    }

    /**
     * Vérifie l'existence de la commande liée au panier en cours.
     *
     * @param ShoppingCart $shoppingCart Panier lié à la commande.
     *
     * @return bool
     */
    private function checkCommandExistence(ShoppingCart $shoppingCart): bool
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Command::class);
        $result = $repository->findOneBy(array(
            'shoppingCart' => $shoppingCart
        ));
        return $result !== null;
    }
}