<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Tests\Unit\Layout\DataProvider;

use Dylvn\Bundle\FaqBundle\Entity\Category;
use Dylvn\Bundle\FaqBundle\Entity\Repository\CategoryRepository;
use Dylvn\Bundle\FaqBundle\Layout\DataProvider\FaqPageProvider;
use PHPUnit\Framework\TestCase;

class FaqPageProviderTest extends TestCase
{
    public function testGetCategoriesReturnsVisibleCategories(): void
    {
        $category1 = new Category();
        $category2 = new Category();

        $repository = $this->createMock(CategoryRepository::class);
        $repository->expects($this->once())
            ->method('findVisibleOnFaqPage')
            ->willReturn([$category1, $category2]);

        $provider = new FaqPageProvider($repository);

        $this->assertSame([$category1, $category2], $provider->getCategories());
    }

    public function testGetCategoriesReturnsEmptyArrayWhenNoneVisible(): void
    {
        $repository = $this->createMock(CategoryRepository::class);
        $repository->expects($this->once())
            ->method('findVisibleOnFaqPage')
            ->willReturn([]);

        $provider = new FaqPageProvider($repository);

        $this->assertSame([], $provider->getCategories());
    }
}
