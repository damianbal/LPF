<?php

/**
 * @author Damian Balandowski <balandowskie@gmail.com>
 */

use LPF\Framework\App;

require __DIR__ . '/../vendor/autoload.php';

// start session
session_start();

// CORS
header("Access-Control-Allow-Origin: *");

// app
$app = new App;

// create app
$app->create();
