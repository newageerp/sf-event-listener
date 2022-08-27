<?php

namespace Newageerp\SfEventListener\EventListener;

use Newageerp\SfEventListener\Events\OnInsertEvent;
use Newageerp\SfEventListener\Events\OnRemoveEvent;
use Newageerp\SfEventListener\Events\OnUpdateEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BaseListener implements EventSubscriberInterface
{
    protected LoggerInterface $ajLogger;

    protected array $blacklistMethods = ['onInsert', 'onUpdate', 'onRemove'];

    protected array $methodWithParams = [];

    public function __construct(LoggerInterface $ajLogger)
    {
        $this->ajLogger = $ajLogger;
        $methods = get_class_methods($this);
        foreach ($methods as $method) {
            if (strpos($method, 'on') === 0 && !in_array($method, $this->blacklistMethods)) {
                $r = new \ReflectionMethod($this, $method);
                $params = $r->getParameters();

                $this->methodWithParams[$method] = array_map(
                    function (\ReflectionParameter $p) {
                        return $p->getType() ? $p->getType()->getName() : '-';
                    },
                    $params
                );
            }
        }
    }

    public function onInsert(OnInsertEvent $onInsertEvent)
    {
        foreach ($this->methodWithParams as $method => $params) {
            if (strpos($method, 'onInsert') === 0) {
                $callableParams = [];
                $needCall = false;
                foreach ($params as $key => $paramType) {
                    $callableParams[$key] = null;
                    if ($paramType === $onInsertEvent->getEntity()::class) {
                        $callableParams[$key] = $onInsertEvent->getEntity();
                        $needCall = true;
                    }
                }
                if ($needCall) {
                    [$this, $method](...$callableParams);
                }
            }
        }
    }
    public function onUpdate(OnUpdateEvent $onUpdateEvent)
    {
        foreach ($this->methodWithParams as $method => $params) {
            if (strpos($method, 'onUpdate') === 0) {
                $callableParams = [];
                $needCall = false;
                foreach ($params as $key => $paramType) {
                    $callableParams[$key] = null;
                    if ($paramType === $onUpdateEvent->getEntity()::class) {
                        $callableParams[$key] = $onUpdateEvent->getEntity();
                        $needCall = true;
                    }
                }
                if ($needCall) {
                    $callableParams[] = $onUpdateEvent->getChanges();
                    [$this, $method](...$callableParams);
                }
            }
        }
    }
    public function onRemove(OnRemoveEvent $onRemoveEvent)
    {
        foreach ($this->methodWithParams as $method => $params) {
            if (strpos($method, 'onRemove') === 0) {
                $callableParams = [];
                $needCall = false;
                foreach ($params as $key => $paramType) {
                    $callableParams[$key] = null;
                    if ($paramType === $onRemoveEvent->getEntity()::class) {
                        $callableParams[$key] = $onRemoveEvent->getEntity();
                        $needCall = true;
                    }
                }
                if ($needCall) {
                    [$this, $method](...$callableParams);
                }
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            OnInsertEvent::NAME => 'onInsert',
            OnUpdateEvent::NAME => 'onUpdate',
            OnRemoveEvent::NAME => 'onRemove',
        ];
    }

    /**
     * Get the value of ajLogger
     *
     * @return LoggerInterface
     */
    public function getAjLogger(): LoggerInterface
    {
        return $this->ajLogger;
    }

    /**
     * Set the value of ajLogger
     *
     * @param LoggerInterface $ajLogger
     *
     * @return self
     */
    public function setAjLogger(LoggerInterface $ajLogger): self
    {
        $this->ajLogger = $ajLogger;

        return $this;
    }
}
