<?php

/**
 * Context class to keep iterating over the signal light states.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace App\Contexts;

use App\States\Lights\Contracts\LightStateInterface;
use App\States\Lights\GreenState;

class TrafficSignalContext
{
    /** @var LightStateInterface $currentState */
    private $currentState;

    /**
     * Initializes class member variables/objects.
     */
    public function __construct()
    {
        $this->setState(new GreenState($this));
    }

    /**
     * Sets the current state of the context.
     *
     * @param LightStateInterface $lightState
     *
     * @return void
     */
    public function setState(LightStateInterface $lightState): void
    {
        $this->currentState = $lightState;
    }

    /**
     * Changes the current state of the context.
     *
     * @return void
     */
    public function changeState(): void
    {
        $this->currentState->next();
    }

    /**
     * Gets the current state of the context.
     *
     * @return LightStateInterface
     */
    public function getState(): LightStateInterface
    {
        return $this->currentState;
    }

    /**
     * To start the signals.
     *
     * @return void
     */
    public function start(): void
    {
        $duration = 1;
        while($this->currentState->validate($duration)) {
            $this->output();
            $this->halt();
            $duration++;
        }
    }

    /**
     * To display the output of current state of particular context.
     *
     * @return void
     */
    private function output(): void
    {
        echo $this->currentState->display() . PHP_EOL;
    }

    /**
     * To halt the execution for a second.
     *
     * @return void
     */
    private function halt(): void
    {
        sleep(1);
    }
}
