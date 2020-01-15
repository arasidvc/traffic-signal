<?php

/**
 * Test class for verifying methods within TrafficSignalContext.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace App\tests\Contexts;

use App\States\Lights\GreenYellowState;
use App\States\Lights\OffState;
use App\States\Lights\RedState;
use Mockery;
use PHPUnit\Framework\TestCase;
use App\Contexts\TrafficSignalContext;
use App\States\Lights\YellowState;
use App\States\Lights\GreenState;
use App\States\Lights\Contracts\LightStateInterface;

class TrafficSignalContextTest extends TestCase
{
    /** @var TrafficSignalContext $trafficSignalContext */
    private $trafficSignalContext;

    /**
     * Initializes basic setup required for the tests to execute.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->trafficSignalContext = new TrafficSignalContext();
    }

    /**
     *  Test to verify setState() can set the current state of the context.
     *
     * @return void
     */
    public function testCanSetTheCurrentStateOfContext(): void
    {
        $this->trafficSignalContext->setState(Mockery::mock(YellowState::class));

        $this->assertInstanceOf(YellowState::class, $this->trafficSignalContext->getState());
    }

    /**
     * Test to verify getState() can return the current state of the context.
     *
     * @return void
     */
    public function testGetStateCanReturnTheCurrentStateOfContext(): void
    {
        $this->assertInstanceOf(LightStateInterface::class, $this->trafficSignalContext->getState());
    }

    /**
     * Test to verify getYellowState() can return the yellow state instance.
     *
     * @return void
     */
    public function testCanReturnYellowState(): void
    {
        $this->assertInstanceOf(YellowState::class, $this->trafficSignalContext->getYellowState());
    }

    /**
     * Test to verify getGreenState() can return the green state instance.
     *
     * @return void
     */
    public function testCanReturnGreenState(): void
    {
        $this->assertInstanceOf(GreenState::class, $this->trafficSignalContext->getGreenState());
    }

    /**
     * Test to verify getStateDuration() can return the duration of the current state.
     *
     * @dataProvider lightStateDataProvider
     *
     * @param LightStateInterface $state
     * @param int $expectedDuration
     *
     * @return void
     */
    public function testGetStateDurationReturnsTheDurationOfTheState(LightStateInterface $state, int $expectedDuration): void
    {
        $this->trafficSignalContext->setState($state);
        $output = $this->trafficSignalContext->getStateDuration();

        $this->assertIsInt($output);
        $this->assertSame($expectedDuration, $output);
    }

    /**
     * Test to verify changeState() can change the current state to the next state.
     *
     * @return void
     */
    public function testCanChangeCurrentStateToNextState(): void
    {
        $greenYellowState = new GreenYellowState($this->trafficSignalContext);
        $greenYellowState->setNextState(new GreenState($this->trafficSignalContext));
        $this->trafficSignalContext->setState($greenYellowState);
        $this->trafficSignalContext->changeState();

        $this->assertInstanceOf(GreenState::class, $this->trafficSignalContext->getState());
    }

    /**
     * Returns the dataset for the test testGetStateDurationReturnsTheDurationOfTheState.
     *
     * @return array
     */
    public function lightStateDataProvider(): array
    {
        $trafficSignalContext = new TrafficSignalContext();

        return [
            [new YellowState($trafficSignalContext), 1],
            [new GreenState($trafficSignalContext), 30],
            [new RedState($trafficSignalContext), 40],
            [new GreenYellowState($trafficSignalContext), 5],
            [new OffState($trafficSignalContext), 2],
        ];
    }
}
