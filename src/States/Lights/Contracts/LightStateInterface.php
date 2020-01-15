<?php

/**
 * Interface for having contract/rules for Traffic Signal Lights.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace App\States\Lights\Contracts;

interface LightStateInterface
{
    /**
     * Returns the duration for the state to stay.
     *
     * @return int
     */
    public function duration(): int;

    /**
     * Changes the current state of the context to a next state.
     *
     * @return void
     */
    public function next(): void;

    /**
     * Returns the string to be displayed as an action for being on the state.
     *
     * @return string
     */
    public function display(): string;

    /**
     * Validates for state is still valid or not.
     *
     * @param int $duration
     *
     * @return bool
     */
    public function validate(int $duration): bool;
}
