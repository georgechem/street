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

    const ONE_PERSON_IN_THE_ROW = 1;
    const TWO_PEOPLE_IN_THE_ROW = 2;

    protected array $singular = [];
    protected array $multi = [];
    /**
     * @return void
     */
    function normalize(): void
    {
        $array = $this->split();
        $this->data = $this->process($array);
    }

    /**
     * @return void
     */
    // split multiple entries in one csv row into separate one
    // other treat unchanged, store also invalid client entries to allow further processing if necessary
    protected function split(): array
    {
        $array = [];
        foreach ($this->data as $row) {
            $result = Helper::splitBy(Regex::MULTIPLE_ENTRY_SEPARATORS, $row);
            if ($this->isValid($result)) $array[] = $result;
            else $this->invalid_entries[] = $result;
        }
        return $array;
    }

    /**
     * @param array $result
     * @return bool
     */
    // allow max two user entered by client in one row
    protected function isValid(array $result): bool
    {
        // is valid single entry row
        if (count($result) === self::ONE_PERSON_IN_THE_ROW) {
            $tmp = Helper::splitBy(Regex::ONE_SPACE_OR_MORE, $result[0]);
            // in single row record must be at least initial & surname so length must be greater than one
            if ($tmp && Helper::isArrayLengthGreaterThan($tmp, 1)) return true;
            // multi(2) entry row
        } else if(count($result) === self::TWO_PEOPLE_IN_THE_ROW) return true;
        // can allow more people in one line in the future / may use strategy pattern which set current number of users in the row
        return false;
    }

    /**
     * @param array $array
     * @return array
     */
    protected function process(array $array): array
    {
        foreach ($array as $group) {
           $this->processGroup($group);
        }
        return array_merge($this->singular, $this->multi);

    }

    protected function processGroup(array $group):void
    {
        if (Helper::isArrayLengthGreaterThan($group, 1)) {

            $first = Helper::splitBy(Regex::ONE_SPACE_OR_MORE, $group[Group::FIRST_USER_IN_THE_GROUP]);
            $second = Helper::splitBy(Regex::ONE_SPACE_OR_MORE, $group[Group::SECOND_USER_IN_THE_GROUP]);

            // first item in the group has only initial so add proper surname to it
            if (
                is_array($first) && is_array($second) &&
                Helper::isArrayLengthLowerThan($first, 2)
            ) $first = Helper::joinStrings($first[0], $second[Helper::getLastIndexInArray($second)]);

            if (is_array($first) && !Helper::isArrayEmpty($first)) $this->multi[] = Helper::flatten($first);
            else $this->multi[] = $first;
            if(is_array($second) && !Helper::isArrayEmpty($second))$this->multi[] = Helper::flatten($second);

        } elseif (Helper::isArrayLengthGreaterThan($group, 0)) $this->singular[] = trim($group[0]);
    }


}
