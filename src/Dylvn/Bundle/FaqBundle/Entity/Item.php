<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareInterface;
use Oro\Bundle\EntityBundle\EntityProperty\DatesAwareTrait;
use Oro\Bundle\EntityConfigBundle\Metadata\Attribute\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Attribute\ConfigField;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityInterface;
use Oro\Bundle\EntityExtendBundle\Entity\ExtendEntityTrait;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Oro\Bundle\OrganizationBundle\Entity\OrganizationAwareInterface;
use Oro\Bundle\UserBundle\Entity\Ownership\AuditableUserAwareTrait;

#[ORM\Entity(repositoryClass: 'Dylvn\Bundle\FaqBundle\Entity\Repository\ItemRepository')]
#[Config(
    routeName: 'dylvn_faq_item_index',
    routeView: 'dylvn_faq_item_view',
    routeUpdate: 'dylvn_faq_item_update',
    defaultValues: [
        'entity' => ['icon' => 'fa-check-square'],
        'ownership' => [
            'owner_type' => 'USER',
            'owner_field_name' => 'owner',
            'owner_column_name' => 'user_owner_id',
            'organization_field_name' => 'organization',
            'organization_column_name' => 'organization_id'
        ],
        'dataaudit' => ['auditable' => true],
        'security' => ['type' => 'ACL', 'group_name' => '', 'category' => 'marketing']
    ],
)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'dylvn_faq_item')]
class Item implements
    DatesAwareInterface,
    OrganizationAwareInterface,
    ExtendEntityInterface
{
    use DatesAwareTrait;
    use AuditableUserAwareTrait;
    use ExtendEntityTrait;

    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    /**
     * @var ArrayCollection|LocalizedFallbackValue[]
     */
    #[ORM\ManyToMany(targetEntity: 'Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue', cascade: ['ALL'], orphanRemoval: true)]
    #[ORM\JoinTable(name: 'dylvn_faq_item_question', joinColumns: [new ORM\JoinColumn(name: 'item_id', referencedColumnName: 'id', onDelete: 'CASCADE')], inverseJoinColumns: [new ORM\JoinColumn(name: 'localized_value_id', referencedColumnName: 'id', onDelete: 'CASCADE', unique: true)])]
    #[ConfigField(defaultValues: ['dataaudit' => ['auditable' => true]])]
    private $questions;

    /**
     * @var Collection|LocalizedFallbackValue[]
     */
    #[ORM\ManyToMany(targetEntity: 'Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue', cascade: ['ALL'], orphanRemoval: true)]
    #[ORM\JoinTable(name: 'dylvn_faq_item_answer', joinColumns: [new ORM\JoinColumn(name: 'item_id', referencedColumnName: 'id', onDelete: 'CASCADE')], inverseJoinColumns: [new ORM\JoinColumn(name: 'localized_value_id', referencedColumnName: 'id', onDelete: 'CASCADE', unique: true)])]
    #[ConfigField(defaultValues: ['dataaudit' => ['auditable' => true]])]
    private $answers;

    /**
     * @var int
     */
    #[ORM\Column(name: 'position', type: 'integer', options: ['default' => 0])]
    private $position = 0;

    /**
     * @var bool
     */
    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private $enabled = true;

    /**
     * @var Collection|CategoryItem[]
     */
    #[ORM\OneToMany(targetEntity: 'Dylvn\Bundle\FaqBundle\Entity\CategoryItem', mappedBy: 'item', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private $categoryItems;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->categoryItems = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id): Item
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ArrayCollection|LocalizedFallbackValue[]
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    public function addQuestion(LocalizedFallbackValue $question): Item
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }

    public function removeQuestion(LocalizedFallbackValue $question): Item
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
        }

        return $this;
    }

    /**
     * @return Collection|LocalizedFallbackValue[]
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    public function addAnswer(LocalizedFallbackValue $answer): Item
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
        }

        return $this;
    }

    public function removeAnswer(LocalizedFallbackValue $answer): Item
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
        }

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition(int $position): Item
    {
        $this->position = $position;
        return $this;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): Item
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

    public function addCategoryItem(CategoryItem $categoryItem): Item
    {
        if (!$this->categoryItems->contains($categoryItem)) {
            $this->categoryItems->add($categoryItem);
        }

        return $this;
    }

    public function removeCategoryItem(CategoryItem $categoryItem): Item
    {
        if ($this->categoryItems->contains($categoryItem)) {
            $this->categoryItems->removeElement($categoryItem);
        }

        return $this;
    }
}
