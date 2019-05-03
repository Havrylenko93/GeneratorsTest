<?php

$start = microtime(true);
$memoryStart = memory_get_usage();


$fileDescriptor1 = fopen('/var/www/html/GeneratorTest/test.csv', 'r');
$fileDescriptor2 = fopen('/var/www/html/GeneratorTest/rewritten.csv', 'w+');

function readCsv($fileDescriptor)
{
    while (($row = fgetcsv($fileDescriptor, 0, "\t")) !== false) {
        yield $row;
    }
}

$generator = readCsv($fileDescriptor1);

foreach ($generator as $item) {
    fputcsv($fileDescriptor2, $item, "|", "X");
}

$usedMemory = memory_get_usage() - $memoryStart;
var_dump('with generators: ', ['time' => microtime(true) - $start, 'used_memory' => $usedMemory / 1024 / 1024]);
