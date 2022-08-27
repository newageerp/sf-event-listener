<?php
namespace Newageerp\SfEventListener\EventListener;

interface IBaseListener {
    public function onBgCall(int $id, array $data);
}