<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle;

use Oro\Bundle\LocaleBundle\DependencyInjection\Compiler\EntityFallbackFieldsStoragePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DylvnFaqBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new EntityFallbackFieldsStoragePass([
            'Dylvn\Bundle\FaqBundle\Entity\Category' => [
                'title' => 'titles',
                'description' => 'descriptions',
            ],
            'Dylvn\Bundle\FaqBundle\Entity\Item' => [
                'question' => 'questions',
                'answer' => 'answers',
            ]
        ]));
    }
}
