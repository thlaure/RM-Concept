<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ShoppingCartConfirmed.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ShoppingCartConfirmedRepository")
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class ShoppingCartConfirmed extends ShoppingCart
{
}