<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Individual;
use App\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegistrationController.
 *
 * @category Symfony4
 * @package  App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class RegistrationController extends AbstractController
{
    /**
     * Affiche la page de création de compte client.
     *
     * @Route("/registration", name="registration")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $individual = new Individual();
        $form = $this->createForm(CustomerType::class, $individual);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (strlen($individual->getPostalCode()) === 5 && strlen($individual->getPhoneNumber()) === 10 && $this->checkEmail($individual->getEmail()) && !$this->checkEmailExistence($individual->getEmail()) && $this->checkCityExistence($individual->getCity(), $individual->getPostalCode())) {
                $password = $passwordEncoder->encodePassword($individual, $individual->getPlainPassword());
                $individual->setPassword($password);
                $individual->setName(strtoupper($individual->getName()));
                $individual->setFirstName(ucwords($individual->getFirstName()));
                $individual->setAddress(ucwords($individual->getAddress()));
                $individual->setAddressComplement(ucwords($individual->getAddressComplement()));
                $individual->setCity(ucwords($individual->getCity()));
                $individual->setReference($this->generateReference());
                $this->persistObject($individual);
                return $this->returnRender($form, 'success');
            } elseif (strlen($individual->getPostalCode()) !== 5) {
                return $this->returnRender($form, 'postalCode');
            } elseif (strlen($individual->getPhoneNumber()) !== 10) {
                return $this->returnRender($form, 'phoneNumber');
            } elseif ($this->checkEmailExistence($individual->getEmail())) {
                return $this->returnRender($form, 'emailExists');
            } elseif (!$this->checkCityExistence($individual->getCity(), $individual->getPostalCode())) {
                return $this->returnRender($form, 'city');
            } else {
                return $this->returnRender($form, 'emailFormat');
            }
        }
        return $this->returnRender($form, '');
    }

    /**
     * Permet de faire persister une entité en base de données.
     *
     * @param ? $object Objet à persister.
     */
    private function persistObject($object): void
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($object);
        $entityManager->flush();
    }

    /**
     * Génère un entier aléatoire qui servira de référence à chaque client.
     *
     * @return string
     *
     * @throws \Exception
     */
    private function generateReference(): ?string
    {
        $referenceGeneree = random_int(100000, 999999);
        while ($this->checkReferenceExistence($referenceGeneree) === true) {
            $referenceGeneree = random_int(100000, 999999);
        }
        return strval($referenceGeneree);
    }

    /**
     * Vérifie l'existence de la référence en base de données.
     *
     * @param string $reference Référence dont il faut contrôler l'existence.
     *
     * @return bool|null
     */
    private function checkReferenceExistence(string $reference): ?bool
    {
        $repository = $this->getDoctrine()->getRepository(Individual::class);
        $result = $repository->findOneBy(
            array(
                'reference' => $reference
            )
        );
        return $result !== null;
    }

    /**
     * Vérifie l'existence de l'adresse mail en base de données.
     *
     * @param string $email Adresse mail dont il faut contrôler l'existence.
     *
     * @return bool|null
     */
    private function checkEmailExistence(string $email): ?bool
    {
        $repository = $this->getDoctrine()->getRepository(Individual::class);
        $result = $repository->findOneBy(
            array(
                'email' => $email
            )
        );
        return $result !== null;
    }

    /**
     * Contrôle le format de l'adresse mail.
     *
     * @param string $email Adresse mail à contrôler.
     *
     * @return bool|null
     */
    private function checkEmail(string $email): ?bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Vérifie l'existence de la ville saisie dans le formulaire.
     *
     * @param string $name Nom de la ville à vérifier.
     * @param string $postalCode Code postal de la ville à vérifier.
     *
     * @return bool
     */
    private function checkCityExistence(string $name, string $postalCode)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(City::class);
        $result = $repository->findOneBy(array(
            'name' => strtoupper($name),
            'postalCode' => $postalCode
        ));
        return $result !== null;
    }

    /**
     * Renvoie le message approprié en fonction du besoin.
     *
     * @param FormInterface $form Formulaire de création de client.
     * @param string $alert Alerte définie.
     *
     * @return Response
     */
    private function returnRender(FormInterface $form, string $alert): ?Response
    {
        if ($alert === 'postalCode') {
            $render = $this->render(
                'registration/register.html.twig', array(
                    'form' => $form->createView(),
                    'text_alert' => 'Le format du code postal n\'est pas correct.',
                    'class_alert' => 'alert-warning'
                )
            );
        } elseif ($alert === 'phoneNumber') {
            $render = $this->render(
                'registration/register.html.twig', array(
                    'form' => $form->createView(),
                    'text_alert' => 'Le format du numéro de téléphone n\'est pas correct.',
                    'class_alert' => 'alert-warning'
                )
            );
        } elseif ($alert === 'city') {
            $render = $this->render(
                'registration/register.html.twig', array(
                    'form' => $form->createView(),
                    'text_alert' => 'La ville et le code postal ne correspondent pas.',
                    'class_alert' => 'alert-warning'
                )
            );
        } elseif ($alert === 'emailFormat') {
            $render = $this->render(
                'registration/register.html.twig', array(
                    'form' => $form->createView(),
                    'text_alert' => 'Le format de l\'adresse mail n\'est pas correct.',
                    'class_alert' => 'alert-warning'
                )
            );
        } elseif ($alert === 'emailExists') {
            $render = $this->render(
                'registration/register.html.twig', array(
                    'form' => $form->createView(),
                    'text_alert' => 'L\'adresse mail saisie est déjà liée à un compte.',
                    'class_alert' => 'alert-warning'
                )
            );
        } elseif ($alert === 'success') {
            $render = $this->render(
                'registration/register.html.twig', array(
                    'form' => $form->createView(),
                    'text_alert' => 'Vous avez bien été enregistré.',
                    'class_alert' => 'alert-success'
                )
            );
        } else {
            $render = $this->render(
                'registration/register.html.twig', array(
                    'form' => $form->createView()
                )
            );
        }
        return $render;
    }
}