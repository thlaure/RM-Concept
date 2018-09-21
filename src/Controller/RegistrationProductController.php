<?php

namespace App\Controller;

use App\Entity\Ball;
use App\Form\BallType;
use App\Service\EntityManipulation;
use App\Service\FileManipulation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationProductController.
 *
 * @category Symfony4
 * @package  App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class RegistrationProductController extends AbstractController
{
    /**
     * Affiche la page d'enregistrement de produits.
     *
     * @Route("/registration/product", name="registration_product")
     *
     * @param Request $request
     * @param EntityManipulation $entityManipulation
     * @param FileManipulation $fileManipulation
     *
     * @return Response
     */
    public function register(Request $request, EntityManipulation $entityManipulation, FileManipulation $fileManipulation): ?Response
    {
        $ball = new Ball();
        $form = $this->createForm(BallType::class, $ball);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form['image']->getData();
            $imageToCustomize = $form['image_to_customize']->getData();
            $quantity = $form['quantity']->getData();
            $reference = $form['reference']->getData();
            $referenceExists = $this->checkReferenceExistence($reference);
            if ($fileManipulation->testImageFormat($image) && $fileManipulation->testImageFormat($imageToCustomize) && $quantity > 0 && !$referenceExists) {
                $ball->setName(ucwords(strtolower($ball->getName())));
                $ball->setImage($fileManipulation->imageProcessing($image));
                $ball->setImageToCustomize($fileManipulation->customizableImageProcessing($imageToCustomize));
                $entityManipulation->persistObject($ball);
                return $this->returnRender($form, 'goodProduct');
            } elseif ($quantity <= 0) {
                return $this->returnRender($form, 'quantity');
            } elseif ($referenceExists) {
                return $this->returnRender($form, 'reference');
            } else {
                return $this->returnRender($form, 'image');
            }
        }
        return $this->returnRender($form, '');
    }

    /**
     * Vérifie l'existence de la référence en base de données.
     *
     * @param string $reference Référence dont il faut contrôler l'existence.
     *
     * @return bool|null
     */
    private function checkReferenceExistence(string $reference): ?bool
    {
        $repository = $this->getDoctrine()->getRepository(Ball::class);
        $result = $repository->findOneBy(
            array(
                'reference' => $reference
            )
        );
        return $result !== null;
    }

    /**
     * Renvoie le message approprié en fonction du besoin.
     *
     * @param FormInterface $form Formulaire de création de produits.
     * @param string $alert Alerte définie.
     *
     * @return Response
     */
    private function returnRender(FormInterface $form, string $alert): ?Response
    {
        if ($alert === 'goodProduct') {
            $render = $this->render(
                'registration_product/registration_product.html.twig', array(
                    'form' => $form->createView(),
                    'text_alert' => 'Le produit a bien été enregistré.',
                    'class_alert' => 'alert-success'
                )
            );
        } elseif ($alert === 'reference') {
            $render = $this->render(
                'registration_product/registration_product.html.twig', array(
                    'form' => $form->createView(),
                    'text_alert' => 'La référence saisie est déjà associée à un produit.',
                    'class_alert' => 'alert-warning'
                )
            );
        } elseif ($alert === 'name') {
            $render = $this->render(
                'registration_product/registration_product.html.twig', array(
                    'form' => $form->createView(),
                    'text_alert' => 'Le nom saisi est déjà associé à un produit.',
                    'class_alert' => 'alert-warning'
                )
            );
        } elseif ($alert === 'quantity') {
            $render = $this->render(
                'registration_product/registration_product.html.twig', array(
                    'form' => $form->createView(),
                    'text_alert' => 'La quantité disponible saisie doit être supérieure à zéro.',
                    'class_alert' => 'alert-warning'
                )
            );
        } elseif ($alert === 'image') {
            $render = $this->render(
                'registration_product/registration_product.html.twig', array(
                    'form' => $form->createView(),
                    'text_alert' => 'L\'image importée doit être une image.',
                    'class_alert' => 'alert-warning'
                )
            );
        } else {
            $render = $this->render(
                'registration_product/registration_product.html.twig', array(
                    'form' => $form->createView()
                )
            );
        }
        return $render;
    }
}