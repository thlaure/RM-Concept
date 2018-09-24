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
     * Liste des produits dans l'état.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\ShoppingCartProduct", mappedBy="state")
     */
    private $shoppingCartProducts;

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
     * Accesseur de la liste des produits de l'état.
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
     * @param ShoppingCartProduct $shoppingCartProduct produit à ajouter à l'état.
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
     * @param ShoppingCartProduct $shoppingCartProduct Produit à supprimer de l'état.
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
}