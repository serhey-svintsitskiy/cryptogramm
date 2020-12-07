<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce\NumberSet;

interface NumberSetInterface
{
    public function getIterator(): iterable;
}

