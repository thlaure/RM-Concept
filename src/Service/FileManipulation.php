<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FileManipulation.
 *
 * @category Symfony4
 * @package App\Service
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class FileManipulation extends AbstractController
{
    /**
     * Vérifie le fait que le fichier importé soit bien une image.
     *
     * @param UploadedFile $uploadedFile Fichier importé.
     *
     * @return bool|null
     */
    public function testImageFormat(UploadedFile $uploadedFile): ?bool
    {
        $extensionsAllowed = array('jpg', 'jpeg', 'png', 'gif');
        $extensionUploadedImage = $uploadedFile->guessExtension();
        return in_array($extensionUploadedImage, $extensionsAllowed);
    }

    /**
     * On donne un nom unique au fichier uploadé, et on le déplace dans le dossier
     * du projet qui contiendra les images.
     * Retourne le nouveau nom du fichier.
     *
     * @param UploadedFile $uploadedFile Fichier importé.
     *
     * @return string
     */
    public function imageProcessing(UploadedFile $uploadedFile): ?string
    {
        $imageName = $this->generateUniqueFileName() . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move($this->getParameter('balls_directory'), $imageName);
        return $imageName;
    }

    /**
     * On donne un nom unique au fichier uploadé, et on le déplace dans le dossier
     * du projet qui contiendra les images.
     * Retourne le nouveau nom du fichier.
     *
     * @param UploadedFile $uploadedFile Fichier importé.
     *
     * @return string
     */
    public function customizableImageProcessing(UploadedFile $uploadedFile): ?string
    {
        $imageName = $this->generateUniqueFileName() . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move($this->getParameter('ball_directory'), $imageName);
        return $imageName;
    }

    /**
     * On donne un nom unique au fichier uploadé, et on le déplace dans le dossier
     * du projet qui contiendra les images.
     * Retourne le nouveau nom du fichier.
     *
     * @param UploadedFile $uploadedFile Fichier importé.
     *
     * @return string
     */
    public function customizedImageProcessing(UploadedFile $uploadedFile): ?string
    {
        $imageName = $this->generateUniqueFileName() . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move($this->getParameter('customization_directory'), $imageName);
        return $imageName;
    }

    /**
     * Génère un nom aléatoire et complexe pour le fichier importé.
     *
     * @return null|string
     */
    public function generateUniqueFileName(): ?string
    {
        return md5(uniqid());
    }
}