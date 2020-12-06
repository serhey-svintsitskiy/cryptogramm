<?php

namespace Sergosv\CryptogrammBrutforce;

/**
 * Class Cryptogramm
 * @package sergo_sv\cryptogramm
 */
class Cryptogramm
{

    /**
     * @var array
     */
    private $rules = [];

    /**
     * Cryptogramm constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     *
     */
    private function init()
    {
        //$this->get_perestanovka(10);
    }

    /**
     * @param array $rulesConfigs
     * @param string $filePath
     */
    public static function quickStart($rulesConfigs, $filePath)
    {
        $crypto = new self();
        $crypto->loadRules($rulesConfigs);
        $crypto->calculate($filePath);
        die;
    }

    /**
     * @param array $rulesConfigs
     */
    public function loadRules($rulesConfigs)
    {
        foreach ($rulesConfigs as $rawRule){
            $this->rules[] = Cryptorule::parseRule($rawRule);
        }
    }

    /**
     * @var array
     */
    private $numbers = [];

    /**
     * @var array
     */
    private $result = [];

    /**
     * @param string $filePath
     * @throws \Exception
     */
    public function calculate($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception('Could not find file "' . $filePath . '".');
        }
        $fp = fopen($filePath, 'r');
        if (!$fp) {
            throw new \Exception('Could not open file "perm.txt" for reading.');
        }
        $test = 0;
        while (($line = fgets($fp)) !== false) {
            $test++;
            $this->numbers = str_split(trim($line));
            if($this->checkRules()){
                $this->result[] = $this->numbers;
            }
        }
        print_r($this->result);
        die;
    }

    /**
     * @return bool
     */
    private function checkRules()
    {
        /**
         * @var Cryptorule $cryptorule
         */
        foreach ($this->rules as $cryptorule){
            if(!$cryptorule->checkRule($this->numbers)){
                return false;
            }
        }
        return true;
    }

    /**
     * @param int $n
     * @return bool
     * @throws \Exception
     */
    public static function get_perestanovka($n)
    {
        $filePath = __DIR__ . '/../../public_html/perm.txt';
        if (!file_exists($filePath)) {
            throw new \Exception('Could not find file "' . $filePath . '".');
        }
        $fp = fopen($filePath, 'w');
        if (!$fp) {
            throw new \Exception('Could not open file "perm.txt" for writing.');
        }
        $a = array_fill(0, $n, -1);
        $i = 0;
        while ($i >= 0) {
            while ($i < $n) {
                $j = $a[$i];
                while (in_array(++$j, $a) && $j < $n) ;
                if ($j == $n) break;
                $a[$i++] = $j;
            }
            if ($i == $n) {
                //array_push($result, implode('',$a));
                if (!fwrite($fp, implode('', $a) . "\n")) {
                    print_r($fp);
                    throw new \Exception('Could not write text "' . implode('', $a) . '" to file "perm.txt".');
                }
                $i--;
            }
            $a[$i--] = -1;
        }
        fclose($fp);
        return true;
    }
}