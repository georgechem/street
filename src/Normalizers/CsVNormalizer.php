<?php

namespace Street\App\Normalizers;

use Street\App\Const\Group;
use Street\App\Helper;
use Street\App\Regex\Regex;
use Street\App\Strategy\CsvNormalizerStrategy\OnePersonRowNormalizer;
use Street\App\Strategy\CsvNormalizerStrategy\RowNormalizer;
use Street\App\Strategy\CsvNormalizerStrategy\TwoPeopleRowNormalizer;

/**
 *
 */
class CsVNormalizer extends BaseNormalizer
{

    const ONE_PERSON_IN_THE_ROW = 1;
    const TWO_PEOPLE_IN_THE_ROW = 2;
    protected array $singular = [];
    protected array $multi = [];

    protected array $normalizers = [];

    public function __construct()
    {
        $this->normalizers = [
            1 => new OnePersonRowNormalizer(),
            2 => new TwoPeopleRowNormalizer()
        ];
    }

    protected ?RowNormalizer $rowNormalizer = null;
    /**
     * @return void
     */
    function normalize(): void
    {
        $array = $this->split();
        $this->data = $this->process($array);
    }

    protected function setRowNormalizer(RowNormalizer $rowNormalizer):void
    {
        $this->rowNormalizer = $rowNormalizer;
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
            // set proper normalizer for a row basing on result array
            if(count($result) <= count($this->normalizers) && count($result) > 0) {

                $this->setRowNormalizer($this->normalizers[count($result)]);
                $this->rowNormalizer->setData($result);
                $normalizedRow = $this->rowNormalizer->normalize();
                if($normalizedRow) $array[] = $normalizedRow;

            }
            else $this->invalid_entries[] = $result;

        }
        return $array;
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
