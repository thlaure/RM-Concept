<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Individual.
 *
 * @ORM\Entity(repositoryClass="App\Repository\IndividualRepository")
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class Individual extends Customer
{
    /**
     * Liste des commandes du particulier.
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Command", mappedBy="individual")
     */
    private $commands;

    /**
     * Individual constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->commands = new ArrayCollection();
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
            $command->setIndividual($this);
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
            if ($command->getIndividual() === $this) {
                $command->setIndividual(null);
            }
        }

        return $this;
    }
}