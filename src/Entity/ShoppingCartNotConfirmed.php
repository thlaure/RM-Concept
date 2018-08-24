<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ShoppingCartNotConfirmed.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ShoppingCartNotConfirmedRepository")
 *
 * @category Symfony4
 * @package  App\Entity
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class ShoppingCartNotConfirmed extends ShoppingCart
{
}