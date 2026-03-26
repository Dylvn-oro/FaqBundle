<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Form\Extension;

use Oro\Bundle\FormBundle\Utils\FormUtils;
use Oro\Bundle\NavigationBundle\Form\Type\RouteChoiceType;
use Oro\Bundle\WebCatalogBundle\Form\Type\SystemPageVariantType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SystemPageVariantTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'systemPageRoute',
            RouteChoiceType::class,
            [
                'label' => 'oro.webcatalog.contentvariant.system_page_route.label',
                'required' => true,
                'options_filter' => [
                    'frontend' => true,
                ],
                'name_filter' => '/^(oro|dylvn)_\w+$/',
                'menu_name' => SystemPageVariantType::MENU_NAME,
            ]
        );
    }

    public static function getExtendedTypes(): iterable
    {
        return [SystemPageVariantType::class];
    }
}
