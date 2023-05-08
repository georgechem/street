<?php

namespace Street\App\Normalizers;

use Street\App\Const\Group;
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
        if (Helper::isArrayLengthInRange($result, 0, 2)) {
            $tmp = Helper::splitBy(Regex::ONE_SPACE_OR_MORE, $result[0]);
            if ($tmp && Helper::isArrayLengthGreaterThan($tmp, 1)) return true;

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
           $this->processGroup($group, $singular, $multi);
        }
        return array_merge($singular, $multi);

    }

    protected function processGroup(array $group, array &$singular, array &$multi):void
    {
        if (Helper::isArrayLengthGreaterThan($group, 1)) {

            $first = Helper::splitBy(Regex::ONE_SPACE_OR_MORE, $group[Group::FIRST_USER_IN_THE_GROUP]);
            $second = Helper::splitBy(Regex::ONE_SPACE_OR_MORE, $group[Group::SECOND_USER_IN_THE_GROUP]);

            // first item in the group has only initial so add proper surname to it
            if (
                is_array($first) && is_array($second) &&
                Helper::isArrayLengthLowerThan($first, 2)
            ) $first = Helper::joinStrings($first[0], $second[Helper::getLastIndexInArray($second)]);

            if (is_array($first) && !Helper::isArrayEmpty($first)) $multi[] = Helper::flatten($first);
            else $multi[] = $first;
            if(is_array($second) && !Helper::isArrayEmpty($second))$multi[] = Helper::flatten($second);

        } elseif (Helper::isArrayLengthGreaterThan($group, 0)) $singular[] = trim($group[0]);
    }


}
