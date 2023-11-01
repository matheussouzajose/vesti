<?php

namespace Core\Domain\Shared\Entity;

use Core\Domain\Shared\Exception\PropertyClassException;
use Core\Domain\Shared\Notification\Notification;

abstract class Entity
{
    protected Notification $notification;

    public function __construct()
    {
        $this->notification = new Notification();
    }

    public function __get($property)
    {
        if (isset($this->{$property})) {
            return $this->{$property};
        }

        return null;
    }

    public function id(): string
    {
        return (string) $this->id;
    }
}