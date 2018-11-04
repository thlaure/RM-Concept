<?php

namespace App\Controller;

use App\Service\EntityManipulation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminStateController.
 *
 * @IsGranted("ROLE_ADMIN")
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
    public function adminState(EntityManipulation $entityManipulation): ?Response
    {
        $states = $entityManipulation->findAllStatesOrderByDate();
        return $this->render(
            'admin_state/admin_state.html.twig', array(
                'states' => $states
            )
        );
    }

    /**
     * Envoie en production l'état choisi.
     *
     * @Route("/admin/state/run-in-production/{id}", name="run-state-in-production")
     *
     * @param integer $id ID de l'état choisi.
     * @param EntityManipulation $entityManipulation
     *
     * @return null|Response
     */
    public function runStateInProduction(int $id, EntityManipulation $entityManipulation): ?Response
    {
        $states = $entityManipulation->findAllStatesOrderByDate();
        $state = $entityManipulation->findOneStateById($id);
        if ($state->getBallQuantity() > 0 && $state->getBallQuantity() <= 36) {
            $state->setIsInProduction(true);
            return $this->render('admin_state/admin_state.html.twig', array(
                'text_alert' => 'L\'état est envoyé en production.',
                'class_alert' => 'alert-success',
                'states' => $states
            ));
        } else {
            return $this->render('admin_state/admin_state.html.twig', array(
                'text_alert' => 'L\'état choisi ne peut être envoyé en production à cause du nombre de balles trop petit.',
                'class_alert' => 'alert-warning',
                'states' => $states
            ));
        }
    }

    /**
     * Valide l'état choisi.
     *
     * @Route("/admin/state/validate/{id}", name="validate-state")
     *
     * @param int $id ID de l'état choisi.
     * @param EntityManipulation $entityManipulation
     *
     * @return null|Response
     */
    public function validateState(int $id, EntityManipulation $entityManipulation): ?Response
    {
        $states = $entityManipulation->findAllStatesOrderByDate();
        $state = $entityManipulation->findOneStateById($id);
        if ($state->getIsInProduction() === true) {
            $state->setIsValidate(true);
            return $this->render('admin_state/admin_state.html.twig', array(
                'text_alert' => 'L\'état a bien été validé.',
                'class_alert' => 'alert-success',
                'states' => $states
            ));
        } else {
            return $this->render('admin_state/admin_state.html.twig', array(
                'text_alert' => 'L\'état ne peut pas être validé car il n\'a pas été mis en production.',
                'class_alert' => 'alert-warning',
                'states' => $states
            ));
        }
    }

    /**
     * Affiche le détail de l'état choisi.
     *
     * @Route("/admin/state/detail/{id}", name="state_detail")
     *
     * @param int $id ID de l'état à récupérer.
     * @param EntityManipulation $entityManipulation
     *
     * @return null|Response
     */
    public function stateDetail(int $id, EntityManipulation $entityManipulation): ?Response
    {
        $state = $entityManipulation->findOneStateById($id);
        $shoppingCartProducts = $state->getShoppingCartProducts();
        return $this->render('admin_state/state_detail.html.twig', array(
            'shopping_cart_products' => $shoppingCartProducts,
            'state' => $state
        ));
    }
}