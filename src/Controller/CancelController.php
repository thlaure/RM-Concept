<?php

namespace App\Controller;

use App\Entity\Command;
use App\Entity\Customer;
use App\Service\EntityManipulation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CancelController extends AbstractController
{
    /**
     * Annule une commande.
     *
     * @Route("/cancel", name="cancel")
     *
     * @param Security $security
     * @param EntityManipulation $entityManipulation
     *
     * @return Response
     */
    public function cancel(Security $security, EntityManipulation $entityManipulation): ?Response
    {
        $customer = $security->getUser();
        $shoppingCart = $customer->getShoppingCartNotConfirmed();
        $shoppingCartProducts = $entityManipulation->findAllProductsInCart($shoppingCart);
        return $this->render('shopping_cart/shopping_cart.html.twig', array(
            'total_price' => $shoppingCart->getTotalPrice(),
            'shopping_cart_products' => $shoppingCartProducts
        ));
    }
}