<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\ShoppingCart;
use App\Form\PaymentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class PaymentController.
 *
 * @category Symfony4
 * @package App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class PaymentController extends AbstractController
{
    /**
     * Affiche la page du choix de paiement de la commande.
     *
     * @Route("/payment", name="payment")
     *
     * @param Request $request
     * @param Security $security
     *
     * @return Response
     */
    public function payment(Request $request, Security $security): ?Response
    {
        $customer = $security->getUser();
        $shoppingCart = $this->findShoppingCartNotConfirmed($customer);
        $command = $shoppingCart->getCommand();
        $totalPrice = $command->getTotalPrice();
        $form = $this->createForm(PaymentType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $command->setPaymentMethod($command->getPaymentMethod());
            $command->setIsPaid(true);
            $shoppingCart->setIsConfirmed(true);
            $this->persistObject($shoppingCart);
            $this->persistObject($command);
            return $this->render('payment/payment.html.twig', array(
                'form' => $form->createView(),
                'total_price' => $totalPrice,
                'text_alert' => 'Paiement effectué.',
                'class_alert' => 'alert-success',
                'shopping_cart' => $shoppingCart
            ));
        }
        return $this->render('payment/payment.html.twig', array(
            'form' => $form->createView(),
            'total_price' => $totalPrice,
            'shopping_cart' => $shoppingCart
        ));
    }

    /**
     * Renvoie le panier non confirmé du client passé en paramètre.
     *
     * @param Customer $customer Client lié au panier.
     *
     * @return ShoppingCart|null
     */
    private function findShoppingCartNotConfirmed(Customer $customer): ?ShoppingCart
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(ShoppingCart::class);
        $result = $repository->findOneBy(array(
            'customer' => $customer,
            'isConfirmed' => false
        ));
        return $result;
    }

    /**
     * Permet de persister une entité en base de données.
     *
     * @param ? $object Objet à persister.
     */
    private function persistObject($object): void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($object);
        $entityManager->flush();
    }
}