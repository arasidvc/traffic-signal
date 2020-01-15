<?php

/**
 * Test class for verifying methods within NormalTrafficState.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace Tests\States\Slots;

use App\Contexts\TrafficSignalContext;
use App\Contexts\TrafficSignalSlotContext;
use App\States\Lights\GreenState;
use App\States\Slots\LowTrafficState;
use App\States\Slots\NormalTrafficState;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Mockery;

class NormalTrafficStateTest extends TestCase
{
    /** @var NormalTrafficState $normalTrafficState */
    private $normalTrafficState;

    /** @var MockInterface $trafficSignalSlotContextMock */
    private $trafficSignalSlotContextMock;

    /** @var MockInterface $trafficSignalContextMock */
    private $trafficSignalContextMock;

    /**
     * Initializes basic setup required for the tests to execute.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->trafficSignalSlotContextMock = Mockery::mock(TrafficSignalSlotContext::class);
        $this->trafficSignalContextMock = Mockery::mock(TrafficSignalContext::class);

        $this->normalTrafficState = new NormalTrafficState(
            $this->trafficSignalSlotContextMock,
            $this->trafficSignalContextMock,
            '6:00:00',
            '23:00:00'
        );
    }

    /**
     * Test to verify validate() validates against the time execution.
     *
     * @dataProvider timeValidationDataProvider
     *
     * @param string $start
     * @param string $finish
     * @param bool $expectedOutput
     *
     * @return void
     */
    public function testCanValidateIfSlotIsValidForExecution(string $start, string $finish, bool $expectedOutput): void
    {
        $this->normalTrafficState = new NormalTrafficState(
            $this->trafficSignalSlotContextMock,
            $this->trafficSignalContextMock,
            $start,
            $finish
        );

        $this->assertSame($expectedOutput, $this->normalTrafficState->validate());
    }

    /**
     * Test to verify:
     * start() can trigger/start the actions for traffic signal states
     * testSetNextState() can set the next state
     *
     * @return void
     */
    public function testStartCanExecuteTrafficSignalLightStateActions(): void
    {
        $start = date('H:i:s');
        $finish = date('H:i:s', time() + 3);
        $this->normalTrafficState = new NormalTrafficState(
            $this->trafficSignalSlotContextMock,
            $this->trafficSignalContextMock,
            $start,
            $finish
        );

        $greenStateMock = Mockery::mock(GreenState::class);
        $greenStateMock->shouldReceive('display')->withNoArgs()->once()->andReturn('GREEN');
        $greenStateMock->shouldReceive('next')->withNoArgs()->once();

        $this->trafficSignalContextMock->shouldReceive('getStateDuration')->once()->andReturn(2);
        $this->trafficSignalContextMock->shouldReceive('changeState')->withNoArgs()->once();
        $this->trafficSignalContextMock->shouldReceive('getState')->withNoArgs()->once()->andReturn($greenStateMock);

        $lowTrafficStateMock = Mockery::mock(LowTrafficState::class);
        $lowTrafficStateMock->shouldReceive('setDefaultStateForTrafficSignalContext')->once()->withNoArgs();

        $this->normalTrafficState->setNextState($lowTrafficStateMock);
        $this->trafficSignalSlotContextMock->shouldReceive('setState')
            ->with(
                Mockery::on(function ($state) use ($lowTrafficStateMock) {
                    $this->assertInstanceOf(LowTrafficState::class, $state);
                    $this->assertSame($lowTrafficStateMock, $state);

                    return true;
                })
            )
            ->once();
        $this->trafficSignalSlotContextMock->shouldReceive('getState')->withNoArgs()->once()->andReturn($lowTrafficStateMock);

        $this->expectOutputString('02 - GREEN' . PHP_EOL . '01 - GREEN' . PHP_EOL . '02 - GREEN' . PHP_EOL);

        $this->normalTrafficState->start();
    }

    /**
     * Test to verify setDefaultStateForTrafficSignalContext() sets the default state for the context.
     *
     * @return void
     */
    public function testCanSetDefaultStateAsYellowForTrafficSignalContext(): void
    {
        $yellowStateMock = Mockery::mock(GreenState::class);
        $this->trafficSignalContextMock->shouldReceive('getGreenState')->once()->andReturn($yellowStateMock);
        $this->trafficSignalContextMock->shouldReceive('setState')->with(
            Mockery::on(function ($state) use ($yellowStateMock) {
                $this->assertInstanceOf(GreenState::class, $state);
                $this->assertSame($yellowStateMock, $state);

                return true;
            })
        );
        $this->normalTrafficState->setDefaultStateForTrafficSignalContext();
    }

    /**
     * Returns the dataset for the testCanValidateIfSlotIsValidForExecution.
     *
     * @return array
     */
    public function timeValidationDataProvider(): array
    {
        return [
            [date('H:i:s', time() + 30), date('H:i:s', time() + 60), false],
            [date('H:i:s', time() - 30), date('H:i:s', time() - 60), false],
            [date('H:i:s', time() - 30), date('H:i:s', time() + 60), true],
        ];
    }
}
