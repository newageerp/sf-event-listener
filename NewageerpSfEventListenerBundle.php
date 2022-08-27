<?php
namespace Newageerp\SfEventListener;

use Newageerp\SfEventListener\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;


class NewageerpSfEventListenerBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new Extension();
    }
}
