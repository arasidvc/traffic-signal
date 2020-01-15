<?php

/**
 * State class to handle the Traffic Signal's Green state.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace App\States\Lights;

use App\States\Factories\StateFactory;

class GreenState extends AbstractLightState
{
    /**
     * Duration (in seconds) for the state to remain/stay.
     */
    protected const DURATION = 30;

    /**
     * Returns the string to be displayed as an action for being on the state.
     *
     * @return string
     */
    public function display(): string
    {
        return 'GREEN';
    }

    /**
     * To set the next state of the current state.
     *
     * @return void
     */
    public function next(): void
    {
        $this->trafficSignalContext->setState(StateFactory::getState('GREEN', $this->trafficSignalContext, null, 'NEXT'));
    }

    public function backgroundColor()
    {
        return 42;
    }
}
