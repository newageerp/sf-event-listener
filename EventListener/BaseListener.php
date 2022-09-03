<?php

namespace Newageerp\SfEventListener\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Newageerp\SfEventListener\Events\OnInsertEvent;
use Newageerp\SfEventListener\Events\OnPreRemoveEvent;
use Newageerp\SfEventListener\Events\OnRemoveEvent;
use Newageerp\SfEventListener\Events\OnUpdateEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class BaseListener implements EventSubscriberInterface, IBaseListener
{
    protected LoggerInterface $ajLogger;

    protected EntityManagerInterface $em;

    protected array $blacklistMethods = ['onInsert', 'onUpdate', 'onRemove'];

    protected array $methodWithParams = [];

    public function __construct(LoggerInterface $ajLogger, EntityManagerInterface $em)
    {
        $this->ajLogger = $ajLogger;
        $this->em = $em;

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

    public function onPreRemove(OnPreRemoveEvent $onPreRemoveEvent) {
        foreach ($this->getMethodWithParams() as $method => $params) {
            if ($method === 'onPreRemoveAll') {
                [$this, $method]($onPreRemoveEvent->getEntity(), $onPreRemoveEvent);
            } else if (strpos($method, 'onPreRemove') === 0) {
                $callableParams = [];
                $needCall = false;
                foreach ($params as $key => $paramType) {
                    $callableParams[$key] = null;
                    if ($paramType === $onPreRemoveEvent->getEntity()::class) {
                        $callableParams[$key] = $onPreRemoveEvent->getEntity();
                        $needCall = true;
                    }
                    if ($paramType === $onPreRemoveEvent::class) {
                        $callableParams[$key] = $onPreRemoveEvent;
                    }
                }
                if ($needCall) {
                    [$this, $method](...$callableParams);
                }
            }
        }
    }

    public function onInsert(OnInsertEvent $onInsertEvent)
    {
        foreach ($this->getMethodWithParams() as $method => $params) {
            if ($method === 'onInsertAll') {
                [$this, $method]($onInsertEvent->getEntity(), $onInsertEvent);
            } else if (strpos($method, 'onInsert') === 0) {
                $callableParams = [];
                $needCall = false;
                foreach ($params as $key => $paramType) {
                    $callableParams[$key] = null;
                    if ($paramType === $onInsertEvent->getEntity()::class) {
                        $callableParams[$key] = $onInsertEvent->getEntity();
                        $needCall = true;
                    }
                    if ($paramType === $onInsertEvent::class) {
                        $callableParams[$key] = $onInsertEvent;
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
        foreach ($this->getMethodWithParams() as $method => $params) {
            if ($method === 'onUpdateAll') {
                [$this, $method]($onUpdateEvent->getEntity(), $onUpdateEvent);
            } else if (strpos($method, 'onUpdate') === 0) {
                $callableParams = [];
                $needCall = false;
                foreach ($params as $key => $paramType) {
                    $callableParams[$key] = null;
                    if ($paramType === $onUpdateEvent->getEntity()::class) {
                        $callableParams[$key] = $onUpdateEvent->getEntity();
                        $needCall = true;
                    }
                    if ($paramType === $onUpdateEvent::class) {
                        $callableParams[$key] = $onUpdateEvent;
                    }
                }
                if ($needCall) {
                    [$this, $method](...$callableParams);
                }
            }
        }
    }
    public function onRemove(OnRemoveEvent $onRemoveEvent)
    {
        foreach ($this->getMethodWithParams() as $method => $params) {
            if ($method === 'onRemoveAll') {
                [$this, $method]($onRemoveEvent->getEntity(), $onRemoveEvent);
            } else if (strpos($method, 'onRemove') === 0) {
                $callableParams = [];
                $needCall = false;
                foreach ($params as $key => $paramType) {
                    $callableParams[$key] = null;
                    if ($paramType === $onRemoveEvent->getEntity()::class) {
                        $callableParams[$key] = $onRemoveEvent->getEntity();
                        $needCall = true;
                    }
                    if ($paramType === $onRemoveEvent::class) {
                        $callableParams[$key] = $onRemoveEvent;
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
        $key = static::class;

        return [
            OnInsertEvent::NAME => 'onInsert',
            OnUpdateEvent::NAME => 'onUpdate',
            OnRemoveEvent::NAME => 'onRemove',
            OnPreRemoveEvent::NAME => 'onPreRemove',
            $key => 'onBgCall'
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

    /**
     * Get the value of em
     *
     * @return EntityManagerInterface
     */
    public function getEm(): EntityManagerInterface
    {
        return $this->em;
    }

    /**
     * Set the value of em
     *
     * @param EntityManagerInterface $em
     *
     * @return self
     */
    public function setEm(EntityManagerInterface $em): self
    {
        $this->em = $em;

        return $this;
    }

    public function addLog(string $message)
    {
        $this->getAjLogger()->warning($this::class . ' ' . $message);
    }

    /**
     * Get the value of methodWithParams
     *
     * @return array
     */
    public function getMethodWithParams(): array
    {
        return $this->methodWithParams;
    }

    /**
     * Set the value of methodWithParams
     *
     * @param array $methodWithParams
     *
     * @return self
     */
    public function setMethodWithParams(array $methodWithParams): self
    {
        $this->methodWithParams = $methodWithParams;

        return $this;
    }
}
