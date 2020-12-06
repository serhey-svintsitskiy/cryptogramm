<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce;

class RuleParser
{
    private string $regex = '/([abcdefghij]+)([+\-*\/])([abcdefghij]+)=([abcdefghij]+)/i';

    public function parse(string $rawRule): Cryptorule
    {
        preg_match($this->regex, str_replace(' ', '', trim($rawRule)), $matches, PREG_UNMATCHED_AS_NULL);

        $firstNumber = str_split(strrev($matches[1]));
        $secondNumber = str_split(strrev($matches[3]));
        $resultNumber = str_split(strrev($matches[4]));
        $operation = $matches[2];

        return new Cryptorule($firstNumber, $secondNumber, $resultNumber, $operation);
    }
}
