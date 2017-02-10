<?php

namespace EldoMagan\FormHandlerBundle;

use EldoMagan\FormHandlerBundle\DependencyInjection\Compiler\FormHandlerResolverCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FormHandlerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FormHandlerResolverCompilerPass());
    }
}
