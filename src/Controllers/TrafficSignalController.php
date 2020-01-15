<?php

/**
 * Controller class to accept the request and starts the traffic signal.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace App\Controllers;

use App\Contexts\TrafficSignalSlotContext;

class TrafficSignalController
{
    /** @var TrafficSignalSlotContext $trafficSignalSlotContext */
    private $trafficSignalSlotContext;

    /**
     * Initializes class member variables/objects.
     *
     * @param TrafficSignalSlotContext $trafficSignalSlotContext
     */
    public function __construct(TrafficSignalSlotContext $trafficSignalSlotContext)
    {
        $this->trafficSignalSlotContext = $trafficSignalSlotContext;
    }

    /**
     * Starts/triggers the execution of the states via context.
     *
     * @return void
     */
    public function start(): void
    {
        $this->trafficSignalSlotContext->start();
    }
}
