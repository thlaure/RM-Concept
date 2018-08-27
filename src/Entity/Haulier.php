<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Haulier.
 *
 * @ORM\Entity(repositoryClass="App\Repository\HaulierRepository")
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class Haulier
{
    /**
     * ID du transporteur.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Libellé du transporteur.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * Coût du transporteur.
     *
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * Acesseur de l'ID du transporteur.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Accesseur du libellé du transporteur.
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Mutateur du libellé du transporteur.
     *
     * @param string $name Libellé à attribuer au transporteur.
     *
     * @return Haulier
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Accesseur du prix du transporteur.
     *
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * Mutateur du prix du transporteur.
     *
     * @param float $price Prix à attribuer au transporteur.
     *
     * @return Haulier
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}