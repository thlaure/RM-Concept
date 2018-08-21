<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Command.
 * 
 * @ORM\Entity(repositoryClass="App\Repository\CommandRepository")
 * 
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class Command
{
    /**
     * ID de la commande.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Date de la commande.
     * 
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * Coût total de la commande.
     * 
     * @ORM\Column(type="float")
     */
    private $totalPrice;

    /**
     * Référence de la commande.
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * Adresse de livraison de la commande.
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $deliveryAddress;

    /**
     * Complément de l'adresse de livraison de la commande.
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deliveryComplementAddress;

    /**
     * Ville de livraison de la commande.
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $deliveryCity;

    /**
     * Code postal de livraison de la commande.
     * 
     * @ORM\Column(type="string", length=5)
     */
    private $deliveryPostalCode;

    /**
     * Transporteur de la commande.
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Haulier")
     */
    private $haulier;

    /**
     * Particulier de la commande.
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Individual", inversedBy="commands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $individual;

    /**
     * Accesseur de l'ID de la commande.
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Accesseur de la date de la commande.
     *
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Mutateur de la date de la commande.
     *
     * @param \DateTimeInterface $date Date à attribuer à la commande.
     * 
     * @return self
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Accesseur du coût total de la commande.
     *
     * @return float|null
     */
    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    /**
     * Mutateur du coût total de la commande.
     *
     * @param float $totalPrice Coût total à attribuer à la commande.
     * 
     * @return self
     */
    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Accesseur de la référence de la commande.
     *
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * Mutateur de la référence de la commande.
     *
     * @param string $reference Référence à attribuer à la commande.
     * 
     * @return self
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Accesseur de l'adresse de livraison de la commande.
     *
     * @return string|null
     */
    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    /**
     * Mutateur de l'adresse de livraison de la commande.
     *
     * @param string $deliveryAddress Adresse de livraison à attribuer à la commande.
     * 
     * @return self
     */
    public function setDeliveryAddress(string $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * Accesseur du complément d'adresse de la livraison.
     *
     * @return string|null
     */
    public function getDeliveryComplementAddress(): ?string
    {
        return $this->deliveryComplementAddress;
    }

    /**
     * Mutateur du complément d'adresse de la livraison.
     *
     * @param string|null $deliveryComplementAddress Complément d'adresse de livraison à attribuer à la commande.
     * 
     * @return self
     */
    public function setDeliveryComplementAddress(?string $deliveryComplementAddress): self
    {
        $this->deliveryComplementAddress = $deliveryComplementAddress;

        return $this;
    }

    /**
     * Accesseur de la ville de livraison de la commande.
     *
     * @return string|null
     */
    public function getDeliveryCity(): ?string
    {
        return $this->deliveryCity;
    }

    /**
     * Mutateur de la ville de livraison de la commande.
     *
     * @param string $deliveryCity Ville de livraison à attribuer à la commande.
     * 
     * @return self
     */
    public function setDeliveryCity(string $deliveryCity): self
    {
        $this->deliveryCity = $deliveryCity;

        return $this;
    }

    /**
     * Accesseur du code postal de livraison de la commande.
     *
     * @return string|null
     */
    public function getDeliveryPostalCode(): ?string
    {
        return $this->deliveryPostalCode;
    }

    /**
     * Mutateur du code postal de livraison de la commande.
     *
     * @param string $deliveryPostalCode Code postal de livraison à attribuer à la commande.
     * 
     * @return self
     */
    public function setDeliveryPostalCode(string $deliveryPostalCode): self
    {
        $this->deliveryPostalCode = $deliveryPostalCode;

        return $this;
    }

    /**
     * Accesseur du transporteur de la commande.
     *
     * @return Haulier|null
     */
    public function getHaulier(): ?Haulier
    {
        return $this->haulier;
    }

    /**
     * Mutateur du transporteur de la commande.
     *
     * @param Haulier|null $haulier Transporteur à attribuer à la commande.
     * 
     * @return self
     */
    public function setHaulier(?Haulier $haulier): self
    {
        $this->haulier = $haulier;

        return $this;
    }

    /**
     * Accesseur du particulier à qui appartient la commande.
     *
     * @return Individual|null
     */
    public function getIndividual(): ?Individual
    {
        return $this->individual;
    }

    /**
     * Mutateur du particulier à qui appartient la commande.
     *
     * @param Individual|null $individual Particulier à attribuer à la commande.
     * 
     * @return self
     */
    public function setIndividual(?Individual $individual): self
    {
        $this->individual = $individual;

        return $this;
    }
}