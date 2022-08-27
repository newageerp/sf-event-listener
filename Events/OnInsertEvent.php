<?php

namespace Newageerp\SfEventListener\Events;

use Symfony\Contracts\EventDispatcher\Event;

class OnInsertEvent extends Event
{
    public const NAME = 'sfeventlistener.oninsert';

    protected object $entity;

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
}
