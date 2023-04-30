<?php

namespace Street\App\File;

use Iterator;
use Street\App\Normalizers\BaseNormalizer;

/**
 *
 */
final class CsvFileIterator implements Iterator
{
    /**
     * @var false|resource
     */
    private $file;
    /**
     * @var int
     */
    private int $key = 0;
    /**
     * @var array|false
     */
    private array|false$current;

    /**
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = fopen($file, 'r');
    }

    /**
     *
     */
    public function __destruct()
    {
        fclose($this->file);
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        rewind($this->file);

        $this->current = fgetcsv($this->file);

        if (is_array($this->current)) {
            $row = $this->current;
        }

        $this->key     = 0;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return !feof($this->file);
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->key;
    }

    /**
     * @return array
     */
    public function current(): array
    {
        return $this->current;
    }

    /**
     * @return void
     */
    public function next(): void
    {
        $this->current = fgetcsv($this->file);

        if (is_array($this->current)) {
            $row = $this->current;
        }

        $this->key++;
    }

    /**
     * @param BaseNormalizer $normalizer
     * @return void
     */
    public function addDataNormalizer(BaseNormalizer $normalizer): void
    {
        foreach ($this as $row){
            if(is_array($row)){
                if(count($row) > 0){
                    $normalizer->addData($row[0]);
                }
            }
        }
    }

}

