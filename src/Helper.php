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


}
