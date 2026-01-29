<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Form\Type;

use Dylvn\Bundle\FaqBundle\Entity\Item;
use Oro\Bundle\CMSBundle\Form\Type\WYSIWYGValueType;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Oro\Bundle\LocaleBundle\Form\Type\LocalizedFallbackValueCollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'questions',
                LocalizedFallbackValueCollectionType::class,
                [
                    'label' => 'dylvn.faq.category.questions.label',
                    'required' => true,
                    'entry_options' => ['constraints' => [new NotBlank()]]
                ]
            )
            ->add(
                'answers',
                LocalizedFallbackValueCollectionType::class,
                [
                    'label' => 'oro.product.brand.answers.label',
                    'required' => false,
                    'field' => ['wysiwyg', 'wysiwyg_style', 'wysiwyg_properties'],
                    'entry_type' => WYSIWYGValueType::class,
                    'entry_options' => [
                        'entity_class' => LocalizedFallbackValue::class
                    ],
                    'use_tabs' => true,
                ]
            )
            ->add('position', IntegerType::class, ['required' => false])
            ->add(
                'enabled',
                CheckboxType::class,
                [
                    'label' => 'dylvn.faq.category.enabled.label',
                    'required' => false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class
        ]);
    }
}
