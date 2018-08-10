<?php

namespace App\Controller;

use App\Entity\Ball;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @return null|Response
     */
    public function shop(): ?Response
    {
        return $this->render('shop/customizable_balls.html.twig', [
            'products' => $this->findAllBalls()
        ]);
    }

    /**
     * Affiche l'espace entreprise.
     *
     * @Route("/shop/company-area", name="shop_company-area")
     *
     * @return null|Response
     */
    public function companyShop(): ?Response
    {
        return $this->render('shop/company-area.html.twig', [
            'products' => $this->findAllBalls()
        ]);
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
}