<?php
namespace Newageerp\SfEventListener\Events;

use Symfony\Contracts\EventDispatcher\Event;

class OnUpdateEvent extends Event {
    public const NAME = 'sfeventlistener.onupdate';

    protected object $entity;

    protected array $changes;

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
}