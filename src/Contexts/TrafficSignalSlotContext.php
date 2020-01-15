<?php

/**
 * Context class to keep iterating over the various timing slots.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace App\Contexts;

use App\States\Factories\StateFactory;
use App\States\Slots\Contracts\SlotStateInterface;

class TrafficSignalSlotContext
{
    /** @var SlotStateInterface $currentState */
    private $currentState;

    /** @var bool $isInfiniteContinual*/
    private $isInfiniteContinual;

    /** @var TrafficSignalContext $trafficSignalContext */
    private $trafficSignalContext;

    /**
     * Initializes class member variables/objects.
     *
     * @param bool $isInfiniteContinual
     */
    public function __construct(TrafficSignalContext $trafficSignalContext, bool $isInfiniteContinual = true)
    {
        $this->trafficSignalContext = $trafficSignalContext;

//        $this->setState($this->getSlotStateInstace('NORMAL_TRAFFIC', $this, $this->trafficSignalContext));
        $this->setState(StateFactory::getState('NORMAL_TRAFFIC', $this->trafficSignalContext, $this));

        $this->isInfiniteContinual = $isInfiniteContinual;
    }

    /**
     * Sets the current state of the context.
     *
     * @param SlotStateInterface $slotState
     *
     * @return void
     */
    public function setState(SlotStateInterface $slotState): void
    {
        $this->currentState = $slotState;
    }

    /**
     * Gets the current state of the context.
     *
     * @return SlotStateInterface
     */
    public function getState(): SlotStateInterface
    {
        return $this->currentState;
    }

    /**
     * Starts/triggers the execution of the states.
     *
     * @return void
     */
    public function start(): void
    {
        do {
            while($this->currentState->validate()) {
                $this->trafficSignalContext->start();
            }
        } while ($this->isInfiniteContinual);
    }
}
