<?php

declare(strict_types=1);

namespace Dylvn\FaqBundle\Tests\Unit\Entity\Category;

use Dylvn\Bundle\FaqBundle\Entity\Category;
use Dylvn\Bundle\FaqBundle\Entity\CategoryItem;
use Oro\Bundle\CMSBundle\Entity\TextContentVariant;
use Oro\Bundle\CMSBundle\Tests\Unit\Entity\Stub\ContentBlock;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Oro\Bundle\OrganizationBundle\Entity\BusinessUnit;
use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\ScopeBundle\Entity\Scope;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Component\Testing\Unit\EntityTestCaseTrait;

class CategoryTest extends \PHPUnit\Framework\TestCase
{
    use EntityTestCaseTrait;

    public function testAccessors()
    {
        $this->assertPropertyAccessors(new Category(), [
            ['id', 1],
            ['code', 'test_code'],
            ['owner', new User()],
            ['organization', new Organization()],
            ['enabled', true],
            ['position', 10],
            ['createdAt', new \DateTime()],
            ['updatedAt', new \DateTime()],
        ]);

        $this->assertPropertyCollections(new Category(), [
            ['titles', new LocalizedFallbackValue()],
            ['descriptions', new LocalizedFallbackValue()],
            ['categoryItems', new CategoryItem()]
        ]);
    }

    public function testIsUpdatedAtSet()
    {
        $entity = new Category();
        $entity->setUpdatedAt(new \DateTime());

        $this->assertTrue($entity->isUpdatedAtSet());
    }

    public function testIsUpdatedAtNotSet()
    {
        $entity = new Category();
        $entity->setUpdatedAt(null);

        $this->assertFalse($entity->isUpdatedAtSet());
    }
}
