<?php
namespace Newageerp\SfEventListener\Events;

use Symfony\Contracts\EventDispatcher\Event;

class OnUpdateEvent extends Event {
    public const NAME = 'sfeventlistener.onupdate';
}