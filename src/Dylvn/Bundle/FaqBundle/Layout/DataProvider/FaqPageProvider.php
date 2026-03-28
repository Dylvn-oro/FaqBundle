<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Layout\DataProvider;

use Dylvn\Bundle\FaqBundle\Entity\Category;
use Dylvn\Bundle\FaqBundle\Entity\Repository\CategoryRepository;

class FaqPageProvider
{
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categoryRepository->findVisibleOnFaqPage();
    }
}
