<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityInterface;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityTrait;
use Oro\Bundle\LocaleBundle\Entity\Localization;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Oro\Bundle\OrganizationBundle\Entity\OrganizationAwareInterface;
use Oro\Bundle\UserBundle\Entity\Ownership\AuditableUserAwareTrait;

/**
 * @ORM\Entity(repositoryClass="Dylvn\Bundle\FaqBundle\Entity\Repository\CategoryRepository")
 * @ORM\Table(
 *      name="dylvn_faq_category",
 * )
 * @Config(
 *      routeName="dylvn_faq_category_index",
 *      routeView="dylvn_faq_category_view",
 *      routeUpdate="dylvn_faq_category_update",
 *      defaultValues={
 *          "entity"={
 *              "icon"="fa-check-square"
 *          },
 *          "ownership"={
 *              "owner_type"="USER",
 *              "owner_field_name"="owner",
 *              "owner_column_name"="user_owner_id",
 *              "organization_field_name"="organization",
 *              "organization_column_name"="organization_id",
 *          },
 *          "dataaudit"={
 *              "auditable"=true
 *          },
 *          "security"={
 *              "type"="ACL",
 *              "group_name"="",
 *              "category"="marketing"
 *          }
 *      }
 * )
 * @ORM\HasLifecycleCallbacks()
 * @method LocalizedFallbackValue getDefaultTitle()
 * @method LocalizedFallbackValue getTitle(Localization $localization = null)
 * @method LocalizedFallbackValue getDefaultDescription()
 * @method LocalizedFallbackValue getDescription(Localization $localization = null)
 */
class Category implements
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
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, unique=true)
     */
    private $code;

    /**
     * @var ArrayCollection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="dylvn_faq_category_title",
     *      joinColumns={
     *          @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    private $titles;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="dylvn_faq_category_description",
     *      joinColumns={
     *          @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     * @ConfigField(
     *      defaultValues={
     *          "dataaudit"={
     *              "auditable"=true
     *          }
     *      }
     * )
     */
    private $descriptions;

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

    /**
     * @var Collection|CategoryItem[]
     *
     * @ORM\OneToMany(
     *      targetEntity="Dylvn\Bundle\FaqBundle\Entity\CategoryItem",
     *      mappedBy="category",
     *      cascade={"persist","remove"},
     *      orphanRemoval=true
     * )
     */
    private $categoryItems;

    /**
     * @var bool
     *
     * @ORM\Column(name="visible_on_faq_page", type="boolean", options={"default"=true})
     */
    private bool $visibleOnFaqPage = true;

    public function __construct()
    {
        $this->titles = new ArrayCollection();
        $this->descriptions = new ArrayCollection();
        $this->categoryItems = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->code;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id): Category
    {
        $this->id = $id;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode(string $code): Category
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return ArrayCollection|LocalizedFallbackValue[]
     */
    public function getTitles()
    {
        return $this->titles;
    }

    public function addTitle(LocalizedFallbackValue $title): Category
    {
        if (!$this->titles->contains($title)) {
            $this->titles->add($title);
        }

        return $this;
    }

    public function removeTitle(LocalizedFallbackValue $title): Category
    {
        if ($this->titles->contains($title)) {
            $this->titles->removeElement($title);
        }

        return $this;
    }

    /**
     * @return Collection|LocalizedFallbackValue[]
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }

    public function addDescription(LocalizedFallbackValue $description): Category
    {
        if (!$this->descriptions->contains($description)) {
            $this->descriptions->add($description);
        }

        return $this;
    }

    public function removeDescription(LocalizedFallbackValue $description): Category
    {
        if ($this->descriptions->contains($description)) {
            $this->descriptions->removeElement($description);
        }

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition(int $position): Category
    {
        $this->position = $position;
        return $this;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): Category
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return Collection|CategoryItem[]
     */
    public function getCategoryItems()
    {
        return $this->categoryItems;
    }

    public function addCategoryItem(CategoryItem $categoryItem): Category
    {
        if (!$this->categoryItems->contains($categoryItem)) {
            $this->categoryItems->add($categoryItem);
            $categoryItem->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryItem(CategoryItem $categoryItem): Category
    {
        if ($this->categoryItems->contains($categoryItem)) {
            $this->categoryItems->removeElement($categoryItem);
        }

        return $this;
    }

    public function isVisibleOnFaqPage(): bool
    {
        return $this->visibleOnFaqPage;
    }

    public function setVisibleOnFaqPage(bool $visibleOnFaqPage): Category
    {
        $this->visibleOnFaqPage = $visibleOnFaqPage;
        return $this;
    }
}
