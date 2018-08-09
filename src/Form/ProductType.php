<?php
/**
 * Created by IntelliJ IDEA.
 * User: Thomas
 * Date: 09/08/2018
 * Time: 16:21
 */

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
 * @package App\Form
 */
class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('reference', TextType::class)
            ->add('description', TextareaType::class)
            ->add('image', FileType::class)
            ->add('isNew', ChoiceType::class,array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                ),
                'expanded' => false,
                'multiple' => false
            ))
            ->add('quantity', NumberType::class)
            ->add('priceIndividuals', NumberType::class)
            ->add('priceProfessionals', NumberType::class)
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => Product::class));
    }
}