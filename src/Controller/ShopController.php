<?php

namespace App\Controller;

use App\Entity\Ball;
use App\Entity\Customer;
use App\Entity\ShoppingCart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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
     * @param Security $security
     *
     * @return null|Response
     */
    public function shop(Security $security): ?Response
    {
        $customer = $security->getUser();
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($customer->getShoppingCart() === null) {
                $shoppingCart = $this->createShoppingCart($customer);
                $this->persistObject($shoppingCart);
            } else {
                $shoppingCart = $customer->getShoppingCart();
            }
            return $this->render('shop/customizable_balls.html.twig', [
                'products' => $this->findAllBalls(),
                'customer' => $customer,
                'shoppingCart' => $shoppingCart
            ]);
        }
        return $this->render('shop/customizable_balls.html.twig', [
            'products' => $this->findAllBalls(),
            'customer' => $customer
        ]);
    }

    /**
     * Affiche l'espace entreprise.
     *
     * @Route("/shop/company-area", name="shop_company-area")
     *
     * @param Security $security
     *
     * @return null|Response
     */
    public function companyShop(Security $security): ?Response
    {
        $customer = $security->getUser();
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $shoppingCart = $customer->getShoppingCart();
            return $this->render('shop/company-area.html.twig', [
                'products' => $this->findAllBalls(),
                'customer' => $customer,
                'shoppingCart' => $shoppingCart
            ]);
        }

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

    /**
     * Instancie la classe ShoppingCart.
     *
     * @param Customer $customer Client à qui appartient le panier.
     *
     * @return ShoppingCart
     */
    private function createShoppingCart(Customer $customer)
    {
        $shoppingCart = new ShoppingCart();
        $shoppingCart->setCreationDate(new \DateTime());
        $shoppingCart->setCustomer($customer);
        $shoppingCart->setProductQuantity(0);
        $shoppingCart->setIsConfirmed(false);
        $shoppingCart->setTotalPrice(0);
        return $shoppingCart;
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
}