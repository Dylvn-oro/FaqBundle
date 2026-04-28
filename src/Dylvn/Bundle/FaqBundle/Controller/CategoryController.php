<?php

declare(strict_types=1);

/**
 * @author Dylan Trochain <dylvn-dev@pm.me>
 */

namespace Dylvn\Bundle\FaqBundle\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Dylvn\Bundle\FaqBundle\Entity\Category;
use Dylvn\Bundle\FaqBundle\Form\Type\CategoryType;
use Oro\Bundle\FormBundle\Model\UpdateHandlerFacade;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategoryController extends AbstractController
{
    /**
     * @Route(path="/", name="dylvn_faq_category_index")
     * @Template()
     */
    public function indexAction(): array
    {
        return [
            'entity_class' => Category::class
        ];
    }

    /**
     * @Route(path="/view/{id}", name="dylvn_faq_category_view", requirements={"id"="\d+"})
     * @Template()
     */
    public function viewAction(Category $entity): array
    {
        return [
            'entity' => $entity,
        ];
    }

    /**
     * @Route(path="/create", name="dylvn_faq_category_create", options={"expose"=true})
     * @Template("@DylvnFaq/Category/update.html.twig")
     */
    public function createAction(Request $request): array|RedirectResponse
    {
        $createMessage = $this->container->get(TranslatorInterface::class)->trans(
            'dylvn.faq.controller.category.saved.message'
        );

        return $this->update(new Category(), $request, $createMessage);
    }

    /**
     * @Route(path="/update/{id}", name="dylvn_faq_category_update", requirements={"id"="\d+"})
     * @Template("@DylvnFaq/Category/update.html.twig")
     */
    public function updateAction(Category $entity, Request $request): array|RedirectResponse
    {
        $updateMessage = $this->container->get(TranslatorInterface::class)->trans(
            'dylvn.faq.controller.category.saved.message'
        );

        return $this->update($entity, $request, $updateMessage);
    }

    protected function update(
        Category $entity,
        Request $request,
        string $message = ''
    ): array|RedirectResponse {
        return $this->container->get(UpdateHandlerFacade::class)->update(
            $entity,
            $this->createForm(CategoryType::class, $entity),
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
