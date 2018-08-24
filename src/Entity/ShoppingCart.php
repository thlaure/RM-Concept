<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ShoppingCart.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ShoppingCartRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="confirmed", type="string")
 * @ORM\DiscriminatorMap({"confirmed" = "ShoppingCartConfirmed", "notConfirmed" = "ShoppingCartNotConfirmed"})
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
abstract class ShoppingCart
{
    /**
     * ID du panier.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Prix total du panier.
     *
     * @ORM\Column(type="float")
     */
    private $totalPrice;

    /**
     * Quantité de produits dans le panier.
     *
     * @ORM\Column(type="integer")
     */
    private $productQuantity;

    /**
     * Etat de confirmation du panier.
     *
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    /**
     * Client à qui appartient le panier.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="shoppingCarts")
     *
     */
    private $customer;

    /**
     * Etat de sauvegarde du panier.
     *
     * @ORM\Column(type="boolean")
     */
    private $isSaved;

    /**
     * Commande liée au panier.
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Command", cascade={"persist", "remove"})
     */
    private $command;

    /**
     * Accesseur de l'ID du Panier.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Accesseur du prix total du panier.
     *
     * @return float|null
     */
    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    /**
     * Mutateur du prix total du panier.
     *
     * @param float $totalPrice Prix total à attribuer au panier.
     *
     * @return ShoppingCart
     */
    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Accesseur de la quantité de produits qu'il y a dans le panier.
     *
     * @return int|null
     */
    public function getProductQuantity(): ?int
    {
        return $this->productQuantity;
    }

    /**
     * Mutateur de la quantité de produits qu'il y a dans le panier.
     *
     * @param int $productQuantity Quantité de produits à attribuer au panier.
     *
     * @return ShoppingCart
     */
    public function setProductQuantity(int $productQuantity): self
    {
        $this->productQuantity = $productQuantity;

        return $this;
    }

    /**
     * Accesseur de l'état de confirmation du panier.
     *
     * @return bool|null
     */
    public function getIsConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    /**
     * Mutateur de l'état de confirmation du panier.
     *
     * @param bool $isConfirmed Etat de confirmation à attribuer au panier.
     *
     * @return ShoppingCart
     */
    public function setIsConfirmed(bool $isConfirmed): self
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    /**
     * Accesseur de l'état de sauvegarde du panier.
     *
     * @return bool|null
     */
    public function getIsSaved(): ?bool
    {
        return $this->isSaved;
    }

    /**
     * Mutateur de l'état de sauvegarde du panier.
     *
     * @param bool $isSaved Etat de sauvegarde à attribuer au panier.
     *
     * @return ShoppingCart
     */
    public function setIsSaved(bool $isSaved): self
    {
        $this->isSaved = $isSaved;

        return $this;
    }

    /**
     * Accesseur de la commande liée au panier.
     *
     * @return Command|null
     */
    public function getCommand(): ?Command
    {
        return $this->command;
    }

    /**
     * Mutateur de la commande liée au panier.
     *
     * @param Command|null $command Commande à attribuer au panier.
     *
     * @return ShoppingCart
     */
    public function setCommand(?Command $command): self
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Accesseur du client lié au panier.
     *
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * Mutateur du client lié au panier.
     *
     * @param Customer|null $customer Client à attribuer au panier.
     *
     * @return ShoppingCart
     */
    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}