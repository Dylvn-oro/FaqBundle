<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Migrations\Data\Demo\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Dylvn\Bundle\FaqBundle\Entity\Item;
use Oro\Bundle\LocaleBundle\Entity\Localization;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Oro\Bundle\LocaleBundle\Migrations\Data\Demo\ORM\LoadLocalizationDemoData;
use Oro\Bundle\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Yaml\Yaml;

class LoadItemDemoData extends AbstractFixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public function load(ObjectManager $manager): void
    {
        $locator = $this->container->get('file_locator');
        $filePath = $locator->locate('@DylvnFaqBundle/Migrations/Data/Demo/ORM/data/faq_items.yml');
        if (is_array($filePath)) {
            $filePath = current($filePath);
        }

        $data = Yaml::parse(file_get_contents($filePath));

        $userRepository = $manager->getRepository('OroUserBundle:User');
        /** @var User $user */
        $user = $userRepository->findOneBy([]);

        foreach ($data['faq_items'] as $code => $row) {
            $item = new Item();
            $item->setPosition($row['position']);
            $item->setEnabled($row['enabled']);
            $item->setOwner($user);
            $item->setOrganization($user->getOrganization());

            foreach ($row['questions'] as $question) {
                $lfv = new LocalizedFallbackValue();
                $lfv->setString($question['value']);
                if ($question['locale'] !== 'default') {
                    /** @var Localization $localization */
                    $localization = $this->getReference('localization_' . $question['locale']);
                    $lfv->setLocalization($localization);
                }
                $item->addQuestion($lfv);
            }

            foreach ($row['answers'] as $answer) {
                $lfv = new LocalizedFallbackValue();
                $lfv->setText($answer['value']);
                if ($answer['locale'] !== 'default') {
                    /** @var Localization $localization */
                    $localization = $this->getReference('localization_' . $answer['locale']);
                    $lfv->setLocalization($localization);
                }
                $item->addAnswer($lfv);
            }

            $manager->persist($item);
            $this->addReference('faq_item_' . $code, $item);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LoadLocalizationDemoData::class,
        ];
    }
}
