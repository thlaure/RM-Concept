<?php

namespace App\Controller;

use App\Entity\Ball;
use App\Entity\Customer;
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
        $shoppingCart = $this->findShoppingCartNotConfirmed($customer);
        $shoppingCartsProducts = $this->findAllProductsInCart($shoppingCart);
        $totalPrice = $this->calculateTotalPrice($shoppingCart);
        $shoppingCart->setTotalPrice($totalPrice);
        $this->persistObject($shoppingCart);
        return $this->render('shopping_cart/shopping_cart.html.twig', array(
            'shopping_cart_products' => $shoppingCartsProducts,
            'total_price' => $totalPrice,
            'shopping_cart' => $shoppingCart
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
        $this->removeObject($shoppingCartProduct);
        $customer = $security->getUser();
        $shoppingCart = $this->findShoppingCartNotConfirmed($customer);
        $shoppingCartProducts = $this->findAllProductsInCart($shoppingCart);
        $shoppingCart->setProductQuantity(count($this->findAllProductsInCart($shoppingCart)));
        $totalPrice = $this->calculateTotalPrice($shoppingCart);
        $shoppingCart->setTotalPrice($totalPrice);
        $this->persistObject($shoppingCart);
        return $this->render('shopping_cart/shopping_cart.html.twig', array(
            'shopping_cart_products' => $shoppingCartProducts,
            'total_price' => $totalPrice,
            'shopping_cart' => $shoppingCart
        ));
    }

    /**
     * Renvoie le panier non confirm� du client pass� en param�tre.
     *
     * @param Customer $customer Client li� au panier.
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
     * Renvoie la ligne du panier contenant le produit pass�e en param�tre.
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
        $shoppingCartProducts = $this->findAllProductsInCart($shoppingCart);
        foreach ($shoppingCartProducts as $shoppingCartProduct) {
            $totalPrice += $shoppingCartProduct->getProduct()->getPriceIndividuals() * $shoppingCartProduct->getQuantity();
        }
        return $totalPrice;
    }

    /**
     * Permet de persister des entit� en base de donn�es.
     *
     * @param ? $object Entit� � persister.
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
    private function removeObject($object): void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($object);
        $entityManager->flush();
    }
}