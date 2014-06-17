<?php
/**
 * File for MY ExcelTable API
 */

require __DIR__ . '/../vendor/yaman/myexceltable.php';

$table = new \yaman\myexceltable();

$table->refresh($_POST);

header('content-type', 'application/json');
echo $table->toJson();
