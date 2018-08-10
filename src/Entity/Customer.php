<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Customer.
 *
 * @ORM\MappedSuperclass()
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
abstract class Customer
{
    /**
     * ID du client.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Nom du client. Dans le cas d'une entreprise, il s'agit du nom du contact.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * Prénom du client. Dans le cas d'une entreprise, il s'agit du prénom du contact.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * Référence du client.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * Adresse mail du client. Dans le cas d'une entreprise, il s'agit de l'adresse mail du contact.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * Numéro de téléphone du client. Dans le cas d'une entreprise, il s'agit du numéro de téléphone du contact.
     *
     * @ORM\Column(type="string", length=10)
     */
    private $phoneNumber;

    /**
     * Adresse postale du client.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * Adresse complémentaire du client.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addressComplement;

    /**
     * Code postal du client.
     *
     * @ORM\Column(type="string", length=5)
     */
    private $postalCode;

    /**
     * Ville du client.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * Mot de passe (chiffré) du client.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * Panier du client.
     *
     * @ORM\OneToOne(targetEntity="App\Entity\ShoppingCart", inversedBy="customer", cascade={"persist", "remove"})
     */
    private $shoppingCart;

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
     * @return Customer
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return Customer
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

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
     * @return Customer
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return Customer
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return Customer
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddressComplement(): ?string
    {
        return $this->addressComplement;
    }

    /**
     * @param null|string $addressComplement
     *
     * @return Customer
     */
    public function setAddressComplement(?string $addressComplement): self
    {
        $this->addressComplement = $addressComplement;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     *
     * @return Customer
     */
    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return Customer
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return Customer
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return ShoppingCart|null
     */
    public function getShoppingCart(): ?ShoppingCart
    {
        return $this->shoppingCart;
    }

    /**
     * @param ShoppingCart|null $shoppingCart
     * @return Customer
     */
    public function setShoppingCart(?ShoppingCart $shoppingCart): self
    {
        $this->shoppingCart = $shoppingCart;

        return $this;
    }
}