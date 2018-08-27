<?php

namespace App\Service;

use App\Entity\Ball;
use App\Entity\ShoppingCart;
use App\Entity\ShoppingCartProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class EntityManipulation.
 *
 * @category Symfony4
 * @package App\Service
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class EntityManipulation extends AbstractController
{
    /**
     * Renvoie un tableau avec tous les produits présents dans le panier passé en paramètre.
     *
     * @param ShoppingCart $shoppingCart Panier dont on veut récupérer le contenu.
     *
     * @return Ball[]|ShoppingCartProduct[]|object[]
     */
    public function findAllProductsInCart(ShoppingCart $shoppingCart): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(ShoppingCartProduct::class);
        $result = $repository->findBy(array(
            'shoppingCart' => $shoppingCart
        ));
        return $result;
    }

    /**
     * Réinitialise le panier passé en paramètre.
     *
     * @param ShoppingCart $shoppingCart Panier à réinitialiser.
     */
    public function resetShoppingCart(ShoppingCart $shoppingCart)
    {
        $shoppingCart->setTotalPrice(0);
        $shoppingCart->setProductQuantity(0);
        $this->persistObject($shoppingCart);
    }

    /**
     * Fait persister une entité en base de données.
     *
     * @param ? $object Entité à persister.
     */
    public function persistObject($object)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($object);
        $entityManager->flush();
    }

    /**
     * Supprime une entité.
     *
     * @param ? $object Entité à supprimer.
     */
    public function removeObject($object)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($object);
        $entityManager->flush();
    }
}