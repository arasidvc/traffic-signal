<?php

/**
 * Test class for verifying methods within TrafficSignalSlotContext.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace Tests\Contexts;

use App\States\Slots\NormalTrafficState;
use Mockery;
use PHPUnit\Framework\TestCase;
use App\Contexts\TrafficSignalSlotContext;
use App\States\Slots\LowTrafficState;

class TrafficSignalSlotContextTest extends TestCase
{
    /** @var TrafficSignalSlotContext $trafficSignalSlotContext */
    private $trafficSignalSlotContext;

    /**
     * Initializes basic setup required for the tests to execute.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->trafficSignalSlotContext = new TrafficSignalSlotContext(false);
    }

    /**
     * Test to verify setState() can set the current state.
     *
     * @return void
     */
    public function testCanSetCurrentSateForContext(): void
    {
        $this->trafficSignalSlotContext->setState(Mockery::mock(LowTrafficState::class));

        $this->assertInstanceOf(LowTrafficState::class, $this->trafficSignalSlotContext->getState());
    }

    /**
     * Test to verify getState() can return the current set state.
     *
     * @return void
     */
    public function testCanReturnCurrentStateOfTheContext(): void
    {
        $this->assertInstanceOf(NormalTrafficState::class, $this->trafficSignalSlotContext->getState());
    }

    /**
     * Test to verify start() can trigger/start the actions for traffic signal states.
     *
     * @return void
     */
    public function testStartCanExecuteTrafficSignalLightStateActions(): void
    {
        $lowTrafficStateMock = Mockery::mock(LowTrafficState::class)
            ->shouldReceive('start')
            ->withNoArgs()
            ->getMock();

        $this->trafficSignalSlotContext->setState($lowTrafficStateMock);
        $this->trafficSignalSlotContext->start();
    }
}
