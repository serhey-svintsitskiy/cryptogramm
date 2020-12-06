<?php

declare(strict_types=1);

namespace Sergosv\CryptogrammBrutforce;

use RuntimeException;

class Brutforcer
{
    private array $rules = [];

    private array $numbers = [];

    private array $result = [];

    public function __construct()
    {
        /** @todo load list */
        //$this->fillList(10);
    }

    public static function quickStart(array $rulesConfigs, string $filePath): void
    {
        $crypto = new self();
        $crypto->loadRules($rulesConfigs);
        $crypto->calculate($filePath);
        /** @todo return result */
    }

    public function loadRules(array $rulesConfigs): void
    {
        /** @todo check for uniq rules */
        foreach ($rulesConfigs as $rawRule) {
            $this->rules[] = Cryptorule::parseRule($rawRule);
        }
    }

    public function calculate(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new RuntimeException('Could not find file "' . $filePath . '".');
        }
        $fp = fopen($filePath, 'rb');
        if (!$fp) {
            throw new RuntimeException('Could not open file "perm.txt" for reading.');
        }
        while (($line = fgets($fp)) !== false) {
            $this->numbers = str_split(trim($line));
            if ($this->checkRules()) {
                $this->result[] = $this->numbers;
            }
        }

        return $this->result;
    }

    /**
     * @return bool
     */
    private function checkRules(): bool
    {
        foreach ($this->rules as $cryptorule) {
            if (!$cryptorule->checkRule($this->numbers)) {
                return false;
            }
        }

        return true;
    }

    public static function generateList(int $n): void
    {
        $filePath = __DIR__ . '/../../public_html/perm.txt';
        if (!file_exists($filePath)) {
            throw new RuntimeException('Could not find file "' . $filePath . '".');
        }
        $fp = fopen($filePath, 'wb');
        if (!$fp) {
            throw new RuntimeException('Could not open file "perm.txt" for writing.');
        }
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
                if (!fwrite($fp, implode('', $a) . "\n")) {
                    throw new RuntimeException('Could not write text "' . implode('', $a) . '" to file "perm.txt".');
                }
                $i--;
            }
            $a[$i--] = -1;
        }
        fclose($fp);
    }
}