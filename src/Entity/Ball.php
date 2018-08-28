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
     * Nombre de balles par pack.
     *
     * @ORM\Column(type="integer")
     */
    private $numberInPack;

    /**
     * Accesseur du nombre de balles par pack.
     *
     * @return null|int
     */
    public function getNumberInPack(): ?int
    {
        return $this->numberInPack;
    }

    /**
     * Mutateur du nombre de balles par pack.
     *
     * @param string $numberInPack Nombre de balles à attribuer.
     *
     * @return Ball
     */
    public function setNumberInPack(string $numberInPack): self
    {
        $this->numberInPack = $numberInPack;

        return $this;
    }
}