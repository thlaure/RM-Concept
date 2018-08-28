<?php

namespace App\Service;

use App\Entity\Ball;
use App\Entity\Command;
use App\Entity\Customer;
use App\Entity\Product;
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
    public function findProductsByCart(ShoppingCart $shoppingCart): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(ShoppingCartProduct::class);
        $result = $repository->findBy(array(
            'shoppingCart' => $shoppingCart
        ));
        return $result;
    }

    /**
     * Instancie la classe ShoppingCart.
     *
     * @param Customer $customer Client à qui appartient le panier.
     *
     * @return ShoppingCart
     */
    public function createShoppingCart(Customer $customer): ?ShoppingCart
    {
        $shoppingCart = new ShoppingCart();
        $shoppingCart->setCustomer($customer);
        $shoppingCart->setProductQuantity(0);
        $shoppingCart->setIsConfirmed(false);
        $shoppingCart->setTotalPrice(0);
        return $shoppingCart;
    }

    /**
     * Renvoie un tableau de données contenant les commandes du client passé en paramètre.
     *
     * @param Customer $customer Client dont on veut récupérer les commandes.
     *
     * @return array
     */
    public function findCommandsByCustomer(Customer $customer): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Command::class);
        $result = $repository->findBy(array(
            'customer' => $customer,
            'isPaid' => true
        ));
        return $result;
    }

    /**
     * Renvoie la commande dont la référence est passée en paramètre.
     *
     * @param string $reference Référence de la commande à extraire.
     *
     * @return Command|null
     */
    public function findOneCommandByReference(string $reference): ?Command
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Command::class);
        $result = $repository->findOneBy(array(
            'reference' => $reference
        ));
        return $result;
    }

    /**
     * Renvoie un tableau de données contenant tous les produits.
     *
     * @return array
     */
    public function findAllProducts(): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Product::class);
        $result = $repository->findAll();
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