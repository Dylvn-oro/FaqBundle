<?php

declare(strict_types=1);

/**
 * @author Dylan Trochain <dylvn-dev@pm.me>
 */

namespace Dylvn\Bundle\FaqBundle\Tests\Unit\Entity;

use Dylvn\Bundle\FaqBundle\Entity\CategoryItem;
use Dylvn\Bundle\FaqBundle\Entity\Item;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Component\Testing\Unit\EntityTestCaseTrait;

class ItemTest extends \PHPUnit\Framework\TestCase
{
    use EntityTestCaseTrait;

    public function testAccessors()
    {
        $this->assertPropertyAccessors(new Item(), [
            ['id', 1],
            ['owner', new User()],
            ['organization', new Organization()],
            ['enabled', true],
            ['position', 10],
            ['createdAt', new \DateTime()],
            ['updatedAt', new \DateTime()],
        ]);

        $this->assertPropertyCollections(new Item(), [
            ['questions', new LocalizedFallbackValue()],
            ['answers', new LocalizedFallbackValue()],
            ['categoryItems', new CategoryItem()]
        ]);
    }

    public function testIsUpdatedAtSet()
    {
        $entity = new Item();
        $entity->setUpdatedAt(new \DateTime());

        $this->assertTrue($entity->isUpdatedAtSet());
    }

    public function testIsUpdatedAtNotSet()
    {
        $entity = new Item();
        $entity->setUpdatedAt(null);

        $this->assertFalse($entity->isUpdatedAtSet());
    }
}
