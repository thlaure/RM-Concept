<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminHomeController.
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @category Symfony4
 * @package App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class AdminHomeController extends AbstractController
{
    /**
     * Affiche la page d'accueil de l'interface d'administration.
     *
     * @Route("/admin", name="admin_home")
     */
    public function AdminHome()
    {
        return $this->render('admin_home/admin_home.html.twig');
    }
}