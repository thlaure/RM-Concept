<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Ball.
 *
 * @ORM\Entity(repositoryClass="App\Repository\BallRepository")
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class Ball extends Product
{
    /**
     * Couleur de la balle.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Color")
     * @ORM\JoinColumn(nullable=false)
     */
    private $color;

    /**
     * Accesseur de la couleur de la balle.
     *
     * @return Color|null
     */
    public function getColor(): ?Color
    {
        return $this->color;
    }

    /**
     * Mutateur de la couleur de la balle.
     *
     * @param Color|null $color Couleur à attribuer à la balle.
     *
     * @return Ball
     */
    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }
}