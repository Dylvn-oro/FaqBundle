<?php

declare(strict_types=1);

/**
 * @author Dylan Trochain <dylvn-dev@pm.me>
 */

namespace Dylvn\Bundle\FaqBundle\Tests\Unit\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Dylvn\Bundle\FaqBundle\Entity\Category;
use Dylvn\Bundle\FaqBundle\Form\Type\CategoryMultiSelectType;
use Oro\Bundle\FormBundle\Autocomplete\ConverterInterface;
use Oro\Bundle\FormBundle\Form\Type\OroJquerySelect2HiddenType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryMultiSelectTypeTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private CategoryMultiSelectType $formType;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->formType = new CategoryMultiSelectType($this->entityManager);
    }

    public function testGetParent(): void
    {
        $this->assertEquals(OroJquerySelect2HiddenType::class, $this->formType->getParent());
    }

    public function testConfigureOptions(): void
    {
        $resolver = new OptionsResolver();
        $this->formType->configureOptions($resolver);
        $defaults = $resolver->getDefinedOptions();

        $this->assertContains('autocomplete_alias', $defaults);
        $this->assertContains('configs', $defaults);
    }

    public function testBuildViewSkipsWhenDataIsNull(): void
    {
        $this->entityManager->expects($this->never())->method('getRepository');

        $view = new FormView();
        $view->vars['attr'] = [];

        $form = $this->createMock(FormInterface::class);
        $form->method('getData')->willReturn(null);

        $this->formType->buildView($view, $form, [
            'converter' => $this->createMock(ConverterInterface::class),
        ]);

        $this->assertArrayNotHasKey('data-selected-data', $view->vars['attr']);
    }

    public function testBuildViewSkipsWhenDataIsEmptyArray(): void
    {
        $this->entityManager->expects($this->never())->method('getRepository');

        $view = new FormView();
        $view->vars['attr'] = [];

        $form = $this->createMock(FormInterface::class);
        $form->method('getData')->willReturn([]);

        $this->formType->buildView($view, $form, [
            'converter' => $this->createMock(ConverterInterface::class),
        ]);

        $this->assertArrayNotHasKey('data-selected-data', $view->vars['attr']);
    }

    public function testBuildViewSetsSelectedDataForArrayOfIds(): void
    {
        $category = new Category();
        $category->setId(1)->setCode('faq');

        $repository = $this->createMock(EntityRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->with(['id' => [1, 2]])
            ->willReturn([$category]);

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->with(Category::class)
            ->willReturn($repository);

        $converter = $this->createMock(ConverterInterface::class);
        $converter->expects($this->once())
            ->method('convertItem')
            ->with($category)
            ->willReturn(['id' => 1, 'title' => 'FAQ']);

        $view = new FormView();
        $view->vars['attr'] = [];

        $form = $this->createMock(FormInterface::class);
        $form->method('getData')->willReturn([1, 2]);

        $this->formType->buildView($view, $form, ['converter' => $converter]);

        $this->assertArrayHasKey('data-selected-data', $view->vars['attr']);
        $this->assertJsonStringEqualsJsonString(
            json_encode([['id' => 1, 'title' => 'FAQ']]),
            $view->vars['attr']['data-selected-data']
        );
    }

    public function testBuildViewSkipsWhenDataIsString(): void
    {
        $this->entityManager->expects($this->never())->method('getRepository');

        $view = new FormView();
        $view->vars['attr'] = [];

        $form = $this->createMock(FormInterface::class);
        $form->method('getData')->willReturn('1,2');

        $this->formType->buildView($view, $form, [
            'converter' => $this->createMock(ConverterInterface::class),
        ]);

        $this->assertArrayNotHasKey('data-selected-data', $view->vars['attr']);
    }
}
