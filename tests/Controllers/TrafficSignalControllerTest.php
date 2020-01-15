<?php

/**
 * Test class for verifying methods within TrafficSignalController.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace Tests\Controllers;

use App\Contexts\TrafficSignalSlotContext;
use App\Controllers\TrafficSignalController;
use Mockery;
use PHPUnit\Framework\TestCase;

class TrafficSignalControllerTest extends TestCase
{
    /**
     * Test to verify if start() can execute traffic signal application.
     *
     * @return void
     */
    public function testCanStartExecuteTrafficSignalApplication(): void
    {
        $trafficSignalSlotContextMock = Mockery::mock(TrafficSignalSlotContext::class);
        $trafficSignalSlotContextMock->shouldReceive('start')->once()->withNoArgs();
        $trafficSignalController = new TrafficSignalController($trafficSignalSlotContextMock);
        $trafficSignalController->start();
    }
}
