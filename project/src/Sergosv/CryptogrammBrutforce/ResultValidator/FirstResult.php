<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce\ResultValidator;

class FirstResult implements ResultValidatorInterface
{
    public function isValid(array $result): bool
    {
        return !empty($result);
    }
}
