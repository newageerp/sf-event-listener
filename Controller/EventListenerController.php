<?php

namespace Newageerp\SfEventListener\Controller;

use Newageerp\SfBaseEntity\Controller\OaBaseController;
use Newageerp\SfEventListener\Events\BgCallbackEvent;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @Route(path="/app/nae-core/event-listener")
 */
class EventListenerController extends OaBaseController
{
    protected EventDispatcherInterface $evtd;

    public function __construct(
        EventDispatcherInterface $evtd,
    ) {
        $this->evtd = $evtd;
    }
    /**
     * @Route(path="/callback", methods={"POST"})
     */
    public function callback(Request $request)
    {
        $request = $this->transformJsonBody($request);

        $eventName = $request->get('event');
        $id = $request->get('id');
        $data = $request->get('data');

        $event = new BgCallbackEvent($id, $data);
        $this->evtd->dispatch($event, $eventName);
    }
}
