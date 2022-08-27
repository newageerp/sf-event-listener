<?php

namespace Newageerp\SfEventListener\EventListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Newageerp\SfEventListener\Events\OnInsertEvent;
use Newageerp\SfEventListener\Events\OnRemoveEvent;
use Newageerp\SfEventListener\Events\OnUpdateEvent;

class OnFlushEventListener
{
    protected LoggerInterface $ajLogger;

    protected MessageBusInterface $bus;

    protected EventDispatcherInterface $evtd;

    protected array $insertions = [];
    protected array $updates = [];
    protected array $removes = [];

    public function __construct(
        LoggerInterface $ajLogger,
        MessageBusInterface $bus,
        EventDispatcherInterface $evtd,
    ) {
        $this->ajLogger = $ajLogger;
        $this->bus = $bus;
        $this->evtd = $evtd;

        $this->insertions = [];
        $this->updates = [];
        $this->removes = [];
    }

    public function onFlush(OnFlushEventArgs $onFlushEventArgs)
    {
        $em = $onFlushEventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            $this->removes[] = $entity;
        }

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            $this->insertions[] = $entity;
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $changes = $em->getUnitOfWork()->getEntityChangeSet($entity);
            $this->updates[] = ['entity' => $entity, 'changes' => $changes];
        }
    }

    public function postFlush(PostFlushEventArgs $postFlushEventArgs)
    {
        foreach ($this->insertions as $entity) {
            $event = new OnInsertEvent($entity);
            $this->evtd->dispatch($event, OnInsertEvent::NAME);
        }

        foreach ($this->updates as $updateData) {
            $entity = $updateData['entity'];
            $changes = $updateData['changes'];

            $event = new OnUpdateEvent($entity, $changes);
            $this->evtd->dispatch($event, OnUpdateEvent::NAME);
        }

        foreach ($this->removes as $entity) {
            $event = new OnRemoveEvent($entity);
            $this->evtd->dispatch($event, OnRemoveEvent::NAME);
        }

        $this->insertions = [];
        $this->updates = [];
        $this->removes = [];
    }
}
