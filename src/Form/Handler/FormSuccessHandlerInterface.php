<?php

namespace EldoMagan\FormHandlerBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request;

interface FormSuccessHandlerInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function onSuccess(Request $request);
}