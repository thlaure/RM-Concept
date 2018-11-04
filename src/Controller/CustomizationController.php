<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ShoppingCartProduct;
use App\Form\ShoppingCartProductCustomizedType;
use App\Service\EntityManipulation;
use App\Service\FileManipulation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class CustomizationController.
 *
 * @category Symfony4
 * @package App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class CustomizationController extends AbstractController
{
    /**
     * Affiche la page de personnaisation du produit.
     *
     * @Route("shop/customizable-balls/product/customization/{reference}", name="customization")
     *
     * @param Request $request
     * @param Security $security
     * @param EntityManipulation $entityManipulation
     * @param FileManipulation $fileManipulation
     * @param string $reference
     *
     * @return Response
     */
    public function customization(Request $request, Security $security, EntityManipulation $entityManipulation, FileManipulation $fileManipulation, string $reference): ?Response
    {
        $customer = $security->getUser();
        $product = $entityManipulation->findOneProductByReference($reference);
        $customizationPrice = 2;
        $shoppingCartProduct = new ShoppingCartProduct();
        $form = $this->createForm(ShoppingCartProductCustomizedType::class, $shoppingCartProduct);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
                if ($product->getQuantity() >= 12) {
                    $shoppingCart = $customer->getShoppingCartNotConfirmed();
                    $quantity = $shoppingCartProduct->getQuantity();
                    $customizationImage = $form['customization_image']->getData();
                    if ($fileManipulation->testImageFormat($customizationImage) && $quantity > 0) {
                        $shoppingCartProduct->setQuantity($quantity);
                        $shoppingCartProduct->setCustomizationImage($fileManipulation->customizedImageProcessing($customizationImage));
                        $shoppingCartProduct->setProduct($product);
                        $shoppingCartProduct->setShoppingCart($shoppingCart);
                        $shoppingCartProduct->setPrice(($shoppingCartProduct->getProduct()->getPriceIndividuals() + $customizationPrice) * $quantity);
                        $shoppingCartProduct->setIsCustomized(true);
                        $entityManipulation->persistObject($shoppingCartProduct);
                        $shoppingCart->setProductQuantity(count($entityManipulation->findProductsByCart($shoppingCart)));
                        $shoppingCart->setTotalPrice($shoppingCart->getTotalPrice() + $shoppingCartProduct->getPrice());
                        $entityManipulation->persistObject($shoppingCart);
                        return $this->returnRender($form, $product, 'success');
                    } elseif (!$quantity > 0) {
                        return $this->returnRender($form, $product, 'quantityZero');
                    } else {
                        return $this->returnRender($form, $product, 'quantityInt');
                    }
                } else {
                    return $this->returnRender($form, $product, 'outOfStock');
                }
            } else {
                return $this->returnRender($form, $product, 'login');
            }
        }
        return $this->returnRender($form, $product, '');
    }

    /**
     * Renvoie le message approprié en fonction du besoin.
     *
     * @param FormInterface $form Formulair ed'ajout au panier.
     * @param Product $product Produit à ajouter au panier.
     * @param string $alert Alerte définie.
     *
     * @return Response
     */
    private function returnRender(FormInterface $form, Product $product, string $alert): ?Response
    {
        if ($alert === 'success') {
            $render = $this->render('customization/customization.html.twig', array(
                'text_alert' => 'Le produit a été ajouté au panier.',
                'class_alert' => 'alert-success',
                'product' => $product,
                'form' => $form->createView()
            ));
        } elseif ($alert === 'quantityZero') {
            $render = $this->render('customization/customization.html.twig', array(
                'text_alert' => 'La quantité doit être supérieure à 0.',
                'class_alert' => 'alert-warning',
                'product' => $product,
                'form' => $form->createView()
            ));
        } elseif ($alert === 'quantityInt') {
            $render = $this->render('customization/customization.html.twig', array(
                'text_alert' => 'La quantité saisie doit avoir une valeur valide.',
                'class_alert' => 'alert-warning',
                'product' => $product,
                'form' => $form->createView()
            ));
        } elseif ($alert === 'login') {
            $render = $this->render(
                'security/login.html.twig', array(
                'error' => ''
            ));
        } elseif ($alert === 'outOfStock') {
            $render = $this->render(
                'shop/product_page.html.twig', array(
                'text_alert' => 'Le produit souhaité est en rupture de stock.',
                'class_alert' => 'alert-warning',
                'product' => $product,
                'form' => $form->createView()
            ));
        } else {
            $render = $this->render(
                'customization/customization.html.twig', array(
                'product' => $product,
                'form' => $form->createView()
            ));
        }
        return $render;
    }
}