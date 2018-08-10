<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product.
 *
 * @ORM\MappedSuperclass()
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     *
     * @return Product
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Product
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string $image
     *
     * @return Product
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsNew(): ?bool
    {
        return $this->isNew;
    }

    /**
     * @param bool $isNew
     *
     * @return Product
     */
    public function setIsNew(bool $isNew): self
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
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
     * @return float|null
     */
    public function getPriceIndividuals(): ?float
    {
        return $this->priceIndividuals;
    }

    /**
     * @param float $priceIndividuals
     *
     * @return Product
     */
    public function setPriceIndividuals(float $priceIndividuals): self
    {
        $this->priceIndividuals = $priceIndividuals;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPriceProfessionals(): ?float
    {
        return $this->priceProfessionals;
    }

    /**
     * @param float $priceProfessionals
     *
     * @return Product
     */
    public function setPriceProfessionals(float $priceProfessionals): self
    {
        $this->priceProfessionals = $priceProfessionals;

        return $this;
    }
}