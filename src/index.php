<?php

use Street\App\File\CsvFileIterator;

require __DIR__ .  '/../vendor/autoload.php';


$csv_file_iterator = new CsvFileIterator(__DIR__ .'/take-home-task-data.csv');

foreach ($csv_file_iterator as $row){
    if(is_array($row)){
        if(count($row) > 0){
            echo $row[0];
            echo PHP_EOL;
        }
    }
}
