<?php

namespace App\Controller;

use App\Entity\Customer;
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
     * Supprime les produits du panier non confirmé et réinitialise ce dernier avant de déconnecter le client.
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
        $shoppingCart = $this->findShoppingCartNotConfirmed($customer);
        if (!$shoppingCart->getIsConfirmed()) {
            $this->removeAllShoppingCartProducts($shoppingCart);
            $this->resetShoppingCart($shoppingCart);
        }
        return $this->render('security/logout.html.twig', array(
            'error' => ''
        ));
    }

    /**
     * Renvoie le panier non confirmé du client passé en paramètre.
     *
     * @param Customer $customer Client lié au panier.
     *
     * @return ShoppingCart|null
     */
    private function findShoppingCartNotConfirmed(Customer $customer): ?ShoppingCart
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(ShoppingCart::class);
        $result = $repository->findOneBy(array(
            'customer' => $customer,
            'isConfirmed' => false
        ));
        return $result;
    }

    /**
     * Supprime toutes les données présentes dans le panier passé en paramètre.
     *
     * @param ShoppingCart $shoppingCart Panier dont on veut supprimer les données.
     */
    private function removeAllShoppingCartProducts(ShoppingCart $shoppingCart): void
    {
        $shoppingCartsProducts = $this->findAllShoppingCartProducts($shoppingCart);
        foreach ($shoppingCartsProducts as $shoppingCartProduct) {
            $this->removeObject($shoppingCartProduct);
        }
    }

    /**
     * Supprime une entité.
     *
     * @param ? $object Entité que l'on souhaite supprimer.
     */
    private function removeObject($object): void
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
    private function findAllShoppingCartProducts(ShoppingCart $shoppingCart): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(ShoppingCartProduct::class);
        $result = $repository->findBy(array(
            'shoppingCart' => $shoppingCart
        ));
        return $result;
    }
}