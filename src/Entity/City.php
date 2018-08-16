<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class City.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class City
{
    /**
     * ID de la ville.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Nom de la ville.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * Code postal de la ville.
     *
     * @ORM\Column(type="string", length=5)
     */
    private $postalCode;

    /**
     * Accesseur de l'ID de la ville.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Accesseur du nom de la ville.
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Mutateur du nom de la ville.
     *
     * @param string $name Nom à attribuer à la ville.
     *
     * @return City
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Accesseur du code postal de la ville.
     *
     * @return null|string
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * Mutateur du code postal de la ville.
     *
     * @param string $postalCode Code postal à attribuer à la ville.
     *
     * @return City
     */
    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }
}