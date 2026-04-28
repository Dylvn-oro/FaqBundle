<?php

declare(strict_types=1);

/**
 * @author Dylan Trochain <dylvn-dev@pm.me>
 */

namespace Dylvn\Bundle\FaqBundle\Form\Type;

use Dylvn\Bundle\FaqBundle\Entity\Category;
use Oro\Bundle\FormBundle\Form\Type\OroRichTextType;
use Oro\Bundle\LocaleBundle\Form\Type\LocalizedFallbackValueCollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'code',
                TextType::class,
                [
                    'label' => 'dylvn.faq.category.code.label',
                    'required' => true,
                    'constraints' => [new NotBlank()]
                ]
            )
            ->add(
                'titles',
                LocalizedFallbackValueCollectionType::class,
                [
                    'label' => 'dylvn.faq.category.title.label',
                    'required' => true,
                    'entry_options' => ['constraints' => [new NotBlank()]]
                ]
            )
            ->add(
                'descriptions',
                LocalizedFallbackValueCollectionType::class,
                [
                    'label' => 'dylvn.faq.category.descriptions.label',
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
                    'label' => 'dylvn.faq.category.enabled.label',
                    'required' => false
                ]
            )
            ->add(
                'categoryItems',
                CategoryItemCollectionType::class,
                [
                    'label' => false,
                    'attr' => [
                        'class' => 'faq-category-items-control-group'
                    ],
                    'error_bubbling' => false
                ]
            )
            ->add('visibleOnFaqPage', CheckboxType::class, [
                'label' => 'dylvn.faq.category.visible_on_faq_page.label',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class
        ]);
    }
}
