<?php

/**
 * State class to handle the Traffic Signal's NormalTraffic state.
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
use App\States\Slots\Contracts\SlotStateInterface;

class NormalTrafficState extends AbstractSlotState implements SlotStateInterface
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
        string $start = '6:00:00',
        string $finish = '23:00:00'
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

        $isValid = $hour >= strtotime($this->start) && $hour < strtotime($this->finish);

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
        $this->trafficSignalContext->setState(StateFactory::getState('GREEN', $this->trafficSignalContext));
    }

    /**
     * To set the next state of the current state.
     *
     * @return void
     */
    public function next(): void
    {
        $this->trafficSignalSlotContext->setState(StateFactory::getState(
            'NORMAL_TRAFFIC', $this->trafficSignalContext, $this->trafficSignalSlotContext, 'NEXT'));

        // Sets the required defaults before the starting the execution.
        $this->trafficSignalSlotContext->getState()->setDefaultStateForTrafficSignalContext();
    }
}
