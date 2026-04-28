<?php

declare(strict_types=1);

/**
 * @author Dylan Trochain <dylvn-dev@pm.me>
 */

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
