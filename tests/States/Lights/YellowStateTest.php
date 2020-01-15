<?php

/**
 * Test class for verifying methods within YellowState.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace Tests\States\Lights;

use App\States\Lights\YellowState;

class YellowStateTest extends AbstractLightStateTest
{
    /**
     * Initializes basic setup required for the tests to execute.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->state = new YellowState($this->trafficSignalContextMock);
        $this->duration = 1;
        $this->displayText = 'YELLOW';
    }
}
