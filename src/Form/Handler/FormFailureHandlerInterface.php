<?php

namespace EldoMagan\FormHandlerBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request;

interface FormFailureHandlerInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function onFailure(Request $request);
}