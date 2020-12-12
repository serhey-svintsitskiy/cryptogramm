<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce\ResultValidator;

interface ResultValidatorInterface
{
    public function isValid(array $result): bool;
}

