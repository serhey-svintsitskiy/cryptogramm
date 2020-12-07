<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce;

use JetBrains\PhpStorm\Pure;
use Sergosv\CryptogrammBrutforce\NumberSet\NumberSetInterface;
use Sergosv\CryptogrammBrutforce\Rule\Cryptorule;
use Sergosv\CryptogrammBrutforce\Rule\RuleSet;

class Brutforcer
{
    public function __construct(
        private NumberSetInterface $numberSetIterator,
        private RuleSet $ruleSet,
    ) {
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
        foreach ($this->ruleSet->getAll() as $cryptorule) {
            if (!$cryptorule->checkRule($numbers)) {
                return false;
            }
        }

        return true;
    }
}