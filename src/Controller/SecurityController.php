<?php

namespace App\Controller;

use App\Entity\ShoppingCart;
use App\Service\EntityManipulation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController.
 *
 * @category Symfony4
 * @package  App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class SecurityController extends AbstractController
{
    /**
     * Affiche la page de login.
     *
     * @Route("/login", name="login")
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): ?Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render(
            'security/login.html.twig', array(
                'last_username' => $lastUsername,
                'error' => $error
            )
        );
    }

    /**
     * Affiche une page après déconnexion du client.
     *
     * @Route("/logout", name="logout")
     *
     * @return Response
     */
    public function logout(): ?Response
    {
        return $this->render(
            'security/logout.html.twig'
        );
    }

    /**
     * Supprime les produits du panier non confirmé et réinitialise ce dernier avant de déconnecter le client.
     *
     * @Route("/prelogout", name="pre_logout")
     *
     * @param Security $security
     * @param EntityManipulation$entityManipulation
     *
     * @return Response
     */
    public function preLogout(Security $security, EntityManipulation $entityManipulation): ?Response
    {
        $customer = $security->getUser();
        $shoppingCart = $customer->getShoppingCartNotConfirmed();
        $this->removeAllShoppingCartProducts($shoppingCart, $entityManipulation);
        $entityManipulation->resetShoppingCart($shoppingCart);
        return $this->render('security/logout.html.twig', array(
            'error' => ''
        ));
    }

    /**
     * Supprime toutes les données présentes dans le panier passé en paramètre.
     *
     * @param ShoppingCart $shoppingCart Panier dont on veut supprimer les données.
     * @param EntityManipulation $entityManipulation
     */
    private function removeAllShoppingCartProducts(ShoppingCart $shoppingCart, EntityManipulation $entityManipulation): void
    {
        $shoppingCartsProducts = $entityManipulation->findProductsByCart($shoppingCart);
        foreach ($shoppingCartsProducts as $shoppingCartProduct) {
            $entityManipulation->removeObject($shoppingCartProduct);
        }
    }
}