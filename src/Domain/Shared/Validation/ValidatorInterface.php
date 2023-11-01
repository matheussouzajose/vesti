<?php

namespace Core\Domain\Shared\Validation;

interface ValidatorInterface
{
    public function validate(object $object): void;
}
