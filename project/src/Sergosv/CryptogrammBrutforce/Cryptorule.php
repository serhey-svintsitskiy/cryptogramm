<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce;

use JetBrains\PhpStorm\Pure;

class Cryptorule
{
    private array $symbolsMap = [
        'a' => 0,
        'b' => 1,
        'c' => 2,
        'd' => 3,
        'e' => 4,
        'f' => 5,
        'g' => 6,
        'h' => 7,
        'i' => 8,
        'j' => 9,
    ];

    public function __construct(
        private array $firstNumber,
        private array $secondNumber,
        private array $resultNumber,
        private string $operation
    ) {
    }

    #[Pure]
    public function checkRule(array $numbers): bool
    {
        $firstNumber = $this->buildNumber($this->firstNumber, $numbers);
        $secondNumber = $this->buildNumber($this->secondNumber, $numbers);
        $resultNumber = $this->buildNumber($this->resultNumber, $numbers);

        if (is_null($firstNumber) || is_null($secondNumber) || is_null($resultNumber)) {
            return false;
        }

        return $resultNumber === $this->calcOperation($firstNumber, $secondNumber, $this->operation);
    }

    #[Pure] 
    private function buildNumber(array $numberMap, array $numbers): ?int
    {
        $number = 0;
        $numberSize = count($numberMap);
        foreach ($numberMap as $index => $symbol) {
            $digit = $numbers[$this->symbolsMap[$symbol]];
            if (($digit === 0) && ($index === $numberSize - 1)) {
                return null;
            }
            $number += $digit * (10 ** $index);
        }

        return $number;
    }

    #[Pure]
    private function calcOperation(int $firstNumber, int $secondNumber, string $operation): ?int
    {
        $result = -1;

        switch ($operation) {
            case '+':
                $result = $firstNumber + $secondNumber;
                break;
            case '-':
                $result = $firstNumber - $secondNumber;
                break;
            case '*':
                $result = $firstNumber * $secondNumber;
                break;
            case '/':
                if ($secondNumber === 0) {
                    return null;
                }
                $result = $firstNumber / $secondNumber;
                break;
        }

        if ($result < 0 || !is_int($result)) {
            return null;
        }

        return $result;
    }
}