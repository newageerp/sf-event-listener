<?php
namespace Newageerp\SfEventListener\Events;

use Symfony\Contracts\EventDispatcher\Event;

class OnRemoveEvent extends Event {
    public const NAME = 'sfeventlistener.onremove';
}