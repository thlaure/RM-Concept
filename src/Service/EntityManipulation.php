<?php

namespace App\Service;

use App\Entity\Ball;
use App\Entity\Command;
use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\ShoppingCart;
use App\Entity\ShoppingCartProduct;
use App\Entity\State;
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
     * Renvoie un tableau de données avec tous les produits dont le nom est passé en paramètre.
     *
     * @param string $name Nom du produit à récupérer.
     *
     * @return array
     */
    public function findProductsByName(string $name): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Product::class);
        $result = $repository->findBy(array(
            'name' => $name
        ));
        return $result;
    }

    /**
     * Renvoie un tableau de données avec tous les produits dont les critères sont passés en paramètres.
     *
     * @param int $numberInPack
     *
     * @return array
     */
    public function findProductsByNumberInPack(int $numberInPack): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Ball::class);
        $result = $repository->findBy(array(
            'numberInPack' => $numberInPack
        ));
        return $result;
    }

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
     * Renvoie un tableau de données contenant toutes les balles en base de données.
     *
     * @return Ball[]|object[]
     */
    public function findAllBalls(): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Ball::class);
        $result = $repository->findAll();
        return $result;
    }

    /**
     * Renvoie l'état dont l'ID est passé en paramètre.
     *
     * @param int $id ID de l'état à récupérer.
     *
     * @return State|null
     */
    public function findOneStateById(int $id): ?State
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(State::class);
        $result = $repository->findOneBy(array(
            'id' => $id
        ));
        return $result;
    }

    /**
     * Renvoie un tableau de données avec les états triés par date.
     *
     * @return array
     */
    public function findAllStatesOrderByDate():array
    {
        $repository = $this->getDoctrine()->getRepository(State::class);
        $result = $repository->findAllStatesOrderByDate();
        return $result;
    }

    /**
     * Récupère l'objet Product dont la référence est passée en paramètre.
     *
     * @param string $reference Référence du produit que l'on veut récupérer.
     *
     * @return Product|null|object
     */
    public function findOneProductByReference(string $reference): ?Product
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Product::class);
        $result = $repository->findOneBy(array(
            'reference' => $reference
        ));
        return $result;
    }

    /**
     * Renvoie la ligne du panier contenant le produit passée en paramètre.
     *
     * @param Product $product Produit qu'il faut récupérer dans le panier.
     *
     * @return ShoppingCartProduct|null|object
     */
    public function findOneProductByCart(Product $product): ?ShoppingCartProduct
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(ShoppingCartProduct::class);
        $result = $repository->findOneBy(array(
            'product' => $product
        ));
        return $result;
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
     * Renvoie un tableau de données contenant les produits du client et du panier passés en paramètres
     * dont l'état est non assigné.
     *
     * @param ShoppingCart $shoppingCart
     *
     * @return array
     */
    public function findProductsByStateIsNull(ShoppingCart $shoppingCart): array
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(ShoppingCartProduct::class);
        $result = $repository->findBy(array(
            'shoppingCart' => $shoppingCart,
            'state' => null
        ));
        return $result;
    }

    /**
     * Renvoie un tableau de données contenant l'état non plein en base de données.
     *
     * @return State
     */
    public function findOneStateByIsNotFull(): State
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(State::class);
        $result = $repository->findOneBy(array(
            'isFull' => false
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
     * Instancie un objet de la classe State;
     *
     * @return State|null
     */
    public function createState(): ?State
    {
        $state = new State();
        $state->setBallQuantity(0);
        $state->setIsFull(false);
        $state->setIsValidate(false);
        $state->setSize(36);
        $state->setStateDate(new \DateTime());
        return $state;
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