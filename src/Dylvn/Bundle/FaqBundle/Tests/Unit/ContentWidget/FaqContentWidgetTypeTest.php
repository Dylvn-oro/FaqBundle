<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Tests\Unit\ContentWidget;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Dylvn\Bundle\FaqBundle\ContentWidget\FaqContentWidgetType;
use Dylvn\Bundle\FaqBundle\Entity\Category;
use Dylvn\Bundle\FaqBundle\Entity\Repository\CategoryRepository;
use Oro\Bundle\CMSBundle\Entity\ContentWidget;
use PHPUnit\Framework\TestCase;

class FaqContentWidgetTypeTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private FaqContentWidgetType $widgetType;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->widgetType = new FaqContentWidgetType($this->entityManager);
    }

    public function testGetName(): void
    {
        $this->assertEquals('faq', FaqContentWidgetType::getName());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals('dylvn.faq.content_widget.faq.label', $this->widgetType->getLabel());
    }

    public function testGetWidgetDataReturnsCategories(): void
    {
        $category1 = new Category();
        $category2 = new Category();

        $repository = $this->createMock(CategoryRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->with(['id' => [1, 2]])
            ->willReturn([$category1, $category2]);

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->with(Category::class)
            ->willReturn($repository);

        $contentWidget = $this->createMock(ContentWidget::class);
        $contentWidget->method('getSettings')->willReturn(['categories' => [1, 2]]);

        $result = $this->widgetType->getWidgetData($contentWidget);

        $this->assertArrayHasKey('categories', $result);
        $this->assertInstanceOf(ArrayCollection::class, $result['categories']);
        $this->assertCount(2, $result['categories']);
        $this->assertSame($category1, $result['categories'][0]);
        $this->assertSame($category2, $result['categories'][1]);
    }

    public function testGetWidgetDataWithEmptyCategories(): void
    {
        $repository = $this->createMock(CategoryRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->with(['id' => []])
            ->willReturn([]);

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->with(Category::class)
            ->willReturn($repository);

        $contentWidget = $this->createMock(ContentWidget::class);
        $contentWidget->method('getSettings')->willReturn(['categories' => []]);

        $result = $this->widgetType->getWidgetData($contentWidget);

        $this->assertInstanceOf(ArrayCollection::class, $result['categories']);
        $this->assertCount(0, $result['categories']);
    }
}
