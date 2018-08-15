<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController.
 *
 * @category Symfony4
 * @package App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class HomeController extends AbstractController
{
    /**
     * Affiche la page d'accueil.
     *
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home.html.twig');
    }
}