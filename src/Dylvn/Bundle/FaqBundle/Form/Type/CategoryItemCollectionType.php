<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Form\Type;

use Oro\Bundle\FormBundle\Form\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryItemCollectionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'add_label' => 'dylvn.faq.categoryitem.form.category_item_collection.add',
            'entry_type' => CategoryItemType::class,
            'entry_options' => [
                'required' => true,
            ]
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['skip_optional_validation_group'] = true;

        unset($view->vars['attr']['data-validation-optional-group']);
    }

    public function getParent(): string
    {
        return CollectionType::class;
    }
}
