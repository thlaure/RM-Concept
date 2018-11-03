<?php

namespace App\Controller;

use App\Service\EntityManipulation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminStateController.
 *
 * @category Symfony4
 * @package App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class AdminStateController extends AbstractController
{
    /**
     * Affiche les tous les états et permet d'accéder à leur détail.
     *
     * @Route("/admin/state", name="admin_state")
     *
     * @param EntityManipulation $entityManipulation
     *
     * @return Response
     */
    public function AdminState(EntityManipulation $entityManipulation): ?Response
    {
        $states = $entityManipulation->findAllStatesOrderByDate();
        return $this->render(
            'admin_state/admin_state.html.twig', array(
                'states' => $states
            )
        );
    }
}