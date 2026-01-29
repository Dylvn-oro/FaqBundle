<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Form\Type;

use Oro\Bundle\FormBundle\Form\Type\OroEntitySelectOrCreateInlineType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemCreateOrSelectType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'autocomplete_alias' => 'dylvn_faq_item',
                'grid_name' => 'dylvn-faq-item-grid',
                'create_form_route' => 'dylvn_faq_item_create',
            ]
        );
    }

    public function getParent()
    {
        return OroEntitySelectOrCreateInlineType::class;
    }
}
