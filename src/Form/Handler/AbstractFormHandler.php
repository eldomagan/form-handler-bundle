<?php

namespace EldoMagan\FormHandlerBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;

abstract class AbstractFormHandler implements FormHandlerInterface
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     *
     */
    protected $entityManager;

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * {@inheritdoc}
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;
        
        return $this;
    }

    public function createFormView()
    {
        return $this->form->createView();
    }

    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }
}