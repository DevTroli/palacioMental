<?php

// Vercel serverless entry point for Laravel
// Adapted for Laravel 13 (slim bootstrap)

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Bootstrap the Laravel application
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Handle the request
$request = Request::capture();
$response = $app->handleRequest($request);

// Send the response
$response->send();
