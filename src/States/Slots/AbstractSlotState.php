<?php

/**
 * Abstract class to hold the common functions/operations for the Traffic Slot states.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace App\States\Slots;

use App\Contexts\TrafficSignalContext;
use App\Contexts\TrafficSignalSlotContext;
use App\States\Slots\Contracts\SlotStateInterface;
use App\States\Factories\StateFactory;

abstract class AbstractSlotState implements SlotStateInterface
{
    /** @var TrafficSignalContext $trafficSignalContext */
    protected $trafficSignalContext;

    /** @var TrafficSignalSlotContext $trafficSignalSlotContext */
    protected $trafficSignalSlotContext;

    /**
     * Initializes class member variables/objects.
     *
     * @param TrafficSignalSlotContext $trafficSignalSlotContext
     * @param TrafficSignalContext $trafficSignalContext
     */
    public function __construct(TrafficSignalSlotContext $trafficSignalSlotContext, TrafficSignalContext $trafficSignalContext)
    {
        $this->trafficSignalSlotContext = $trafficSignalSlotContext;
        $this->trafficSignalContext = $trafficSignalContext;
    }
}
