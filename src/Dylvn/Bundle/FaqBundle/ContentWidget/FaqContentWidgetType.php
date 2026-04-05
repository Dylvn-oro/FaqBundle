<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\ContentWidget;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Dylvn\Bundle\FaqBundle\Entity\Category;
use Dylvn\Bundle\FaqBundle\Entity\Repository\CategoryRepository;
use Dylvn\Bundle\FaqBundle\Form\Type\CategoryMultiSelectType;
use Oro\Bundle\CMSBundle\ContentWidget\AbstractContentWidgetType;
use Oro\Bundle\CMSBundle\Entity\ContentWidget;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Twig\Environment;

class FaqContentWidgetType extends AbstractContentWidgetType
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public static function getName(): string
    {
        return 'faq';
    }

    public function getLabel(): string
    {
        return 'dylvn.faq.content_widget.faq.label';
    }

    public function getWidgetData(ContentWidget $contentWidget): array
    {
        $categorieIds = $contentWidget->getSettings()['categories'];
        $categories = $this->getCategoryRepository()->findBy(['id' => $categorieIds]);

        return [
            'categories' => new ArrayCollection($categories),
        ];
    }

    public function getSettingsForm(ContentWidget $contentWidget, FormFactoryInterface $formFactory): ?FormInterface
    {
        return $formFactory->createBuilder(FormType::class)
            ->add('categories', CategoryMultiSelectType::class, [
                'label' => 'dylvn.faq.content_widget.faq.categories.label',
                'required' => false,
            ])
            ->getForm();
    }

    public function getDefaultTemplate(ContentWidget $contentWidget, Environment $twig): string
    {
        return '';
    }

    private function getCategoryRepository(): CategoryRepository
    {
        return $this->entityManager->getRepository(Category::class);
    }
}
