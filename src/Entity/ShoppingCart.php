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
     * Date de création du panier.
     *
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

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
     * Produits dans le panier.
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Product")
     */
    private $products;

    /**
     * Client à qui appartient le panier.
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Customer", mappedBy="shoppingCart", cascade={"persist", "remove"})
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTimeInterface $creationDate
     *
     * @return ShoppingCart
     */
    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    /**
     * @param float $totalPrice
     *
     * @return ShoppingCart
     */
    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProductQuantity(): ?int
    {
        return $this->productQuantity;
    }

    /**
     * @param int $productQuantity
     *
     * @return ShoppingCart
     */
    public function setProductQuantity(int $productQuantity): self
    {
        $this->productQuantity = $productQuantity;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    /**
     * @param bool $isConfirmed
     *
     * @return ShoppingCart
     */
    public function setIsConfirmed(bool $isConfirmed): self
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param Product $product
     *
     * @return ShoppingCart
     */
    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    /**
     * @param Product $product
     *
     * @return ShoppingCart
     */
    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }

        return $this;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
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