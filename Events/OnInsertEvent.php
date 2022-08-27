<?php
namespace Newageerp\SfEventListener\Events;

use Symfony\Contracts\EventDispatcher\Event;

class OnInsertEvent extends Event {
    public const NAME = 'sfeventlistener.oninsert';
}