<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class State.
 *
 * @ORM\Entity(repositoryClass="App\Repository\StateRepository")
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class State
{
    /**
     * ID de l'état.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Date de création de l'état.
     *
     * @ORM\Column(type="datetime")
     */
    private $stateDate;

    /**
     * Liste des produist de l'état.
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\ShoppingCartProduct", mappedBy="state")
     */
    private $shoppingCartProducts;

    /**
     * Etat de remplissage de l'état.
     * 
     * @ORM\Column(type="boolean")
     */
    private $isFull;

    /**
     * Etat de validation de l'état.
     * 
     * @ORM\Column(type="boolean")
     */
    private $isValidate;

    /**
     * Taille de l'état.
     * 
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * Quantité de balles dans l'état.
     * 
     * @ORM\Column(type="integer")
     */
    private $ballQuantity;

    /**
     * ShoppingCartProduct constructor.
     */
    public function __construct()
    {
        $this->shoppingCartProducts = new ArrayCollection();
    }

    /**
     * Accesseur de l'ID de l'état.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Accesseur de la date de création de l'état.
     *
     * @return \DateTimeInterface|null
     */
    public function getStateDate(): ?\DateTimeInterface
    {
        return $this->stateDate;
    }

    /**
     * Mutateur de la date de création de l'état.
     *
     * @param \DateTimeInterface $stateDate Date de création à attribuer à l'état.
     *
     * @return State
     */
    public function setStateDate(\DateTimeInterface $stateDate): self
    {
        $this->stateDate = $stateDate;

        return $this;
    }

    /**
     * Accesseur de la liste des produits présents dans l'état.
     * 
     * @return Collection|ShoppingCartProduct[]
     */
    public function getShoppingCartProducts(): Collection
    {
        return $this->shoppingCartProducts;
    }

    /**
     * Ajoute un produit à l'état.
     * 
     * @param ShoppingCartProduct $shoppingCartProduct Produit à ajouter à l'état.
     * 
     * @return State
     */
    public function addShoppingCartProduct(ShoppingCartProduct $shoppingCartProduct): self
    {
        if (!$this->shoppingCartProducts->contains($shoppingCartProduct)) {
            $this->shoppingCartProducts[] = $shoppingCartProduct;
            $shoppingCartProduct->setState($this);
        }

        return $this;
    }

    /**
     * Supprime un produit de l'état.
     * 
     * @param ShoppingCartProdutc $shoppingCartProduct Produit à supprimer de l'état.
     * 
     * @return State
     */
    public function removeShoppingCartProduct(ShoppingCartProduct $shoppingCartProduct): self
    {
        if ($this->shoppingCartProducts->contains($shoppingCartProduct)) {
            $this->shoppingCartProducts->removeElement($shoppingCartProduct);
            // set the owning side to null (unless already changed)
            if ($shoppingCartProduct->getState() === $this) {
                $shoppingCartProduct->setState(null);
            }
        }

        return $this;
    }

    /**
     * Accesseur de l'état de remplissage de l'état.
     * 
     * @return bool|null
     */
    public function getIsFull(): ?bool
    {
        return $this->isFull;
    }

    /**
     * Mutateur de l'état de remplissage de l'état.
     * 
     * @param bool $isFull Etat de remplissage à attribuer à l'état.
     * 
     * @return State
     */
    public function setIsFull(bool $isFull): self
    {
        $this->isFull = $isFull;

        return $this;
    }

    /**
     * Accesseur de l'état de validation de l'état.
     * 
     * @return bool|return
     */
    public function getIsValidate(): ?bool
    {
        return $this->isValidate;
    }

    /**
     * Mutateur de l'état de validation de l'état.
     * 
     * @param bool $isValidate Etat de validation à attribuer à l'état.
     * 
     * @return State
     */
    public function setIsValidate(bool $isValidate): self
    {
        $this->isValidate = $isValidate;

        return $this;
    }

    /**
     * Accesseur de la taille de l'état.
     * 
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * Mutateur de la taille de l'état.
     * 
     * @param int $size Taille à attribuer à l'état.
     * 
     * @return State
     */
    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Accesseur de la quantité de balles dans l'état.
     * 
     * @return int|null
     */
    public function getBallQuantity(): ?int
    {
        return $this->ballQuantity;
    }

    /**
     * Mutateur de la quantité de balles.
     * 
     * @param int $ballQuantity Quantité de balles à attribuer à l'état.
     * 
     * @return State
     */
    public function setBallQuantity(int $ballQuantity): self
    {
        $this->ballQuantity = $ballQuantity;

        return $this;
    }
}