<?php

declare(strict_types=1);

/**
 * @author Dylan Trochain <dylvn-dev@pm.me>
 */

namespace Dylvn\Bundle\FaqBundle\Form\Type;

use Dylvn\Bundle\FaqBundle\Entity\CategoryItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'item',
                ItemCreateOrSelectType::class,
                ['label' => 'dylvn.faq.categoryitem.item.label', 'required' => true]
            )
            ->add('position', IntegerType::class, ['required' => false])
            ->add(
                'enabled',
                CheckboxType::class,
                [
                    'label' => 'dylvn.faq.categoryitem.enabled.label',
                    'required' => false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategoryItem::class,
        ]);
    }
}
