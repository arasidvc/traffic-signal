<?php

/**
 * Entry point for the application
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

require __DIR__ . '/vendor/autoload.php';

use App\Controllers\TrafficSignalController;
use App\Contexts\TrafficSignalSlotContext;
use App\Contexts\TrafficSignalContext;

$trafficSignalController = new TrafficSignalController(new TrafficSignalSlotContext(new TrafficSignalContext()));
$trafficSignalController->start();
