<?php

namespace App\Controller;

use App\Entity\ShoppingCartConfirmed;
use App\Entity\ShoppingCartNotConfirmed;
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
        $command = $shoppingCart->getCommand();
        $totalPrice = $command->getTotalPrice();
        $form = $this->createForm(PaymentType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $command->setPaymentMethod($command->getPaymentMethod());
            $command->setIsPaid(true);
            $shoppingCartConfirmed = $this->createShoppingCartConfirmed($shoppingCart);
            $command->setShoppingCart($shoppingCartConfirmed);
            $entityManipulation->persistObject($shoppingCartConfirmed);
            $entityManipulation->persistObject($command);
            $this->changeShoppingCart($shoppingCart, $shoppingCartConfirmed, $entityManipulation);
            $entityManipulation->resetShoppingCart($shoppingCart);
            return $this->render('payment/payment.html.twig', array(
                'form' => $form->createView(),
                'total_price' => $totalPrice,
                'text_alert' => 'Paiement effectué.',
                'class_alert' => 'alert-success'
            ));
        }
        return $this->render('payment/payment.html.twig', array(
            'form' => $form->createView(),
            'total_price' => $totalPrice
        ));
    }

    /**
     * Instancie la classe ShoppingCartConfirmed à partir du panier passé en paramètre.
     *
     * @param ShoppingCartNotConfirmed $shoppingCart
     *
     * @return null|ShoppingCartConfirmed
     */
    private function createShoppingCartConfirmed(ShoppingCartNotConfirmed $shoppingCart): ?ShoppingCartConfirmed
    {
        $shoppingCartConfirmed = new ShoppingCartConfirmed();
        $shoppingCartConfirmed->setCustomer($shoppingCart->getCustomer());
        $shoppingCartConfirmed->setTotalPrice($shoppingCart->getTotalPrice());
        $shoppingCartConfirmed->setProductQuantity($shoppingCart->getProductQuantity());
        $shoppingCartConfirmed->setIsConfirmed(true);
        $shoppingCartConfirmed->setCommand($shoppingCart->getCommand());
        $shoppingCartConfirmed->setIsSaved(false);
        return $shoppingCartConfirmed;
    }

    /**
     * Envoie les produits du panier non confirmé dans le panier confirmé.
     *
     * @param ShoppingCartNotConfirmed $shoppingCartNotConfirmed Panier d'où viennent les produits.
     * @param ShoppingCartConfirmed $shoppingCartConfirmed Panier où vont les produits.
     * @param EntityManipulation $entityManipulation
     */
    private function changeShoppingCart(ShoppingCartNotConfirmed $shoppingCartNotConfirmed, ShoppingCartConfirmed $shoppingCartConfirmed, EntityManipulation $entityManipulation): void
    {
        $shoppingCartProducts = $entityManipulation->findAllProductsInCart($shoppingCartNotConfirmed);
        foreach ($shoppingCartProducts as $shoppingCartProduct) {
            $shoppingCartProduct->setShoppingCart($shoppingCartConfirmed);
        }
    }
}