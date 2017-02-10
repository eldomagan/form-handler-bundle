<?php

namespace EldoMagan\FormHandlerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class FormHandlerResolverCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('form.handler.argument_resolver')) {
            return;
        }

        $definition = $container->getDefinition('form.handler.argument_resolver');

        $taggedServices = $container->findTaggedServiceIds('form.handler');
                
        foreach ($taggedServices as $id => $attributes) {            
            $definition->addMethodCall(
                'addFormHandler',
                [$id, $container->getDefinition($id)->getClass()]
            );
        }
    }
}