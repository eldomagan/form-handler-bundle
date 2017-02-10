<?php

namespace EldoMagan\FormHandlerBundle\Service;

use EldoMagan\FormHandlerBundle\Form\Handler\FormFailureHandlerInterface;
use EldoMagan\FormHandlerBundle\Form\Handler\FormSuccessHandlerInterface;
use EldoMagan\FormHandlerBundle\Form\Handler\FormHandlerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FormHandler
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var array|Request
     */
    private $submittedData;

    public function __construct(FormFactoryInterface $formFactory, RequestStack $requestStack)
    {
        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
    }

    public function process(FormHandlerInterface $formHandler)
    {
        $this->setup($formHandler);
        
        $form = $formHandler->getForm();        
        $request = $this->requestStack->getCurrentRequest();

        if (!$this->submittedData) {
            $this->submittedData = $request;
        }

        if ($this->submittedData instanceof Request) {
            $form->handleRequest($this->submittedData);
        } else {
            $form->submit($this->submittedData);
        }

        // Reinitialize $submittedData
        $this->submittedData = null;

        if (!$form->isSubmitted()) {
            return null;
        }
    
        if ($form->isValid()) {            
            if ($formHandler instanceof FormSuccessHandlerInterface) {
                return $formHandler->onSuccess($request);
            }
        } elseif ($formHandler instanceof FormFailureHandlerInterface) {
            return $formHandler->onFailure($request);
        }
    }

    /**
     * Create formHandle form it not yet created
     */
    public function setup(FormHandlerInterface $formHandler, $data = null)
    {
        $form = $formHandler->getForm();

        if (null === $data) {
            $data = $formHandler->getData();
        }

        if (null === $form) {
            $form = $this->formFactory->create(
                $formHandler->getType(),
                $data,
                $formHandler->getOptions()
            );

            $formHandler->setForm($form);
        }
    }

    /**
     * Set submited datas 
     * 
     * @param array|Request $submitedData
     *
     * @return FormHandler
     */
    public function with($submittedData)
    {
        $this->submittedData = $submittedData;

        return $this;
    }
}