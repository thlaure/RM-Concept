<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StateRepository")
 */
class State
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $stateDate;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ShoppingCartProduct", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $shoppingCartProduct;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStateDate(): ?\DateTimeInterface
    {
        return $this->stateDate;
    }

    public function setStateDate(\DateTimeInterface $stateDate): self
    {
        $this->stateDate = $stateDate;

        return $this;
    }

    public function getShoppingCartProduct(): ?ShoppingCartProduct
    {
        return $this->shoppingCartProduct;
    }

    public function setShoppingCartProduct(ShoppingCartProduct $shoppingCartProduct): self
    {
        $this->shoppingCartProduct = $shoppingCartProduct;

        return $this;
    }
}
