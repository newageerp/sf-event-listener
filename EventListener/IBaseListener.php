<?php
namespace Newageerp\SfEventListener\EventListener;

use Newageerp\SfEventListener\Events\BgCallbackEvent;

interface IBaseListener {
    public function onBgCall(BgCallbackEvent $event);
}