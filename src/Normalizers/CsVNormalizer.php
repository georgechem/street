<?php

namespace Street\App\Normalizers;

use Street\App\Helper;
use Street\App\Regex\Regex;

/**
 *
 */
class CsVNormalizer extends BaseNormalizer
{


    /**
     * @return void
     */
    function normalize(): void
    {
        $this->split();
    }

    /**
     * @return void
     */
    // split multiple entries in one csv row into separate one
    // other treat unchanged, store also invalid client entries to allow further processing if necessary
    protected function split(): void
    {
        $array = [];
        $this->invalid_entries = [];
        foreach ($this->data as $row) {
            $result = Helper::splitBy(Regex::MULTIPLE_ENTRY_SEPARATORS, $row);
            if ($this->isValid($result)) $array[] = $result;
            else $this->invalid_entries[] = $result;
        }
        $this->data = $this->process($array);
    }

    /**
     * @param array $result
     * @return bool
     */
    // allow max two user entered by client in one row
    protected function isValid(array $result): bool
    {
        if (
            count($result) < 2 &&
            count($result) > 0
        ) {
            $tmp = Helper::splitBy(Regex::ONE_SPACE_OR_MORE, $result[0]);
            if ($tmp && count($tmp) > 1) return true;

        } else return true;

        return false;
    }

    /**
     * @param array $array
     * @return array
     */
    protected function process(array $array): array
    {
        $singular = [];
        $multi = [];
        foreach ($array as $group) {
            if (count($group) > 1) {
                $first = Helper::splitBy(Regex::ONE_SPACE_OR_MORE, $group[0]);
                $second = Helper::splitBy(Regex::ONE_SPACE_OR_MORE, $group[1]);
                if (count($first) < 2) $first = $first[0] . ' ' . $second[count($second) - 1];
                if (is_array($first)) $multi[] = Helper::flatten($first);
                else $multi[] = $first;
                $multi[] = Helper::flatten($second);
            } elseif (count($group) > 0) $singular[] = trim($group[0]);
        }
        return array_merge($singular, $multi);

    }


}
