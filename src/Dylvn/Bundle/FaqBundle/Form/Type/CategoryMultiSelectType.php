<?php

declare(strict_types=1);

namespace Dylvn\Bundle\FaqBundle\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Dylvn\Bundle\FaqBundle\Entity\Category;
use Oro\Bundle\FormBundle\Form\Type\OroJquerySelect2HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryMultiSelectType extends AbstractType
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);

        $data = $form->getData();
        if (!is_array($data) || empty($data)) {
            return;
        }

        $categories = $this->entityManager
            ->getRepository(Category::class)
            ->findBy(['id' => $data]);

        $result = [];
        foreach ($categories as $category) {
            $result[] = $options['converter']->convertItem($category);
        }

        $view->vars['attr']['data-selected-data'] = json_encode($result);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'autocomplete_alias' => 'dylvn_faq_category',
            'configs' => [
                'multiple' => true,
                'forceSelectedData' => true,
                'placeholder' => 'dylvn.faq.category.form.select_placeholder',
            ],
        ]);
    }

    public function getParent(): string
    {
        return OroJquerySelect2HiddenType::class;
    }
}
