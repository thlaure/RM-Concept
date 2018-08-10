<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Color.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ColorRepository")
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class Color
{
    /**
     * ID de la couleur.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Nom de la couleur.
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * Code de la couleur.
     *
     * @ORM\Column(type="string", length=7)
     */
    private $colorCode;

    /**
     * Accesseur de l'ID de la couleur.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Accesseur du nom de la couleur.
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Mutateur du nom de la couleur.
     *
     * @param string $name Nom à attribuer à la couleur.
     *
     * @return Color
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Accesseur du code de la couleur.
     *
     * @return null|string
     */
    public function getColorCode(): ?string
    {
        return $this->colorCode;
    }

    /**
     * Mutateur du code de la couleur.
     *
     * @param string $colorCode Code à attribuer à la couleur.
     *
     * @return Color
     */
    public function setColorCode(string $colorCode): self
    {
        $this->colorCode = $colorCode;

        return $this;
    }
}