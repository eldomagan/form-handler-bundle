<?php

namespace EldoMagan\FormHandlerBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @author Eldo Magan <magan.eldo@gmail.com>
 */
interface FormHandlerInterface
{
    /**
     * @return string|FormTypeInterface
     */
    public function getType();

    /**
     * @return mixed
     */
     public function getData();

    /**
     * @return array
     */
    public function getOptions();

    /**
     * @return FormInterface
     */
    public function getForm();

    /**
     * @param FormInterface $form
     */
    public function setForm(FormInterface $form);
}