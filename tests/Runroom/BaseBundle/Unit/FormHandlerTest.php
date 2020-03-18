<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Service\FormHandler;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class FormHandlerTest extends TestCase
{
    protected $formFactory;
    protected $session;
    protected $formHandler;

    protected function setUp(): void
    {
        $this->formFactory = $this->prophesize(FormFactoryInterface::class);
        $this->session = new Session(new MockArraySessionStorage());

        $this->formHandler = new FormHandler(
            $this->formFactory->reveal(),
            $this->session
        );
    }

    /**
     * @test
     */
    public function itHandlesFormsWithoutBeingSubmitted()
    {
        $this->configureFormFactory(false);

        $form = $this->formHandler->handleForm(FormType::class);

        $this->assertInstanceOf(FormInterface::class, $form);
    }

    /**
     * @test
     */
    public function itHandlesSubmittedForms()
    {
        $this->configureFormFactory();

        $form = $this->formHandler->handleForm(FormType::class);

        $this->assertInstanceOf(FormInterface::class, $form);
        $this->assertSame(['success'], $this->session->getFlashBag()->get('form_types'));
    }

    private function configureFormFactory(bool $submitted = true, bool $valid = true): void
    {
        $form = $this->prophesize(FormInterface::class);

        $this->formFactory->create(FormType::class, Argument::any())->willReturn($form->reveal());

        $form->handleRequest()->shouldBeCalled();
        $form->getName()->willReturn('form_types');
        $form->isSubmitted()->willReturn($submitted);
        $form->isValid()->willReturn($valid);
    }
}
