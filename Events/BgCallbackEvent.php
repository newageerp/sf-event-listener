<?php

namespace Newageerp\SfEventListener\Events;

use Symfony\Contracts\EventDispatcher\Event;

class BgCallbackEvent extends Event
{
    public const NAME = 'sfeventlistener.bgcallback';

    protected int $id = 0;

    protected array $data = [];

    public function __construct(int $id, array $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @param array $data
     *
     * @return self
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
