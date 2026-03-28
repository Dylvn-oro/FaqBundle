<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Form\Type;

use Dylvn\Bundle\FaqBundle\Entity\Item;
use Oro\Bundle\CMSBundle\Form\Type\WYSIWYGValueType;
use Oro\Bundle\FormBundle\Form\Type\OroRichTextType;
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
                    'label' => 'dylvn.faq.item.questions.label',
                    'required' => true,
                    'entry_options' => ['constraints' => [new NotBlank()]]
                ]
            )
            ->add(
                'answers',
                LocalizedFallbackValueCollectionType::class,
                [
                    'label' => 'dylvn.faq.item.answers.label',
                    'required' => false,
                    'field' => 'text',
                    'entry_type' => OroRichTextType::class,
                    'entry_options' => [
                        'wysiwyg_options' => [
                            'elementpath' => true,
                            'resize' => true,
                            'height' => 300,
                        ]
                    ],
                    'use_tabs' => true,
                ]
            )
            ->add('position', IntegerType::class, ['required' => false])
            ->add(
                'enabled',
                CheckboxType::class,
                [
                    'label' => 'dylvn.faq.item.enabled.label',
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
