<?php

use Effectra\Http\Foundation\RequestFoundation;
use Effectra\Tracker\Services\IpRegistry;
use Effectra\Tracker\Tracker;
use GuzzleHttp\Client;

require __DIR__. '/../vendor/autoload.php';

$apiKey = "";

$req = RequestFoundation::createFromGlobals();

$IP = '';

$tracker = new Tracker($req);


$ipTracker = new IpRegistry(new Client(),$IP,$apiKey);

echo '<pre>';
// echo json_encode($tracker->getAll());
echo '<br>';
echo json_encode($ipTracker->getAll());
echo '</pre>';


