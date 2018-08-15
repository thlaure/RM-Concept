<?php

namespace App\Form;

use App\Entity\ShoppingCartProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ShoppingCartProductType.
 *
 * @category Symfony4
 * @package  App\Form
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class ShoppingCartProductType extends AbstractType
{
    /**
     * Crée le formulaire permettant d'ajouter un produit au panier.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('is_customized', ChoiceType::class, array(
                'choices' => array(
                    'Non' => false,
                    'Oui' => true
                ),
                'expanded' => false,
                'multiple' => false
            ))
            ->add('quantity', NumberType::class, array(
                'attr' => array(
                    'type' => 'number',
                    'min' => 1
                )
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array('data_class' => ShoppingCartProduct::class));
    }
}