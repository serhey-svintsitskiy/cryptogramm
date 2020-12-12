<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce\Factory;

use Sergosv\CryptogrammBrutforce\Brutforcer;
use Sergosv\CryptogrammBrutforce\NumberSet\NumberSetGenerator;
use Sergosv\CryptogrammBrutforce\ResultValidator\FirstResult;
use Sergosv\CryptogrammBrutforce\Rule\RuleParser;
use Sergosv\CryptogrammBrutforce\Rule\RuleSet;

class BrutforcerFactory
{
    public function __construct(
        private RuleParser $ruleParser,
        private RuleSet $ruleSet,
    ) {
    }

    public function create($rulesConfigs): Brutforcer
    {
        foreach ($rulesConfigs as $rawRule) {
            $this->ruleSet->add($this->ruleParser->parse($rawRule));
        }

        return new Brutforcer(new NumberSetGenerator(), $this->ruleSet, new FirstResult());
    }
}
