<?php

class PbcExample2
{
    private $name = '';
    private $balance = 0;

   /**
    * Add name
    *
    * Contracts:
    * #Require( is_string($name) && 0 < strlen(trim($name)) )
    * #Ensure( null === $result )
    * #Invariant( is_string($this->name) )
    *
    * @param string $name name
    *
    * @return null
    */
    public function addName($name)
    {
        $this->name = $name;

        $result = null;

        return $result;
    }

   /**
    * Set balance
    *
    * Contracts:
    * #Require( is_numeric($balanceValue) && 0 < $balanceValue )
    * #Ensure( true === $result )
    * #Invariant( is_integer($this->balance) && 0 < $this->balance )
    *
    * @param integer $balanceValue balance value
    *
    * @return true
    */
    public function setBalance($balanceValue)
    {
        $this->balance = (integer) $balanceValue;

        $result = true;

        return $result;
    }

   /**
    * Release balance
    *
    * Contracts:
    * #Require( 0 < $this->balance )
    * #Ensure( is_integer($this->balance) && 0 < $this->balance )
    * #Invariant( is_integer($this->balance) && 0 < $this->balance )
    *
    * @return integer released balance value
    */
    public function releaseBalance()
    {
        $result = --$this->balance;

        return $result;
    }

   /**
    * Calculate balance pointer by name
    *
    * Contracts:
    * #Require( 0 < $this->balance && 0 < strlen(trim($this->name)) )
    * #Ensure( is_integer($this->balance) && 0 < $this->balance )
    * #Invariant( is_integer($this->balance) && 0 < $this->balance && is_string($this->name) && 0 < strlen(trim($this->name)) )
    *
    * @return integer released balance pointer value
    */
    public function calculateBalance()
    {
        $result = $this->balance * strlen($this->name);

        return $result;
    }
}

// TESTs
/*
$annotations
    = array_filter(token_get_all(file_get_contents(__FILE__)), function(&$token){
    return (($token[0] == T_COMMENT) && ($token = strstr($token[1], '#')));
});

print_r($annotations);
*/

$ref = new ReflectionClass('PbcExample2');
//$ref = unserialize(serialize($ref));
$m = $ref->getMethods();
$c = $m[0]->getDocComment();

preg_match_all('~^\s+([\*]\s*[#](Require|Ensure|Invariant)[\(](.*)[\)])$~m', $c, $r, 2);

//var_dump($m);

var_dump($c, $r);
//var_dump($ref->getDocComment());
