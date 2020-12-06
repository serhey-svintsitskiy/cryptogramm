<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce\Rule;

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

    private array $operand1;

    private array $operand2;

    private array $result;

    #[Pure]
    public function __construct(
        private string $ident,
        private string $operator,
        string $operand1,
        string $operand2,
        string $result
    ) {
        
        $this->operand1 = str_split(strrev($operand1));
        $this->operand2 = str_split(strrev($operand2));
        $this->result = str_split(strrev($result));
    }

    #[Pure]
    public function checkRule(array $numbers): bool
    {
        $firstNumber = $this->buildNumber($this->operand1, $numbers);
        $secondNumber = $this->buildNumber($this->operand2, $numbers);
        $resultNumber = $this->buildNumber($this->result, $numbers);

        if (is_null($firstNumber) || is_null($secondNumber) || is_null($resultNumber)) {
            return false;
        }

        return $resultNumber === $this->calcOperation($firstNumber, $secondNumber, $this->operator);
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
    
    #[Pure]
    public function getIdent(): string
    {
        return $this->ident;
    }
}