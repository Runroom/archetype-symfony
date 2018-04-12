<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\FormHandler;
use Runroom\BaseBundle\ViewModel\BasicFormViewModel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FormHandlerTest extends TestCase
{
    public function setUp()
    {
        $this->formFactory = $this->prophesize(FormFactoryInterface::class);
        $this->eventDispatcher = new EventDispatcher();
        $this->requestStack = new RequestStack();
        $this->request = new Request();
        $this->requestStack->push($this->request);

        $this->formHandler = new FormHandler(
            $this->formFactory->reveal(),
            $this->eventDispatcher,
            $this->requestStack
        );
    }

    /**
     * @test
     */
    public function itHandlesFormsWithoutBeingSubmitted()
    {
        $form = $this->prophesize(FormInterface::class);

        $this->formFactory->create(FormType::class)->willReturn($form->reveal());
        $form->handleRequest($this->request)->shouldBeCalled();
        $form->getName()->willReturn('form_types');
        $form->isSubmitted()->willReturn(false);

        $this->eventDispatcher->addListener('form.form_types.event.success', function () {
            $this->fail("This shouldn't be called");
        });

        $model = $this->formHandler->handleForm(FormType::class);

        $this->assertInstanceOf(BasicFormViewModel::class, $model);
    }

    /**
     * @test
     */
    public function itHandlesSubmittedForms()
    {
        $form = $this->prophesize(FormInterface::class);
        $formView = $this->prophesize(FormView::class);

        $this->formFactory->create(FormType::class)->willReturn($form->reveal());
        $form->handleRequest($this->request)->shouldBeCalled();
        $form->getName()->willReturn('form_types');
        $form->isSubmitted()->willReturn(true);
        $form->isValid()->willReturn(true);
        $form->createView()->willReturn($formView->reveal());

        $this->eventDispatcher->addListener('form.form_types.event.success', function (GenericEvent $event) {
            $this->assertTrue($event->getSubject()->getIsSuccess());
            $event->getSubject()->setIsSuccess(false);
        });

        $model = $this->formHandler->handleForm(FormType::class);

        $this->assertInstanceOf(BasicFormViewModel::class, $model);
        $this->assertFalse($model->getIsSuccess());
        $this->assertInstanceOf(FormView::class, $model->getFormView());
        $this->assertSame($form->reveal(), $model->getForm());
    }
}
