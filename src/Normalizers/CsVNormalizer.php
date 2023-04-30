<?php

namespace Street\App\Normalizers;

/**
 *
 */
class CsVNormalizer extends BaseNormalizer
{

    /**
     * @var string
     */
    protected string $separator = "/&|and/";

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
    protected function split(): void
    {
        $array = [];
        $this->invalid_entries = [];
        foreach ($this->data as $row) {
            $result = preg_split($this->separator, $row);
            if ($this->isValid($result)) $array[] = $result;
            else $this->invalid_entries[] = $result;
        }
        $this->data = $this->process($array);
    }

    /**
     * @param array $result
     * @return bool
     */
    protected function isValid(array $result): bool
    {
        if (
            count($result) < 2 &&
            count($result) > 0
        ) {
            $tmp = $this->splitBySpace($result[0]);
            if ($tmp && count($tmp) > 1) return true;

        } else return true;

        return false;
    }

    /**
     * @param string $result
     * @return array|bool
     */
    public static function splitBySpace(string $result): array|bool
    {
        return preg_split('/\s+/', $result);
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
            if(count($group) > 1){
                $first = self::splitBySpace(trim($group[0]));
                $second = self::splitBySpace(trim($group[1]));
                if(count($first) < 2) $first = $first[0].' '.$second[count($second) - 1];
                if(is_array($first)) $multi[] = $this->flatten($first);
                else $multi[] = $first;
                $multi[] = $this->flatten($second);
            }elseif(count($group) > 0){
                $singular[] = trim($group[0]);
            }
        }
        return array_merge($singular, $multi);

    }

    /**
     * @param array $array
     * @return string
     */
    protected function flatten(array $array):string
    {
        $result = "";
        foreach ($array as $value){
            if(is_array($value)){
                $result .= $this->flatten($value);
            }else{
                $result .= $value . " ";
            }
        }
        return $result;
    }

}
