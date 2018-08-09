<?php

namespace App\Controller;

use App\Entity\Ball;
use App\Entity\Color;
use App\Form\ColorType;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationProductController.
 *
 * @package App\Controller
 */
class RegistrationProductController extends AbstractController
{
    /**
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
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ball);
            $entityManager->flush();
            return $this->render(
                'registration_product/registration_product.html.twig',array(
                    'formProduct' => $formProduct->createView(),
                    'formColor' => $formColor->createView()
                )
            );
        } elseif ($formColor->isSubmitted() && $formColor->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($color);
            $entityManager->flush();
            return $this->render(
                'registration_product/registration_product.html.twig',array(
                    'formProduct' => $formProduct->createView(),
                    'formColor' => $formColor->createView()
                )
            );
        }
        return $this->render(
            'registration_product/registration_product.html.twig',array(
                'formProduct' => $formProduct->createView(),
                'formColor' => $formColor->createView()
            )
        );
    }
}