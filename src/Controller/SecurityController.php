<?php

namespace App\Controller;

use App\Entity\ShoppingCart;
use App\Entity\ShoppingCartProduct;
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
     * Supprime les produits du panier et réinitialise ce dernier avant de déconnecter le client.
     *
     * @Route("/prelogout", name="pre_logout")
     *
     * @param Security $security
     *
     * @return Response
     */
    public function preLogout(Security $security): ?Response
    {
        $customer = $security->getUser();
        $shoppingCart = $customer->getShoppingCart();
        $this->deleteAllShoppingCartProduct($shoppingCart);
        $this->resetShoppingCart($shoppingCart);
        return $this->render('security/logout.html.twig', array(
            'error' => ''
        ));
    }

    /**
     * Supprime toutes les données présentes dans le panier passé en paramètre.
     *
     * @param ShoppingCart $shoppingCart Panier dont on veut supprimer les données.
     */
    private function deleteAllShoppingCartProduct(ShoppingCart $shoppingCart): void
    {
        $shoppingCartsProducts = $this->findAllShoppingCartProduct($shoppingCart);
        foreach ($shoppingCartsProducts as $shoppingCartProduct) {
            $this->deleteObject($shoppingCartProduct);
        }
    }

    /**
     * Supprime une entité.
     *
     * @param ? $object Entité que l'on souhaite supprimer.
     */
    private function deleteObject($object): void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($object);
        $entityManager->flush();
    }

    /**
     * Réinitialise le panier passé en paramètre.
     *
     * @param ShoppingCart $shoppingCart Panier à réinitialiser.
     */
    private function resetShoppingCart(ShoppingCart $shoppingCart)
    {
        $shoppingCart->setTotalPrice(0);
        $shoppingCart->setProductQuantity(0);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($shoppingCart);
        $entityManager->flush();
    }

    /**
     * Renvoie un tableau avec toutes les entités ShoppingCartProduct liées au panier passé en paramètre.
     *
     * @param ShoppingCart $shoppingCart Panier dont on veut récupérer les enregistrements liés.
     *
     * @return ShoppingCartProduct[]|object[]
     */
    private function findAllShoppingCartProduct(ShoppingCart $shoppingCart): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(ShoppingCartProduct::class);
        $result = $repository->findBy(array(
            'shoppingCart' => $shoppingCart
        ));
        return $result;
    }
}