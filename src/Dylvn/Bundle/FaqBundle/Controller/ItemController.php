<?php

declare(strict_types=1);

/**
 * @author Dylan Trochain <dylvn-dev@pm.me>
 */

namespace Dylvn\Bundle\FaqBundle\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Dylvn\Bundle\FaqBundle\Entity\Item;
use Dylvn\Bundle\FaqBundle\Form\Type\ItemType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ItemController extends AbstractController
{
    #[Route(path: '/', name: 'dylvn_faq_item_index')]
    #[Template('@DylvnFaq/Item/index.html.twig')]
    public function indexAction(): array
    {
        return [
            'entity_class' => Item::class
        ];
    }

    #[Route(path: '/view/{id}', name: 'dylvn_faq_item_view', requirements: ['id' => '\d+'])]
    #[Template('@DylvnFaq/Item/view.html.twig')]
    public function viewAction(Item $entity): array
    {
        return [
            'entity' => $entity,
        ];
    }

    #[Route(path: '/create', name: 'dylvn_faq_item_create', options: ['expose' => true])]
    #[Template('@DylvnFaq/Item/update.html.twig')]
    public function createAction(Request $request): array|RedirectResponse
    {
        $createMessage = $this->container->get(TranslatorInterface::class)->trans(
            'dylvn.faq.controller.item.saved.message'
        );

        return $this->update(new Item(), $request, $createMessage);
    }

    #[Route(path: '/update/{id}', name: 'dylvn_faq_item_update', requirements: ['id' => '\d+'])]
    #[Template('@DylvnFaq/Item/update.html.twig')]
    public function updateAction(Item $entity, Request $request): array|RedirectResponse
    {
        $updateMessage = $this->container->get(TranslatorInterface::class)->trans(
            'dylvn.faq.controller.item.saved.message'
        );

        return $this->update($entity, $request, $updateMessage);
    }

    protected function update(
        Item $entity,
        Request $request,
        string $message = ''
    ): array|RedirectResponse {
        return $this->container->get(UpdateHandlerFacade::class)->update(
            $entity,
            $this->createForm(ItemType::class, $entity),
            $message,
            $request,
            null
        );
    }

    public static function getSubscribedServices(): array
    {
        return array_merge(
            parent::getSubscribedServices(),
            [
                TranslatorInterface::class,
                UpdateHandlerFacade::class,
                ManagerRegistry::class
            ]
        );
    }
}
