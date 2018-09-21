<?php

namespace App\Controller;

use Fpdf\Fpdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class PrintController.
 *
 * @category Symfony4
 * @package App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class PrintController extends AbstractController
{
    /**
     * Crée un fichier PDF.
     *
     * @param string $file Image à imprimer sur le fichier PDF.
     */
    public function print(string $file)
    {
        $fpdf = new Fpdf();
        $fpdf->Image($file);
    }
}