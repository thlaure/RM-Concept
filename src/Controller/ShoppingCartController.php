<?php

namespace App\Controller;

use App\Entity\Ball;
use App\Entity\Product;
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
    public function shoppingCart(Security $security): ?Response
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
     * Supprime un produit du panier.
     *
     * @Route("/shopping-cart/delete-product/{reference}", name="delete_product")
     *
     * @param string $reference R�f�rence du produit � supprimer du panier.
     * @param Security $security
     *
     * @return null|Response
     */
    public function deleteShoppingCartProduct(string $reference, Security $security): ?Response
    {
        $product = $this->findOneProductByReference($reference);
        $shoppingCartProduct = $this->findOneProductInCart($product);
        $this->deleteObject($shoppingCartProduct);
        $customer = $security->getUser();
        $shoppingCart = $customer->getShoppingCart();
        $shoppingCartsProducts = $this->findAllProductsInCart($shoppingCart);
        $shoppingCart->setProductQuantity(count($this->findAllProductsInCart($shoppingCart)));
        $this->persistObject($shoppingCart);
        $totalPrice = $this->calculateTotalPrice($shoppingCart);
        return $this->render('shopping_cart/shopping_cart.html.twig', array(
            'shopping_carts_products' => $shoppingCartsProducts,
            'total_price' => $totalPrice
        ));
    }

    /**
     * Renvoie le produit dont la r�f�rence est pass�e en param�tre.
     *
     * @param string $reference R�f�rence du produit que l'on souhaite r�cup�rer.
     *
     * @return Product|null|object
     */
    private function findOneProductByReference(string $reference): ?Product
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Product::class);
        $result = $repository->findOneBy(array(
            'reference' => $reference
        ));
        return $result;
    }

    /**
     * Renvoie la ligne du panier contenant le produit pass�e en paramètre.
     *
     * @param Product $product Produit qu'il faut r�cup�rer dans le panier.
     *
     * @return ShoppingCartProduct|null|object
     */
    private function findOneProductInCart(Product $product): ?ShoppingCartProduct
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(ShoppingCartProduct::class);
        $result = $repository->findOneBy(array(
            'product' => $product
        ));
        return $result;
    }

    /**
     * Renvoie un tableau avec tous les produits pr�sents dans le panier pass� en param�tre.
     *
     * @param ShoppingCart $shoppingCart Panier dont on veut r�cup�rer le contenu.
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

    /**
     * Permet de faire persister des objets en base de donn�es.
     *
     * @param $object
     */
    private function persistObject($object): void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($object);
        $entityManager->flush();
    }

    /**
     * Supprime l'entit� pass�e en param�tre.
     *
     * @param ? $object Objet � supprimer.
     */
    private function deleteObject($object): void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($object);
        $entityManager->flush();
    }
}