<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Customer.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"particulier" = "Individual"})
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
abstract class Customer implements UserInterface, \Serializable
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
     * Etat de connexion du client.
     *
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * Liste des commandes du particulier.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Command", mappedBy="customer")
     */
    private $commands;

    /**
     * Panier du client.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\ShoppingCart", mappedBy="customer")
     */
    private $shoppingCarts;

    /**
     * Mot de passe en clair du client.
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * Panier non confirmé du client.
     *
     * @ORM\OneToOne(targetEntity="App\Entity\ShoppingCart", cascade={"persist", "remove"})
     */
    private $shoppingCartNotConfirmed;

    /**
     * Customer constructor.
     */
    public function __construct()
    {
        $this->isActive = true;
        $this->commands = new ArrayCollection();
        $this->shoppingCarts = new ArrayCollection();
    }

    /**
     * Accesseur de l'ID du client.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Accesseur du nom du client.
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Mutateur du nom du client.
     *
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
     * Accesseur du prénom du client.
     *
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Mutateur du prénom du client.
     *
     * @param string $firstName Prénom à attribuer au client.
     *
     * @return Customer
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Accesseur de la référence du client.
     *
     * @return null|string
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * Mutateur de la référence du client.
     *
     * @param string $reference Référence à attribuer au client.
     *
     * @return Customer
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Accesseur de l'adresse mail du client.
     *
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Mutateur de l'adresse mail du client.
     *
     * @param string $email Adresse mail à attribuer au client.
     *
     * @return Customer
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Accesseur du numéro de téléphone du client.
     *
     * @return null|string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * Mutateur du numéro de téléphone du client.
     *
     * @param string $phoneNumber Numéro de téléphone à attribuer au client.
     *
     * @return Customer
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Accesseur de l'adresse postale du client.
     *
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Mutateur de l'adresse postale du client.
     *
     * @param string $address Adresse postale à attribuer au client.
     *
     * @return Customer
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Accesseur du complément d'adresse du client.
     *
     * @return null|string
     */
    public function getAddressComplement(): ?string
    {
        return $this->addressComplement;
    }

    /**
     * Mutateur du complément d'adresse du client.
     *
     * @param null|string $addressComplement Complément d'adresse à attribuer au client.
     *
     * @return Customer
     */
    public function setAddressComplement(?string $addressComplement): self
    {
        $this->addressComplement = $addressComplement;

        return $this;
    }

    /**
     * Accesseur du code postal du client.
     *
     * @return null|string
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Mutateur du code postal du client.
     *
     * @param string $postalCode Code postal à attribuer au client.
     *
     * @return Customer
     */
    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Accesseur de la ville du client.
     *
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Mutateur de la ville du client.
     *
     * @param string $city Ville à attribuer au client.
     *
     * @return Customer
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Accesseur du mot de passe du client.
     *
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Mutateur du mot de passe du client.
     *
     * @param string $password Mot de passe à attribuer au client.
     *
     * @return Customer
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Accesseur de l'état d'activité du client.
     *
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * Mutateur de l'état d'activité du client.
     *
     * @param bool $isActive Etat d'activité à attribuer au client.
     *
     * @return Customer
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Accesseur de la liste des commandes du particulier.
     *
     * @return Collection|Command[]
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }

    /**
     * Ajoute une commande à la liste des commandes du particulier.
     *
     * @param Command $command Commande à ajouter.
     *
     * @return self
     */
    public function addCommand(Command $command): self
    {
        if (!$this->commands->contains($command)) {
            $this->commands[] = $command;
            $command->setCustomer($this);
        }

        return $this;
    }

    /**
     * Supprime une commande à la liste des commandes du particulier.
     *
     * @param Command $command Commande à supprimer.
     *
     * @return self
     */
    public function removeCommand(Command $command): self
    {
        if ($this->commands->contains($command)) {
            $this->commands->removeElement($command);
            // set the owning side to null (unless already changed)
            if ($command->getCustomer() === $this) {
                $command->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * Accesseur du panier du client.
     *
     * @return Collection|ShoppingCart[]
     */
    public function getShoppingCarts(): Collection
    {
        return $this->shoppingCarts;
    }

    /**
     * Ajoute un panier à la liste des paniers du client.
     *
     * @param ShoppingCart $shoppingCart Panier à ajouter.
     *
     * @return Individual
     */
    public function addShoppingCart(ShoppingCart $shoppingCart): self
    {
        if (!$this->shoppingCarts->contains($shoppingCart)) {
            $this->shoppingCarts[] = $shoppingCart;
            $shoppingCart->setCustomer($this);
        }

        return $this;
    }

    /**
     * Supprime un panier de la liste des paniers du client.
     *
     * @param ShoppingCart $shoppingCart Panier à supprimer.
     *
     * @return Individual
     */
    public function removeShoppingCart(ShoppingCart $shoppingCart): self
    {
        if ($this->shoppingCarts->contains($shoppingCart)) {
            $this->shoppingCarts->removeElement($shoppingCart);
            // set the owning side to null (unless already changed)
            if ($shoppingCart->getCustomer() === $this) {
                $shoppingCart->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * Accesseur du mot de passe en clair du client.
     *
     * @return null|string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * Mutateur du mot de passe en clair du client.
     *
     * @param string $plainPassword Mot de passe en clair à attribuer au client.
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * Accesseur du nom d'utilisateur du client.
     * Méthode implémentée par UserInterface.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * Accesseur du sel permettant d'encoder le mot de passe.
     * Méthode implémentée par UserInterface.
     *
     * @return null|string
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Accesseur des rôles (privilèges) du client.
     * Méthode implémentée par UserInterface.
     *
     * @return array
     */
    public function getRoles(): array
    {
        return array('ROLE_USER');
    }

    /**
     * Supprime les données sensibles de l'utilisateur.
     * Méthode implémentée par UserInterface.
     */
    public function eraseCredentials()
    {
    }

    /**
     * Serialize un client.
     * Méthode implémentée par Serialize.
     *
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password
        ));
    }

    /**
     * Deserialize un client.
     * Méthode implémentée par Serialize.
     *
     * @see \Serializable::unserialize()
     *
     * @param $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password
        ) = unserialize($serialized, array('allowed_classes' => false));
    }

    /**
     * Accesseur du panier non confirmé du client.
     *
     * @return ShoppingCart|null
     */
    public function getShoppingCartNotConfirmed(): ?ShoppingCart
    {
        return $this->shoppingCartNotConfirmed;
    }

    /**
     * Mutateur du panier non confirmé du client.
     *
     * @param ShoppingCart|null $shoppingCartNotConfirmed Panier non confirmé à attribuer au client.
     *
     * @return Customer
     */
    public function setShoppingCartNotConfirmed(?ShoppingCart $shoppingCartNotConfirmed): self
    {
        $this->shoppingCartNotConfirmed = $shoppingCartNotConfirmed;

        return $this;
    }
}