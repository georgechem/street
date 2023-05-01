<?php

namespace Street\App;

class Helper
{
    /**
     * @param string $input
     * @return bool
     */
    public static function isRegexMatch(string $pattern,string $input, bool $trim = true): bool
    {
        if(preg_match($pattern, $trim ? trim($input) : $input)) return true;
        return false;
    }

    /**
     * @param string $result
     * @return array|bool
     */
    public static function splitBy(string $pattern, string $input, bool $trim = true): array|bool
    {
        return preg_split($pattern, $trim ? trim($input) : $input);
    }

}
