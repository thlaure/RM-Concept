<?php

namespace App\Controller;

use App\Entity\Ball;
use App\Entity\ShoppingCart;
use App\Entity\ShoppingCartProduct;
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
     *
     * @return Response
     */
    public function index(Security $security): ?Response
    {
        $customer = $security->getUser();
        $shoppingCart = $customer->getShoppingCart();
        $shoppingCartsProducts = $this->findAllProductsInCart($shoppingCart);
        $totalPrice = $this->calculateTotalPrice($shoppingCart);
        return $this->render('shopping_cart/shopping_cart.html.twig', array(
            'shopping_carts_products' => $shoppingCartsProducts,
            'total_price' => $totalPrice
        ));
    }

    /**
     * Renvoie un tableau avec tous les produits présents dans le panier passé en paramètre.
     *
     * @param ShoppingCart $shoppingCart Panier dont on veut récupérer le contenu.
     *
     * @return Ball[]|ShoppingCartProduct[]|object[]
     */
    private function findAllProductsInCart(ShoppingCart $shoppingCart): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(ShoppingCartProduct::class);
        $result = $repository->findBy(array(
            'shoppingCart' => $shoppingCart
        ));
        return $result;
    }

    /**
     * Renvoie le prix total du panier.
     *
     * @param ShoppingCart $shoppingCart Panier dont il faut calculer le montant total.
     *
     * @return float|int|null
     */
    private function calculateTotalPrice(ShoppingCart $shoppingCart): ?float
    {
        $totalPrice = 0;
        $shoppingCartsProducts = $this->findAllProductsInCart($shoppingCart);
        foreach ($shoppingCartsProducts as $shoppingCartProduct) {
            $totalPrice += $shoppingCartProduct->getProduct()->getPriceIndividuals() * $shoppingCartProduct->getQuantity();
        }
        return $totalPrice;
    }

    private function deleteShoppingCartProduct()
    {
        
    }
}