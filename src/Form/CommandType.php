<?php

namespace App\Form;

use App\Entity\Command;
use App\Entity\Haulier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CommandType.
 *
 * @category Symfony4
 * @package  App\Form
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class CommandType extends AbstractType
{
    /**
     * Crée le formulaire de choix du transporteur.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('haulier', EntityType::class, array(
                'class' => 'App\Entity\Haulier',
                'multiple' => false,
                'expanded' => true,
                'choice_label' => 'name',
                'label' => 'name'
            ))
            ->add('delivery_address', TextType::class)
            ->add('delivery_complement_address', TextType::class, array(
                'required' => false
            ))
            ->add('delivery_postal_code', TextType::class)
            ->add('delivery_city', TextType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Command::class,
        ));
    }
}