<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce\ResultValidator;

class AllResults implements ResultValidatorInterface
{
    public function isValid(array $result): bool
    {
        return false;
    }
}
