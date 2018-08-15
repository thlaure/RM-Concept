<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProductType.
 *
 * @category Symfony4
 * @package  App\Form
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class ProductType extends AbstractType
{
    /**
     * Crée le formulaire permettant d'enregistrer des produits.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('reference', TextType::class)
            ->add('description', TextareaType::class)
            ->add('image', FileType::class)
            ->add('is_new', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                ),
                'expanded' => false,
                'multiple' => false
            ))
            ->add('quantity', NumberType::class)
            ->add('price_individuals', NumberType::class)
            ->add('price_professionals', NumberType::class)
            ->add('color', EntityType::class, array(
                'class' => 'App\Entity\Color',
                'multiple' => false,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez la couleur'
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array('data_class' => Product::class));
    }
}