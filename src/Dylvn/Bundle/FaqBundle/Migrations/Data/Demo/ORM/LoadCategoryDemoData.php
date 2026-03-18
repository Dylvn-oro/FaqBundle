<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Migrations\Data\Demo\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Dylvn\Bundle\FaqBundle\Entity\Category;
use Dylvn\Bundle\FaqBundle\Entity\CategoryItem;
use Dylvn\Bundle\FaqBundle\Entity\Item;
use Oro\Bundle\LocaleBundle\Entity\Localization;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Oro\Bundle\LocaleBundle\Migrations\Data\Demo\ORM\LoadLocalizationDemoData;
use Oro\Bundle\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Yaml\Yaml;

class LoadCategoryDemoData extends AbstractFixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public function load(ObjectManager $manager): void
    {
        $locator = $this->container->get('file_locator');
        $filePath = $locator->locate('@DylvnFaqBundle/Migrations/Data/Demo/ORM/data/faq_categories.yml');
        if (is_array($filePath)) {
            $filePath = current($filePath);
        }

        $data = Yaml::parse(file_get_contents($filePath));

        $userRepository = $manager->getRepository('OroUserBundle:User');
        /** @var User $user */
        $user = $userRepository->findOneBy([]);

        foreach ($data['faq_categories'] as $code => $row) {
            $category = new Category();
            $category->setCode($row['code']);
            $category->setPosition($row['position']);
            $category->setEnabled($row['enabled']);
            $category->setOwner($user);
            $category->setOrganization($user->getOrganization());

            foreach ($row['titles'] as $title) {
                $lfv = new LocalizedFallbackValue();
                $lfv->setString($title['value']);
                if ($title['locale'] !== 'default') {
                    /** @var Localization $localization */
                    $localization = $this->getReference('localization_' . $title['locale']);
                    $lfv->setLocalization($localization);
                }
                $category->addTitle($lfv);
            }

            foreach ($row['descriptions'] as $desc) {
                $lfv = new LocalizedFallbackValue();
                $lfv->setText($desc['value']);
                if ($desc['locale'] !== 'default') {
                    /** @var Localization $localization */
                    $localization = $this->getReference('localization_' . $desc['locale']);
                    $lfv->setLocalization($localization);
                }
                $category->addDescription($lfv);
            }

            foreach ($row['items'] as $itemData) {
                /** @var Item $item */
                $item = $this->getReference($itemData['ref']);

                $link = new CategoryItem();
                $link->setCategory($category);
                $link->setItem($item);
                $link->setPosition($itemData['position']);

                $manager->persist($link);
            }

            $manager->persist($category);
            $this->addReference('faq_category_' . $code, $category);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LoadItemDemoData::class,
            LoadLocalizationDemoData::class,
        ];
    }
}
