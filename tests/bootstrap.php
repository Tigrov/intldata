<?php

// ensure we get report on all possible php errors
error_reporting(-1);

date_default_timezone_set('GMT');
setlocale(LC_ALL, 'en-US');
\Locale::setDefault('en_US');

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/compatibility.php');