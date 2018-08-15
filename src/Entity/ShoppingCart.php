<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ShoppingCart.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ShoppingCartRepository")
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class ShoppingCart
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
     * @ORM\OneToOne(targetEntity="App\Entity\Individual", mappedBy="shoppingCart", cascade={"persist", "remove"})
     */
    private $customer;

    /**
     * ShoppingCart constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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
     * Accesseur du client à qui le panier appartient.
     *
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * Mutateur du client à qui le panier appartient.
     *
     * @param Customer|null $customer Client à attribuer au panier.
     *
     * @return ShoppingCart
     */
    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        // set (or unset) the owning side of the relation if necessary
        $newShoppingCart = $customer === null ? null : $this;
        if ($newShoppingCart !== $customer->getShoppingCart()) {
            $customer->setShoppingCart($newShoppingCart);
        }

        return $this;
    }
}