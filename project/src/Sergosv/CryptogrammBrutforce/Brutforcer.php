<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce;

use JetBrains\PhpStorm\Pure;
use Sergosv\CryptogrammBrutforce\NumberSet\NumberSetGenerator;
use Sergosv\CryptogrammBrutforce\NumberSet\NumberSetInterface;

class Brutforcer
{
    private array $rules = [];

    public function __construct(
        private RuleParser $ruleParser,
        private NumberSetInterface $numberSetIterator,
    ) {
    }

    public static function quickStart(array $rulesConfigs): array
    {
        $crypto = new self(new RuleParser(), new NumberSetGenerator());
        $crypto->loadRules($rulesConfigs);
        return $crypto->calculate();
    }

    public function loadRules(array $rulesConfigs): void
    {
        /** @todo check for uniq rules */
        foreach ($rulesConfigs as $rawRule) {
            $this->rules[] = $this->ruleParser->parse($rawRule);
        }
    }

    public function calculate(): array
    {
        $result = [];
        
        foreach ($this->numberSetIterator->getIterator() as $numbers) {
            if ($this->checkRules($numbers)) {
                $result[] = $numbers;
            }
        }

        return $result;
    }

    #[Pure]
    private function checkRules(array $numbers): bool
    {
        /** @var Cryptorule $cryptorule */
        foreach ($this->rules as $cryptorule) {
            if (!$cryptorule->checkRule($numbers)) {
                return false;
            }
        }

        return true;
    }
}