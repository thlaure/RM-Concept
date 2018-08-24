<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"balle" = "Ball"})
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
abstract class Product
{
    /**
     * ID du produit.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Nom du produit.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * Référence du produit.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * Description du produit.
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * Image du produit.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * Etat de nouveauté du produit.
     *
     * @ORM\Column(type="boolean")
     */
    private $isNew;

    /**
     * Quantité disponible du produit.
     *
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * Prix du produit pour particuliers.
     *
     * @ORM\Column(type="float")
     */
    private $priceIndividuals;

    /**
     * Prix du produit pour professionnels.
     *
     * @ORM\Column(type="float")
     */
    private $priceProfessionals;

    /**
     * Accesseur de l'ID du produit.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Accesseur du nom du produit.
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Mutateur du nom du produit.
     *
     * @param string $name Nom à attribuer au produit.
     *
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Accesseur de la référence du produit.
     *
     * @return null|string
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * Mutateur de la référence du produit.
     *
     * @param string $reference Référence à attribuer au produit.
     *
     * @return Product
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Accesseur de la description du produit.
     *
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Mutateur de la description du produit.
     *
     * @param string $description description à attribuer au produit.
     *
     * @return Product
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Accesseur de l'image du produit.
     *
     * @return null|string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Mutateur de l'image du produit.
     *
     * @param string $image Image à attribuer au produit.
     *
     * @return Product
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Accesseur de l'état de nouveauté du produit.
     *
     * @return bool|null
     */
    public function getIsNew(): ?bool
    {
        return $this->isNew;
    }

    /**
     * Mutateur de l'état de nouveauté du produit.
     *
     * @param bool $isNew Etat de nouveauté à attribuer au produit.
     *
     * @return Product
     */
    public function setIsNew(bool $isNew): self
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * Accesseur de la quantité disponible du produit.
     *
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * Mutateur de la quantité disponible du produit.
     *
     * @param int $quantity
     *
     * @return Product
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Accesseur du prix du produit pour particuliers.
     *
     * @return float|null
     */
    public function getPriceIndividuals(): ?float
    {
        return $this->priceIndividuals;
    }

    /**
     * Mutateur du prix du produit pour particuliers.
     *
     * @param float $priceIndividuals Prix pour particuliers à attribuer au produit.
     *
     * @return Product
     */
    public function setPriceIndividuals(float $priceIndividuals): self
    {
        $this->priceIndividuals = $priceIndividuals;

        return $this;
    }

    /**
     * Accesseur du prix du produit pour les professionnels.
     *
     * @return float|null
     */
    public function getPriceProfessionals(): ?float
    {
        return $this->priceProfessionals;
    }

    /**
     * MUutateur du prix du produit pour professionnels.
     *
     * @param float $priceProfessionals  Prix pour professionnels à attribuer au produit.
     *
     * @return Product
     */
    public function setPriceProfessionals(float $priceProfessionals): self
    {
        $this->priceProfessionals = $priceProfessionals;

        return $this;
    }
}