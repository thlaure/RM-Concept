<?php

namespace App\Controller;

use App\Entity\Command;
use App\Entity\ShoppingCart;
use App\Form\PaymentType;
use App\Service\EntityManipulation;
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
     * @param EntityManipulation $entityManipulation
     *
     * @return Response
     */
    public function payment(Request $request, Security $security, EntityManipulation $entityManipulation): ?Response
    {
        $customer = $security->getUser();
        $shoppingCart = $customer->getShoppingCartNotConfirmed();
        if ($shoppingCart->getCommand() !== null) {
            $command = $shoppingCart->getCommand();
            $totalPrice = $command->getTotalPrice();
            $form = $this->createForm(PaymentType::class, $command);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (!$this->checkCommandExistenceInShoppingCarts($command)) {
                    $command->setPaymentMethod($command->getPaymentMethod());
                    $command->setIsPaid(true);
                    $command->setShoppingCart($shoppingCart);
                    $shoppingCart->setIsConfirmed(true);
                    $entityManipulation->persistObject($shoppingCart);
                    $entityManipulation->persistObject($command);
                    $shoppingCart = $entityManipulation->createShoppingCart($customer);
                    $customer->setShoppingCartNotConfirmed($shoppingCart);
                    $entityManipulation->persistObject($shoppingCart);
                    $entityManipulation->persistObject($customer);
                    return $this->render('payment/payment_confirmation.html.twig', array(
                        'class_alert' => 'alert-success',
                        'text_alert' => 'Paiement effectué.'
                    ));
                } else {
                    return $this->render('payment/payment_confirmation.html.twig');
                }
            }
            return $this->render('payment/payment.html.twig', array(
                'form' => $form->createView(),
                'total_price' => $totalPrice
            ));
        } else {
            return $this->render('payment/payment_confirmation.html.twig');
        }
    }

    /**
     * Vérifier l'association d'une commande aux paniers.
     *
     * @param Command $command Commande dont on doit vérifier l'association.
     *
     * @return bool
     */
    private function checkCommandExistenceInShoppingCarts(Command $command): bool
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(ShoppingCart::class);
        $result = $repository->findOneBy(array(
            'command' => $command,
            'isConfirmed' => true
        ));
        return $result !== null;
    }
}