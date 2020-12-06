<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce\Factory;


use JetBrains\PhpStorm\Pure;
use Sergosv\CryptogrammBrutforce\Brutforcer;
use Sergosv\CryptogrammBrutforce\RuleParser;

class BrutforcerFactory
{
    public function __construct(
        private RuleParser $ruleParser,
    ) {
    }

    #[Pure]
    public function create(): Brutforcer
    {
        return new Brutforcer($this->ruleParser);
    }
}
