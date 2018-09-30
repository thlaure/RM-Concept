<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ShoppingCartProduct.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ShoppingCartProductRepository")
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class ShoppingCartProduct
{
    /**
     * ID de l'entité intermédiaire.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Panier concerné.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ShoppingCart")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shoppingCart;

    /**
     * produit concerné.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * Quantité du produit concerné dans le panier concerné.
     *
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * Etat de personnalisation du produit concerné.
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isCustomized;

    /**
     * Prix total par rapport à la quantité voulue.
     *
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * Image qui a servi à personnaliser le produit.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $customizationImage;

    /**
     * Etat auquel appartient le produit.
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\State", inversedBy="shoppingCartProducts")
     */
    private $state;

    /**
     * Accesseur de l'ID de la classe intermédiaire.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Accesseur du panier concerné.
     *
     * @return ShoppingCart|null
     */
    public function getShoppingCart(): ?ShoppingCart
    {
        return $this->shoppingCart;
    }

    /**
     * Mutateur du panier concerné.
     *
     * @param ShoppingCart|null $shoppingCart Panier à attribuer à l'netité intermédiaire.
     *
     * @return ShoppingCartProduct
     */
    public function setShoppingCart(?ShoppingCart $shoppingCart): self
    {
        $this->shoppingCart = $shoppingCart;

        return $this;
    }

    /**
     * Accesseur du produit concerné.
     *
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * Mutateur du produit concerné.
     *
     * @param Product|null $product Produit à attribuer au panier concerné.
     *
     * @return ShoppingCartProduct
     */
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Accesseur de la quantité du produit concerné dans le panier concerné.
     *
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * Mutateur de la quantité du produit concerné dans le panier concerné.
     *
     * @param int $quantity Quantité du produi concerné à attribuer au panier concerné.
     *
     * @return ShoppingCartProduct
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Accesseur de l'état de personnalisation du produit concerné.
     *
     * @return bool|null
     */
    public function getIsCustomized(): ?bool
    {
        return $this->isCustomized;
    }

    /**
     * Mutateur de l'état de peersonnalisation du produit concerné.
     *
     * @param bool|null $isCustomized Etat de personnalisation à attribuer au produit concerné.
     *
     * @return ShoppingCartProduct
     */
    public function setIsCustomized(?bool $isCustomized): self
    {
        $this->isCustomized = $isCustomized;

        return $this;
    }

    /**
     * Accesseur du prix par rapport à la quantité voulue.
     *
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * Mutateur du prix par rapport à la quantité voulue.
     *
     * @param float $price Prix à attribuer.
     *
     * @return ShoppingCartProduct
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Accesseur de l'image de personnalisation du produit.
     *
     * @return null|string
     */
    public function getCustomizationImage(): ?string
    {
        return $this->customizationImage;
    }

    /**
     * Mutateur de l'image de personnlisation du produit.
     *
     * @param null|string $customizationImage Image à attribuer au produit.
     *
     * @return ShoppingCartProduct
     */
    public function setCustomizationImage(?string $customizationImage): self
    {
        $this->customizationImage = $customizationImage;

        return $this;
    }

    /**
     * Accesseur de l'état auquel appartient le produit.
     *
     * @return State|null
     */
    public function getState(): ?State
    {
        return $this->state;
    }

    /**
     * Mutateur de l'état auquel appartient le produit.
     *
     * @param State|null $state Etat à attribuer au produit.
     *
     * @return ShoppingCartProduct
     */
    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }
}