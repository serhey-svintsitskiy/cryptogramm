<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce\NumberSet;

use Iterator;
use JetBrains\PhpStorm\Pure;

class NumberSetGenerator implements NumberSetInterface
{
    #[Pure]
    public function getIterator(): iterable
    {
        $n = 10;
        $a = array_fill(0, $n, -1);
        $i = 0;
        while ($i >= 0) {
            while ($i < $n) {
                $j = $a[$i];
                while (in_array(++$j, $a, true) && $j < $n) {
                }
                if ($j === $n) {
                    break;
                }
                $a[$i++] = $j;
            }
            if ($i === $n) {
                yield $a;
                $i--;
            }
            $a[$i--] = -1;
        }
    }
}
