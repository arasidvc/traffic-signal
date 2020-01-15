<?php

/**
 * Abstract class to hold the common functions/operations for the Traffic Light States.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace App\States\Lights;

use App\Contexts\TrafficSignalContext;
use App\States\Lights\Contracts\LightStateInterface;
use App\States\Factories\StateFactory;

abstract class AbstractLightState implements LightStateInterface
{
    /** @var TrafficSignalContext $trafficSignalContext */
    protected $trafficSignalContext;

    /**
     * Initializes class member variables/objects.
     *
     * @param TrafficSignalContext $trafficSignalContext
     */
    public function __construct(TrafficSignalContext $trafficSignalContext)
    {
        $this->trafficSignalContext = $trafficSignalContext;
    }

    /**
     * Returns the duration for the state to stay.
     *
     * @return int
     */
    public function duration(): int
    {
        return static::DURATION;
    }

    /**
     * Validates for particular state for is still valid or not.
     *
     * @param int $duration
     * @return bool
     */
    public function validate(int $duration): bool
    {
        $isValid = $duration <= $this->duration();
        if (!$isValid) {
            $this->next();
        };

        return $isValid;
    }
}
