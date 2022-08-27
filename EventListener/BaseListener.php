<?php

namespace Newageerp\SfEventListener\EventListener;

use Newageerp\SfEventListener\Events\OnInsertEvent;
use Newageerp\SfEventListener\Events\OnRemoveEvent;
use Newageerp\SfEventListener\Events\OnUpdateEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BaseListener implements EventSubscriberInterface
{
    protected LoggerInterface $ajLogger;

    public function __construct(LoggerInterface $ajLogger)
    {
        $this->ajLogger = $ajLogger;
    }

    public function onInsert(OnInsertEvent $onInsertEvent)
    {
        $this->ajLogger->warning('onInsert');
    }
    public function onUpdate(OnUpdateEvent $onUpdateEvent)
    {
        $this->ajLogger->warning('onUpdate');
    }
    public function onRemove(OnRemoveEvent $onRemoveEvent)
    {
        $this->ajLogger->warning('onRemove');
    }

    public static function getSubscribedEvents()
    {
        return [
            OnInsertEvent::NAME => 'onInsert',
            OnUpdateEvent::NAME => 'onUpdate',
            OnRemoveEvent::NAME => 'onRemove',
        ];
    }
}
