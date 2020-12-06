<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce\Rule;

class RuleParser
{
    private string $regex = '/([abcdefghij]+)([+\-*\/])([abcdefghij]+)=([abcdefghij]+)/i';

    public function parse(string $rawRule): Cryptorule
    {
        $preparedRawRule = str_replace(' ', '', trim($rawRule));
        preg_match($this->regex, $preparedRawRule, $matches, PREG_UNMATCHED_AS_NULL);

        return new Cryptorule($preparedRawRule, $matches[2], $matches[1], $matches[3], $matches[4]);
    }
}
