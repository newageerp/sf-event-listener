<?php
namespace Newageerp\SfEventListener\Events;

use Symfony\Contracts\EventDispatcher\Event;

class OnUpdateEvent extends Event {
    public const NAME = 'sfeventlistener.onupdate';

    protected object $entity;

    protected array $changes;

    /**
     * @var BgRequestEvent[] $requests
     */
    protected array $requests = [];

    public function __construct(object $entity, array $changes)
    {
        $this->entity = $entity;
        $this->changes = $changes;
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
     * Get the value of changes
     *
     * @return array
     */
    public function getChanges(): array
    {
        return $this->changes;
    }

    /**
     * Set the value of changes
     *
     * @param array $changes
     *
     * @return self
     */
    public function setChanges(array $changes): self
    {
        $this->changes = $changes;

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