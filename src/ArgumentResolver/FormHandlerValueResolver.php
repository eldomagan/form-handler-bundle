<?php

namespace EldoMagan\FormHandlerBundle\ArgumentResolver;

use EldoMagan\FormHandlerBundle\Form\Handler\AbstractFormHandler;
use EldoMagan\FormHandlerBundle\Form\Handler\FormHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class FormHandlerValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $formHandlers;

    /**
     * Constructor
     */
    public function __construct(ContainerInterface $container) 
    {
        $this->container = $container;
        $this->formHandlers = [];
    }

    public function addFormHandler($id, $class)
    {
        if (! class_exists($class)) {
            throw new \RuntimeException(sprintf('Class "%s" does not exists. Check your form handler service configuration.', $class));
        }

        $this->formHandlers[$id] = $class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $serviceId;

        foreach ($this->formHandlers as $id => $class) {
            if ($class === $argument->getType()) {
                $serviceId = $id;
                break;
            }
        }

        $formHandler = $this->container->get($serviceId);
        
        if (!($formHandler instanceof FormHandlerInterface)) {
            throw new \RuntimeException(sprintf('Class "%s" must implements %s.', $argument->getType(), FormHandlerInterface::class));
        }

        if ($formHandler instanceof AbstractFormHandler) {
            $formHandler->setEntityManager($this->container->get('doctrine.orm.entity_manager'));
        }

        yield $formHandler;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return in_array($argument->getType(), $this->formHandlers);
    }
}