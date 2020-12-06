<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce\NumberSet;

use Iterator;

interface NumberSetInterface
{
    public function getIterator(): Iterator;
}

