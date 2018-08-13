<?php

namespace App\Controller;

use App\Entity\Ball;
use App\Entity\Color;
use App\Form\ColorType;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     *
     * @return Response
     */
    public function register(Request $request): ?Response
    {
        $ball = new Ball();
        $color = new Color();
        $formProduct = $this->createForm(ProductType::class, $ball);
        $formColor = $this->createForm(ColorType::class, $color);
        $formProduct->handleRequest($request);
        $formColor->handleRequest($request);
        if ($formProduct->isSubmitted() && $formProduct->isValid()) {
            $image = $formProduct['image']->getData();
            $quantity = $formProduct['quantity']->getData();
            $reference = $formProduct['reference']->getData();
            $referenceExists = $this->checkReferenceExistence($reference);
            if ($this->testImageFormat($image) && $quantity > 0 && !$referenceExists) {
                $ball->setName(ucwords($ball->getName()));
                $ball->setImage($this->imageProcessing($image));
                $this->persistObject($ball);
                return $this->returnRender($formProduct, $formColor, 'good');
            } elseif ($quantity <= 0) {
                return $this->returnRender($formProduct, $formColor, 'quantity');
            } elseif ($referenceExists) {
                return $this->returnRender($formProduct, $formColor, 'reference');
            }
            else {
                return $this->returnRender($formProduct, $formColor, 'image');
            }
        } elseif ($formColor->isSubmitted() && $formColor->isValid()) {
            $name = ucwords($formColor['name']->getData());
            $color->setName($name);
            $colorExists = $this->checkColorExistence($name, $formColor['colorCode']->getData());
            if (!$colorExists) {
                $this->persistObject($color);
                return $this->returnRender($formProduct, $formColor, 'good');
            } else {
                return $this->returnRender($formProduct, $formColor, 'color');
            }
        }
        return $this->returnRender($formProduct, $formColor, '');
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
     * Vérifie le fait que le fichier importé soit bien une image.
     *
     * @param UploadedFile $uploadedFile
     *
     * @return bool|null
     */
    private function testImageFormat(UploadedFile $uploadedFile): ?bool
    {
        $extensionsAllowed = array('jpg', 'jpeg', 'png', 'gif');
        $extensionUploadedImage = $uploadedFile->guessExtension();
        return in_array($extensionUploadedImage, $extensionsAllowed);
    }

    /**
     * On donne un nom unique au fichier uploadé, et on le déplace dans le dossier
     * du projet qui contiendra les images.
     * Retourne le nouveau nom du fichier.
     *
     * @param UploadedFile $uploadedFile Fichier importé.
     *
     * @return string
     */
    private function imageProcessing(UploadedFile $uploadedFile): ?string
    {
        $imageName = $this->generateUniqueFileName() . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move($this->getParameter('balls_directory'), $imageName);
        return $imageName;
    }

    /**
     * Génère un nom aléatoire et complexe pour le fichier importé.
     *
     * @return null|string
     */
    private function generateUniqueFileName(): ?string
    {
        return md5(uniqid());
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
     * Vérifie l'existence de la couleur en base de données.
     *
     * @param string $name Nom de la couleur
     * @param string $colorCode Code de la couleur
     *
     * @return bool
     */
    private function checkColorExistence(string $name, string $colorCode)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Color::class);
        $result = $repository->findOneBy(
            array(
                'name' => $name,
                'colorCode' => $colorCode
            )
        );
        return $result !== null;
    }

    /**
     * Renvoie le message approprié en fonction du besoin.
     *
     * @param FormInterface $formProduct Formulaire de création de produits.
     * @param FormInterface $formColor Formulaire de création de couleurs.
     * @param string $alert
     *
     * @return Response
     */
    private function returnRender(FormInterface $formProduct, FormInterface $formColor,string $alert): ?Response
    {
        if ($alert === 'good') {
            $render = $this->render(
                'registration_product/registration_product.html.twig',array(
                    'formProduct' => $formProduct->createView(),
                    'formColor' => $formColor->createView(),
                    'textAlert' => 'Le produit a bien été enregistré.',
                    'classAlert' => 'alert-success'
                )
            );
        } elseif ($alert === 'reference') {
            $render = $this->render(
                'registration_product/registration_product.html.twig',array(
                    'formProduct' => $formProduct->createView(),
                    'formColor' => $formColor->createView(),
                    'textAlert' => 'La référence saisie est déjà associée à un produit.',
                    'classAlert' => 'alert-warning'
                )
            );
        } elseif ($alert === 'name') {
            $render = $this->render(
                'registration_product/registration_product.html.twig',array(
                    'formProduct' => $formProduct->createView(),
                    'formColor' => $formColor->createView(),
                    'textAlert' => 'Le nom saisi est déjà associé à un produit.',
                    'classAlert' => 'alert-warning'
                )
            );
        } elseif ($alert === 'quantity') {
            $render = $this->render(
                'registration_product/registration_product.html.twig',array(
                    'formProduct' => $formProduct->createView(),
                    'formColor' => $formColor->createView(),
                    'textAlert' => 'La quantité disponible saisie doit être supérieure à zéro.',
                    'classAlert' => 'alert-warning'
                )
            );
        } elseif ($alert === 'image') {
            $render = $this->render(
                'registration_product/registration_product.html.twig',array(
                    'formProduct' => $formProduct->createView(),
                    'formColor' => $formColor->createView(),
                    'textAlert' => 'L\'image importée doit être une image.',
                    'classAlert' => 'alert-warning'
                )
            );
        } elseif ($alert === 'color') {
            $render = $this->render(
                'registration_product/registration_product.html.twig', array(
                    'formProduct' => $formProduct->createView(),
                    'formColor' => $formColor->createView(),
                    'textAlert' => 'La couleur a déjà été enregistrée.',
                    'classAlert' => 'alert-warning'
                )
            );
        } else {
            $render = $this->render(
                'registration_product/registration_product.html.twig',array(
                    'formProduct' => $formProduct->createView(),
                    'formColor' => $formColor->createView()
                )
            );
        }
        return $render;
    }
}