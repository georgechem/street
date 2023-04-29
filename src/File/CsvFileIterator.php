<?php

namespace Street\App\File;

use Iterator;
use Street\App\Normalizers\BaseNormalizer;

final class CsvFileIterator implements Iterator
{
    private $file;
    private int $key = 0;
    private array|false$current;

    public function __construct(string $file)
    {
        $this->file = fopen($file, 'r');
    }

    public function __destruct()
    {
        fclose($this->file);
    }

    public function rewind(): void
    {
        rewind($this->file);

        $this->current = fgetcsv($this->file);

        if (is_array($this->current)) {
            $row = $this->current;
        }

        $this->key     = 0;
    }

    public function valid(): bool
    {
        return !feof($this->file);
    }

    public function key(): int
    {
        return $this->key;
    }

    public function current(): array
    {
        return $this->current;
    }

    public function next(): void
    {
        $this->current = fgetcsv($this->file);

        if (is_array($this->current)) {
            $row = $this->current;
        }

        $this->key++;
    }

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

