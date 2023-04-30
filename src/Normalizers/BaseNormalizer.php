<?php

namespace Street\App\Normalizers;

/**
 *
 */
abstract class BaseNormalizer
{
    /**
     * @var array
     */
    protected array $data = [];
    /**
     * @var array
     */
    protected array $invalid_entries = [];

    /**
     * @return mixed
     */
    abstract function normalize();

    /**
     * @param string $data
     * @return void
     */
    public function addData(string $data): void
    {
        $this->data[] = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getInvalidData():array
    {
        return $this->invalid_entries;
    }

}
