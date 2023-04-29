<?php

use Street\App\File\CsvFileIterator;
use Street\App\Normalizers\CsVNormalizer;

require __DIR__ .  '/../vendor/autoload.php';


$csv_file_iterator = new CsvFileIterator(__DIR__ .'/take-home-task-data.csv');
$csv_normalizer = new CsVNormalizer();
$csv_file_iterator->addDataNormalizer($csv_normalizer);

$csv_normalizer->normalize();

print_r($csv_normalizer->getData());
