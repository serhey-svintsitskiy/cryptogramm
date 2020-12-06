<?php

namespace Sergosv\CryptogrammBrutforce;

/**
 * Class Cryptorule
 * @package sergo_sv\cryptogramm
 */
class Cryptorule
{
    /**
     * @var array
     */
    public static $symbolsMap = ['a' => 0, 'b' => 1, 'c' => 2, 'd' => 3, 'e' => 4, 'f' => 5, 'g' => 6, 'h' => 7, 'i' => 8, 'j' => 9];
    private $firstNumber = [];
    private $secondNumber = [];
    private $resultNumber = [];
    /**
     * @var array
     */
    private $matches = [];

    /**
     * @var string
     */
    private static $regex = '/([abcdefghij]+)([+\-*\/])([abcdefghij]+)=([abcdefghij]+)/i';

    /**
     * Cryptorule constructor.
     * @param array $matches
     */
    public function __construct($matches)
    {
        $this->init($matches);

    }

    /**
     * Cryptorule constructor.
     * @param array $matches
     */
    public function init($matches)
    {
        $this->matches = $matches;
        $this->firstNumber = str_split(strrev($matches[1]));
        $this->secondNumber = str_split(strrev($matches[3]));
        $this->resultNumber = str_split(strrev($matches[4]));
    }

    /**
     * @param string $rawRule
     * @return Cryptorule
     */
    public static function parseRule($rawRule)
    {
        preg_match_all(self::$regex, str_replace(' ', '', trim($rawRule)), $matches, PREG_SET_ORDER, 0);
        return new self($matches[0]);
    }

    /**
     * @param array $numbers
     * @return bool
     */
    public function checkRule($numbers)
    {
        $firstNumber = $this->buildNumber($this->firstNumber, $numbers);
        $secondNumber = $this->buildNumber($this->secondNumber, $numbers);
        $resultNumber = $this->buildNumber($this->resultNumber, $numbers);
        if ($firstNumber === false || $secondNumber === false || $resultNumber === false) {
            return false;
        }
        $calculatedResult = $this->calcOperation($firstNumber, $secondNumber);
        if ($calculatedResult === false || $calculatedResult !== $resultNumber) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * @param array $numberMap
     * @param array $numbers
     * @return int|bool
     */
    private function buildNumber($numberMap, $numbers)
    {
        $number = 0;
        $numberSize = count($numberMap);
        foreach ($numberMap as $index => $symbol) {
            $digit = $numbers[self::$symbolsMap[$symbol]];
            if (($digit == 0) && ($index === $numberSize - 1)) {
                return false;
            }
            $number += $digit * pow(10, $index);
        };
        return $number;
    }

    /**
     * @param int $firstNumber
     * @param int $secondNumber
     * @return bool|float|int
     */
    private function calcOperation($firstNumber, $secondNumber)
    {
        $result = -1;
        switch ($this->matches[2]) {
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
                if ($secondNumber == 0) {
                    return false;
                }
                $result = $firstNumber / $secondNumber;
                break;
        }
        if ($result < 0) {
            return false;
        }
        return $result;
    }
}