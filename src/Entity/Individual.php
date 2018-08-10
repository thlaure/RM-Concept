<?php

namespace App\Entity;

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
}