<?php

namespace Newageerp\SfEventListener\Events;

use Symfony\Contracts\EventDispatcher\Event;

class OnRemoveEvent extends Event
{
    public const NAME = 'sfeventlistener.onremove';

    protected object $entity;

    /**
     * @var BgRequestEvent[] $requests
     */
    protected array $requests = [];

    public function __construct(object $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Get the value of entity
     *
     * @return object
     */
    public function getEntity(): object
    {
        return $this->entity;
    }

    /**
     * Set the value of entity
     *
     * @param object $entity
     *
     * @return self
     */
    public function setEntity(object $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get the value of requests
     *
     * @return array
     */
    public function getRequests(): array
    {
        return $this->requests;
    }

    /**
     * Set the value of requests
     *
     * @param array $requests
     *
     * @return self
     */
    public function setRequests(array $requests): self
    {
        $this->requests = $requests;

        return $this;
    }

    public function addRequest(BgRequestEvent $event) {
        $this->requests[] = $event;
    }
}
