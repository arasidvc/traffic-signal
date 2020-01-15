<?php

/**
 * State class to handle the Traffic Signal's LowTraffic state.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace App\States\Slots;

use App\Contexts\TrafficSignalContext;
use App\Contexts\TrafficSignalSlotContext;
use App\States\Factories\StateFactory;

class LowTrafficState extends AbstractSlotState
{
    /**
     * Start time for the state to remain/stay.
     *
     * @var string $start
     */
    private $start;

    /**
     * End time for the state to remain/stay.
     *
     * @var string $finish
     */
    private $finish;

    /**
     * Initializes class member variables/objects.
     *
     * @param TrafficSignalSlotContext $trafficSignalSlotContext
     * @param TrafficSignalContext $trafficSignalContext
     * @param string $start
     * @param string $finish
     */
    public function __construct(
        TrafficSignalSlotContext $trafficSignalSlotContext,
        TrafficSignalContext $trafficSignalContext,
        string $start = '23:00:00',
        string $finish = '6:00:00'
    ) {
        parent::__construct($trafficSignalSlotContext, $trafficSignalContext);
        $this->start = $start;
        $this->finish = $finish;
    }

    /**
     * Checks against if the current state is valid for execution or not.
     *
     * @return bool
     */
    public function validate(): bool
    {
        $hour = strtotime(date('H:i:s'));

        $isValid = $hour < strtotime($this->finish) || $hour >= strtotime($this->start);

        if (!$isValid) {
            $this->next();
        }

        return $isValid;
    }

    /**
     * Sets the default state for the traffic signal context within the current slot scope.
     *
     * @return void
     */
    public function setDefaultStateForTrafficSignalContext(): void
    {
        $this->trafficSignalContext->setState(StateFactory::getState('YELLOW', $this->trafficSignalContext));
    }

    /**
     * To set the next state of the current state.
     *
     * @return void
     */
    public function next(): void
    {
        $this->trafficSignalSlotContext->setState(StateFactory::getState(
            'LOW_TRAFFIC', $this->trafficSignalContext, $this->trafficSignalSlotContext, 'NEXT'));

        // Sets the required defaults before the starting the execution.
        $this->trafficSignalSlotContext->getState()->setDefaultStateForTrafficSignalContext();
    }
}
