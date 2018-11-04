<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ShoppingCart;
use App\Entity\ShoppingCartProduct;
use App\Service\EntityManipulation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class ShoppingCartController.
 *
 * @category Symfony4
 * @package  App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class ShoppingCartController extends AbstractController
{
    /**
     * Affiche la page du panier du client.
     *
     * @Route("/shopping-cart", name="shopping_cart")
     *
     * @param Security $security
     * @param EntityManipulation $entityManipulation
     *
     * @return Response
     */
    public function shoppingCart(Security $security, EntityManipulation $entityManipulation): ?Response
    {
        $customer = $security->getUser();
        $shoppingCart = $customer->getShoppingCartNotConfirmed();
        $shoppingCartsProducts = $entityManipulation->findProductsByCart($shoppingCart);
        $totalPrice = $this->calculateTotalPrice($shoppingCart, $entityManipulation);
        $shoppingCart->setTotalPrice($totalPrice);
        $entityManipulation->persistObject($shoppingCart);
        return $this->render('shopping_cart/shopping_cart.html.twig', array(
            'shopping_cart_products' => $shoppingCartsProducts,
            'total_price' => $totalPrice
        ));
    }

    /**
     * Supprime un produit du panier.
     *
     * @Route("/shopping-cart/delete-product/{reference}", name="delete_product")
     *
     * @param string $reference Référence du produit à supprimer du panier.
     * @param Security $security
     * @param EntityManipulation $entityManipulation
     *
     * @return null|Response
     */
    public function deleteShoppingCartProduct(string $reference, Security $security, EntityManipulation $entityManipulation): ?Response
    {
        $product = $entityManipulation->findOneProductByReference($reference);
        $shoppingCartProduct = $entityManipulation->findOneProductByCart($product);
        $entityManipulation->removeObject($shoppingCartProduct);
        $customer = $security->getUser();
        $shoppingCart = $customer->getShoppingCartNotConfirmed();
        $shoppingCartProducts = $entityManipulation->findProductsByCart($shoppingCart);
        $shoppingCart->setProductQuantity(count($shoppingCartProducts));
        $totalPrice = $this->calculateTotalPrice($shoppingCart, $entityManipulation);
        $shoppingCart->setTotalPrice($totalPrice);
        $entityManipulation->persistObject($shoppingCart);
        return $this->render('shopping_cart/shopping_cart.html.twig', array(
            'shopping_cart_products' => $shoppingCartProducts,
            'total_price' => $totalPrice
        ));
    }

    /**
     * Renvoie le prix total du panier.
     *
     * @param ShoppingCart $shoppingCart Panier dont il faut calculer le montant total.
     * @param EntityManipulation $entityManipulation
     *
     * @return float|int|null
     */
    private function calculateTotalPrice(ShoppingCart $shoppingCart, EntityManipulation $entityManipulation): ?float
    {
        $totalPrice = 0;
        $shoppingCartProducts = $entityManipulation->findProductsByCart($shoppingCart);
        foreach ($shoppingCartProducts as $shoppingCartProduct) {
            $totalPrice += $shoppingCartProduct->getPrice() * $shoppingCartProduct->getQuantity();
        }
        return $totalPrice;
    }
}