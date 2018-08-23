<?php

namespace App\Controller;

use App\Entity\Ball;
use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\ShoppingCart;
use App\Entity\ShoppingCartProduct;
use App\Form\ShoppingCartProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class ShopController.
 *
 * @category Symfony4
 * @package App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class ShopController extends AbstractController
{
    /**
     * Affiche le magasin de balles personnalisables.
     *
     * @Route("/shop/customizable-balls", name="shop_customizable-balls")
     *
     * @param Security $security
     *
     * @return null|Response
     */
    public function shop(Security $security): ?Response
    {
        $customer = $security->getUser();
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $shoppingCartNotConfirmed = null;
            $shoppingCarts = $customer->getShoppingCarts();
            foreach ($shoppingCarts as $shoppingCart) {
                if (!$shoppingCart->getIsConfirmed()) {
                    $shoppingCartNotConfirmed = $shoppingCart;
                }
            }
            if ($shoppingCartNotConfirmed === null) {
                $shoppingCart = $this->createShoppingCart($customer);
                $this->persistObject($shoppingCart);
            } else {
                $shoppingCart = $shoppingCartNotConfirmed;
            }
            return $this->render('shop/balls.html.twig', [
                'products' => $this->findAllBalls(),
                'customer' => $customer,
                'shopping_cart' => $shoppingCart,
                'individual' => true
            ]);
        }
        return $this->render('shop/balls.html.twig', [
            'products' => $this->findAllBalls(),
            'customer' => $customer,
            'individual' => true
        ]);
    }

    /**
     * Affiche l'espace entreprise.
     *
     * @Route("/shop/company-area", name="shop_company-area")
     *
     * @param Security $security
     *
     * @return null|Response
     */
    public function companyShop(Security $security): ?Response
    {
        $customer = $security->getUser();
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $shoppingCart = $this->findShoppingCartNotConfirmed($customer);
            return $this->render('shop/balls.html.twig', [
                'products' => $this->findAllBalls(),
                'customer' => $customer,
                'shopping_cart' => $shoppingCart
            ]);
        }
        return $this->render('shop/balls.html.twig', [
            'products' => $this->findAllBalls(),
            'customer' => $customer
        ]);
    }

    /**
     * Affiche la page liée au produit dont la référence est dans l'URL.
     *
     * @Route("shop/product/{reference}", name="product-page")
     *
     * @param Request $request
     * @param Security $security
     * @param string $reference Référence du produit.
     *
     * @return Response
     */
    public function productPage(Request $request, Security $security, string $reference): ?Response
    {
        $customer = $security->getUser();
        $product = $this->findOneByReference($reference);
        $shoppingCartProduct = new ShoppingCartProduct();
        $shoppingCart = $this->findShoppingCartNotConfirmed($customer);
        $form = $this->createForm(ShoppingCartProductType::class, $shoppingCartProduct);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
                $quantity = $shoppingCartProduct->getQuantity();
                if ($quantity > 0) {
                    $shoppingCartProduct->setQuantity($quantity);
                    $shoppingCartProduct->setShoppingCart($shoppingCart);
                    $shoppingCartProduct->setProduct($product);
                    $shoppingCartProduct->setPrice($shoppingCartProduct->getProduct()->getPriceIndividuals() * $quantity);
                    $this->persistObject($shoppingCartProduct);
                    $shoppingCart->setProductQuantity(count($this->findAllProductsInCart($shoppingCart)));
                    $shoppingCart->setTotalPrice($shoppingCart->getTotalPrice() + $product->getPriceIndividuals());
                    $this->persistObject($shoppingCart);
                    return $this->returnRender($form, $product, $shoppingCart, 'success');
                } elseif (!$quantity > 0) {
                    return $this->returnRender($form, $product, $shoppingCart, 'quantityZero');
                } else {
                    return $this->returnRender($form, $product, $shoppingCart, 'quantityInt');
                }
            } else {
                return $this->returnRender($form, $product, $shoppingCart, 'login');
            }
        }
        return $this->returnRender($form, $product, $shoppingCart, '');
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
     * Récupère l'objet Product dont la référence est passée en paramètre.
     *
     * @param string $reference Référence du produit que l'on veut récupérer.
     *
     * @return Product|null|object
     */
    private function findOneByReference(string $reference): ?Product
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Product::class);
        $result = $repository->findOneBy(array(
            'reference' => $reference
        ));
        return $result;
    }

    /**
     * Renvoie un tableau de données contenant toutes les balles en base de données.
     *
     * @return Ball[]|object[]
     */
    private function findAllBalls(): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Ball::class);
        $result = $repository->findAll();
        return $result;
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
     * Instancie la classe ShoppingCart.
     *
     * @param Customer $customer Client à qui appartient le panier.
     *
     * @return ShoppingCart
     */
    private function createShoppingCart(Customer $customer): ?ShoppingCart
    {
        $shoppingCart = new ShoppingCart();
        $shoppingCart->setCustomer($customer);
        $shoppingCart->setProductQuantity(0);
        $shoppingCart->setIsConfirmed(false);
        $shoppingCart->setTotalPrice(0);
        $shoppingCart->setIsSaved(false);
        return $shoppingCart;
    }

    /**
     * Permet de faire persister des objets en base de données.
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
     * Renvoie le message approprié en fonction du besoin.
     *
     * @param FormInterface $form Formulair ed'ajout au panier.
     * @param Product $product Produit à ajouter au panier.
     * @param ShoppingCart $shoppingCart
     * @param string $alert Alerte définie.
     *
     * @return Response
     */
    private function returnRender(FormInterface $form, Product $product, ShoppingCart $shoppingCart, string $alert): ?Response
    {
        if ($alert === 'success') {
            $render = $this->render('shop/product_page.html.twig', array(
                'text_alert' => 'Le produit a été ajouté au panier.',
                'class_alert' => 'alert-success',
                'product' => $product,
                'shopping_cart' => $shoppingCart,
                'form' => $form->createView()
            ));
        } elseif ($alert === 'quantityZero') {
            $render = $this->render('shop/product_page.html.twig', array(
                'text_alert' => 'La quantité doit être supérieure à 0.',
                'class_alert' => 'alert-warning',
                'product' => $product,
                'shopping_cart' => $shoppingCart,
                'form' => $form->createView()
            ));
        } elseif ($alert === 'quantityInt') {
            $render = $this->render('shop/product_page.html.twig', array(
                'text_alert' => 'La quantité saisie doit avoir une valeur valide.',
                'class_alert' => 'alert-warning',
                'product' => $product,
                'shopping_cart' => $shoppingCart,
                'form' => $form->createView()
            ));
        } elseif ($alert === 'login') {
            $render = $this->render(
                'security/login.html.twig', array(
                'error' => ''
            ));
        } else {
            $render = $this->render(
                'shop/product_page.html.twig', array(
                'product' => $product,
                'shopping_cart' => $shoppingCart,
                'form' => $form->createView()
            ));
        }
        return $render;
    }
}