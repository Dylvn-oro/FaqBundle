<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityInterface;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityTrait;
use Oro\Bundle\OrganizationBundle\Entity\OrganizationAwareInterface;
use Oro\Bundle\UserBundle\Entity\Ownership\AuditableUserAwareTrait;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *      name="dylvn_faq_category_item",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="dylvn_faq_category_item_unq_idx", columns={"category_id", "item_id"})
 *      }
 * )
 * @Config()
 */
class CategoryItem  implements
    DatesAwareInterface,
    OrganizationAwareInterface,
    ExtendEntityInterface
{
    use DatesAwareTrait;
    use AuditableUserAwareTrait;
    use ExtendEntityTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Dylvn\Bundle\FaqBundle\Entity\Category", inversedBy="categoryItems")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $category;

    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Dylvn\Bundle\FaqBundle\Entity\Item", inversedBy="categoryItems")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $item;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", options={"default"=0})
     */
    private $position = 0;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default"=true})
     */
    private $enabled = true;

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id): CategoryItem
    {
        $this->id = $id;
        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(Category $category): CategoryItem
    {
        $this->category = $category;
        return $this;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function setItem(Item $item): CategoryItem
    {
        $this->item = $item;
        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition(int $position): CategoryItem
    {
        $this->position = $position;
        return $this;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): CategoryItem
    {
        $this->enabled = $enabled;
        return $this;
    }
}
