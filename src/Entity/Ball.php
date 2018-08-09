<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BallRepository")
 */
class Ball extends Product
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Color")
     * @ORM\JoinColumn(nullable=false)
     */
    private $color;

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }
}