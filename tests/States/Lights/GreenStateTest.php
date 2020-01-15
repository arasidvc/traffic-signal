<?php

/**
 * Test class for verifying methods within GreenState.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace Tests\States\Lights;

use App\States\Lights\GreenState;

class GreenStateTest extends AbstractLightStateTest
{
    /**
     * Initializes basic setup required for the tests to execute.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->state = new GreenState($this->trafficSignalContextMock);
        $this->duration = 30;
        $this->displayText = 'GREEN';
    }
}
