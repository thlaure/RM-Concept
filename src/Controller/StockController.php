<?php

namespace App\Controller;

use App\Entity\Ball;
use App\Form\ProductQuantityType;
use App\Service\EntityManipulation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StockController.
 *
 * @category Symfony4
 * @package App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class StockController extends AbstractController
{
    /**
     * Affiche les stocks de produits.
     *
     * @Route("/admin/stock", name="admin_stock")
     *
     * @param Request $request
     * @param EntityManipulation $entityManipulation
     *
     * @return Response
     */
    public function stock(Request $request, EntityManipulation $entityManipulation): ?Response
    {
        $products = $entityManipulation->findProductsByNumberInPack(3);
        $ball = new Ball();
        $form = $this->createForm(ProductQuantityType::class, $ball);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quantity = $form['quantity']->getData();
            if ($quantity > 0) {
                $ball->setQuantity($quantity);
                $entityManipulation->persistObject($ball);
                return $this->returnRender($form, $products, 'good');
            } else {
                return $this->returnRender($form, $products, 'quantity');
            }
        }
        return $this->returnRender($form, $products, '');
    }

    /**
     * Renvoie le message approprié en fonction du besoin.
     *
     * @param FormInterface $form Formulaire d'ajout de quantité.
     * @param array $products Produits à afficher sur la page.
     * @param string $alert Alerte définie.
     *
     * @return null|Response
     */
    private function returnRender(FormInterface $form, array $products, string $alert): ?Response
    {
        if ($alert === 'good') {
            $render = $this->render('stock/stock.html.twig', array(
                'form' => $form->createView(),
                'products' => $products,
                'text_alert' => 'Quantité ajoutée.',
                'class_alert' => 'alert-success'
            ));
        } elseif ($alert === 'quantity') {
            $render = $this->render('stock/stock.html.twig', array(
                'form' => $form->createView(),
                'products' => $products,
                'text_alert' => 'La quantité doit être supérieure à 0.',
                'class_alert' => 'alert-warning'
            ));
        } else {
            $render = $this->render('stock/stock.html.twig', array(
                'form' => $form->createView(),
                'products' => $products
            ));
        }
        return $render;
    }
}