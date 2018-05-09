<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Runroom\BaseBundle\Service\FormHandler;
use Runroom\BaseBundle\ViewModel\BasicFormViewModel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormConfigInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class FormHandlerTest extends TestCase
{
    protected function setUp()
    {
        $this->formFactory = $this->prophesize(FormFactoryInterface::class);
        $this->eventDispatcher = new EventDispatcher();
        $this->requestStack = new RequestStack();
        $this->request = new Request();
        $this->requestStack->push($this->request);
        $this->session = new Session(new MockArraySessionStorage());

        $this->formHandler = new FormHandler(
            $this->formFactory->reveal(),
            $this->eventDispatcher,
            $this->requestStack,
            $this->session
        );
    }

    /**
     * @test
     */
    public function itHandlesFormsWithoutBeingSubmitted()
    {
        $form = $this->configureForm(false);

        $this->eventDispatcher->addListener('form.form_types.event.success', function () {
            $this->fail("This shouldn't be called");
        });

        $model = $this->formHandler->handleForm(FormType::class);

        $this->assertInstanceOf(BasicFormViewModel::class, $model);
    }

    /**
     * @test
     */
    public function itHandlesSubmittedFormsAndDoesNotFireFlashMessagesIfNotSuccess()
    {
        $form = $this->configureForm();

        $this->eventDispatcher->addListener('form.form_types.event.success', function (GenericEvent $event) {
            $event->getSubject()->setIsSuccess(false);
        });

        $model = $this->formHandler->handleForm(FormType::class);

        $this->assertEmpty($this->session->getFlashBag()->get('form_types'));
    }

    /**
     * @test
     */
    public function itHandlesSubmittedForms()
    {
        $form = $this->configureForm();

        $this->eventDispatcher->addListener('form.form_types.event.success', function (GenericEvent $event) {
            $this->assertTrue($event->getSubject()->getIsSuccess());
        });

        $model = $this->formHandler->handleForm(FormType::class);

        $this->assertInstanceOf(BasicFormViewModel::class, $model);
        $this->assertInstanceOf(FormView::class, $model->getFormView());
        $this->assertSame($form->reveal(), $model->getForm());
        $this->assertSame(['success'], $this->session->getFlashBag()->get('form_types'));
    }

    private function configureForm(bool $submitted = true, bool $valid = true): ObjectProphecy
    {
        $form = $this->prophesize(FormInterface::class);
        $formView = $this->prophesize(FormView::class);
        $formConfig = $this->prophesize(FormConfigInterface::class);

        $formConfig->getDataClass()->shouldBeCalled();
        $this->formFactory->create(FormType::class)->willReturn($form->reveal());

        $form->handleRequest($this->request)->shouldBeCalled();
        $form->getConfig()->willReturn($formConfig->reveal());
        $form->getData()->shouldBeCalled();
        $form->setData(null)->shouldBeCalled();
        $form->getName()->willReturn('form_types');
        $form->isSubmitted()->willReturn($submitted);
        $form->isValid()->willReturn($valid);
        $form->createView()->willReturn($formView->reveal());

        return $form;
    }
}
