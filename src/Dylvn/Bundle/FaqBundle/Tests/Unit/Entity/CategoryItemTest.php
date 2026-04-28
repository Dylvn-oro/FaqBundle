<?php

declare(strict_types=1);

/**
 * @author Dylan Trochain <dylvn-dev@pm.me>
 */

namespace Dylvn\Bundle\FaqBundle\Tests\Unit\Entity;

use Dylvn\Bundle\FaqBundle\Entity\Category;
use Dylvn\Bundle\FaqBundle\Entity\CategoryItem;
use Dylvn\Bundle\FaqBundle\Entity\Item;
use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Component\Testing\Unit\EntityTestCaseTrait;

class CategoryItemTest extends \PHPUnit\Framework\TestCase
{
    use EntityTestCaseTrait;

    public function testAccessors(): void
    {
        $this->assertPropertyAccessors(new CategoryItem(), [
            ['id', 1],
            ['category', new Category()],
            ['item', new Item()],
            ['position', 5],
            ['enabled', false],
            ['owner', new User()],
            ['organization', new Organization()],
            ['createdAt', new \DateTime()],
            ['updatedAt', new \DateTime()],
        ]);
    }

    public function testIsUpdatedAtSet(): void
    {
        $entity = new CategoryItem();
        $entity->setUpdatedAt(new \DateTime());

        $this->assertTrue($entity->isUpdatedAtSet());
    }

    public function testIsUpdatedAtNotSet(): void
    {
        $entity = new CategoryItem();
        $entity->setUpdatedAt(null);

        $this->assertFalse($entity->isUpdatedAtSet());
    }

    public function testDefaults(): void
    {
        $entity = new CategoryItem();

        $this->assertSame(0, $entity->getPosition());
        $this->assertTrue($entity->isEnabled());
    }
}
