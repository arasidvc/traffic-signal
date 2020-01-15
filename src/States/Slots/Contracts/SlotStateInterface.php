<?php

/**
 * Interface for having contract/rules for Traffic Signal Slots.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace App\States\Slots\Contracts;

interface SlotStateInterface
{
    /**
     * Checks against if the current state is valid for execution or not.
     *
     * @return bool
     */
    public function validate(): bool;

    /**
     * Sets the default state for the traffic signal context within the current slot scope.
     *
     * @return void
     */
    public function setDefaultStateForTrafficSignalContext(): void;
}
