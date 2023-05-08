<?php

namespace Street\App;

class Helper
{
    /**
     * @param string $pattern
     * @param string $input
     * @param bool $trim
     * @return bool
     */
    public static function isRegexMatch(string $pattern,string $input, bool $trim = true): bool
    {
        if(preg_match($pattern, $trim ? trim($input) : $input)) return true;
        return false;
    }

    /**
     * @param string $pattern
     * @param string $input
     * @param bool $trim
     * @return array|bool
     */
    public static function splitBy(string $pattern, string $input, bool $trim = true): array|bool
    {
        return preg_split($pattern, $trim ? trim($input) : $input);
    }

    /**
     * @param array $array
     * @return string
     */
    public static function flatten(array $array):string
    {
        $result = "";
        foreach ($array as $value){
            if(is_array($value)){
                $result .= self::flatten($value);
            }else{
                $result .= $value . " ";
            }
        }
        return $result;
    }

    public static function isArrayLengthInRange(array $array, int $min, int $max):bool
    {
        if(count($array) < $max && count($array) > $min) return true;
        else return false;

    }

    public static function isArrayLengthGreaterThan(array $array, int $length):bool
    {
        if(count($array) > $length) return true;
        else return false;
    }

    public static function isArrayLengthLowerThan(array $array, int $length):bool
    {
        if(count($array) < $length) return true;
        else return false;
    }

    public static function getLastIndexInArray(array $array):int
    {
        return count($array) - 1;

    }

    public static function isArrayEmpty(array $array):bool
    {
        return count($array) === 0;
    }

    public static function joinStrings(string $args):string
    {
        $arguments = func_get_args();
        return  implode(' ', $arguments);
    }



}
