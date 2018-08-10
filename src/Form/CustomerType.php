<?php

namespace App\Form;

use App\Entity\Individual;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * Class CustomerType.
 *
 * @category Symfony4
 * @package  App\Form
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class CustomerType extends AbstractType
{
    /**
     * Crée le formulaire pour l'enregistrement de clients.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('firstName', TextType::class)
            ->add('address', TextType::class)
            ->add('addressComplement', TextType::class, array(
                'required' => false
            ))
            ->add('postalCode', TextType::class, array(
                'attr' => array(
                    'minlength' => 3,
                    'maxlength' => 5
                )
            ))
            ->add('city', TextType::class)
            ->add('phoneNumber', TelType::class, array(
                'attr' => array(
                    'minlength' => 10,
                    'maxlength' => 10
                )
            ))
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'placeholder' => 'mail@example.com'
                )
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmez le mot de passe')
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Individual::class,
        ));
    }
}