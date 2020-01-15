<?php

/**
 * Abstract class to hold the common tests for the Traffic Light States.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace Tests\States\Lights;

use App\States\Lights\Contracts\LightStateInterface;
use App\States\Lights\GreenState;
use App\States\Lights\GreenYellowState;
use App\States\Lights\OffState;
use App\States\Lights\RedState;
use App\States\Lights\YellowState;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use App\Contexts\TrafficSignalContext;

abstract class AbstractLightStateTest extends TestCase
{
    /** @var MockInterface $trafficSignalContextMock */
    protected $trafficSignalContextMock;

    /** @var int $duration */
    protected $duration;

    /** @var string $displayText */
    protected $displayText;

    /** @var LightStateInterface $state */
    protected $state;

    /**
     * Initializes basic setup required for the tests to execute.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->trafficSignalContextMock = Mockery::mock(TrafficSignalContext::class);
    }

    /**
     * Test to verify if duration() returns the already set duration.
     *
     * @return void
     */
    public function testDurationCanReturnTheDurationOfTheState(): void
    {
        $this->assertEquals($this->duration, $this->state->duration());
    }

    /**
     * Test to verify if display() returns the string to be displayed.
     *
     * @return void
     */
    public function testDisplay(): void
    {
        $this->assertEquals($this->displayText, $this->state->display());
    }

    /**
     * Test to verify:
     * setNextState() sets the next state
     * next() changes the state to the next state.
     *
     * @dataProvider stateDataProvider
     *
     * @param string $className
     *
     * @return void
     */
    public function testNextCanChangeTheCurrentStateToNextState(string $className): void
    {
        $stateMock = Mockery::mock($className);
        $this->trafficSignalContextMock->shouldReceive('setState')
            ->once()
            ->with(
                Mockery::on(function($state) use ($className) {
                    $this->assertInstanceOf($className, $state);

                    return true;
                })
            );
        $this->state->setNextState($stateMock);
        $this->state->next();
    }

    /**
     * Returns the dataset for the testNextCanChangeTheCurrentStateToNextState.
     *
     * @return array
     */
    public function stateDataProvider(): array
    {
        return [
            [GreenState::class],
            [GreenYellowState::class],
            [RedState::class],
            [OffState::class],
            [YellowState::class],
        ];
    }
}
