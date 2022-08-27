<?php

namespace Newageerp\SfEventListener\EventListener;

use Newageerp\SfEventListener\Events\OnInsertEvent;
use Newageerp\SfEventListener\Events\OnRemoveEvent;
use Newageerp\SfEventListener\Events\OnUpdateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BaseListener implements EventSubscriberInterface
{
    public function onInsert(OnInsertEvent $onInsertEvent)
    {
    }
    public function onUpdate(OnUpdateEvent $onUpdateEvent)
    {
    }
    public function onRemove(OnRemoveEvent $onRemoveEvent)
    {
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
