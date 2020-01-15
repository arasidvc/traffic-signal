<?php

/**
 * Test class for verifying methods within LowTrafficState.
 *
 * PHP version 7.3
 *
 * @author Vinayak Arasid <v.arasid@easternenterprise.com>
 */

declare(strict_types = 1);

namespace Tests\States\Slots;

use App\Contexts\TrafficSignalContext;
use App\Contexts\TrafficSignalSlotContext;
use App\States\Lights\YellowState;
use App\States\Slots\LowTrafficState;
use App\States\Slots\NormalTrafficState;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Mockery;

class LowTrafficStateTest extends TestCase
{
    /** @var LowTrafficState $lowTrafficState*/
    private $lowTrafficState;

    /** @var MockInterface $trafficSignalSlotContextMock */
    private $trafficSignalSlotContextMock;

    /** @var MockInterface $trafficSignalContextMock*/
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

        $this->lowTrafficState = new LowTrafficState(
            $this->trafficSignalSlotContextMock,
            $this->trafficSignalContextMock,
            '23:00:00',
            '6:00:00'
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
        $this->lowTrafficState = new LowTrafficState(
            $this->trafficSignalSlotContextMock,
            $this->trafficSignalContextMock,
            $start,
            $finish
        );

        $this->assertSame($expectedOutput, $this->lowTrafficState->validate());
    }

    /**
     * Test to verify setDefaultStateForTrafficSignalContext() sets the default state for the context.
     *
     * @return void
     */
    public function testCanSetDefaultStateAsYellowForTrafficSignalContext(): void
    {
        $yellowStateMock = Mockery::mock(YellowState::class);
        $this->trafficSignalContextMock->shouldReceive('getYellowState')->once()->andReturn($yellowStateMock);
        $this->trafficSignalContextMock->shouldReceive('setState')->with(
            Mockery::on(function ($state) use ($yellowStateMock) {
                $this->assertInstanceOf(YellowState::class, $state);
                $this->assertSame($yellowStateMock, $state);

                return true;
            })
        );
        $this->lowTrafficState->setDefaultStateForTrafficSignalContext();
    }

    /**
     * Returns the dataset for the testCanValidateIfSlotIsValidForExecution.
     *
     * @return array
     */
    public function timeValidationDataProvider(): array
    {
        return [
            [date('H:i:s', time() + 30), date('H:i:s', time() - 60), false],
            [date('H:i:s', time() + 30), date('H:i:s', time() + 60), true],
            [date('H:i:s', time() - 30), date('H:i:s', time() + 60), true],
        ];
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
        $start = date('H:i:s', time() + 3);
        $finish = date('H:i:s', time() + 2);
        $this->trafficSignalSlotContextMock = Mockery::mock(TrafficSignalSlotContext::class);
        $this->trafficSignalContextMock = Mockery::mock(TrafficSignalContext::class);
        $this->lowTrafficState = new LowTrafficState(
            $this->trafficSignalSlotContextMock,
            $this->trafficSignalContextMock,
            $start,
            $finish
        );

        $yellowStateMock = Mockery::mock(YellowState::class);
        $yellowStateMock->shouldReceive('display')->withNoArgs()->once()->andReturn('YELLOW');
        $yellowStateMock->shouldReceive('next')->withNoArgs()->once();

        $this->trafficSignalContextMock->shouldReceive('getStateDuration')->once()->andReturn(1);
        $this->trafficSignalContextMock->shouldReceive('changeState')->withNoArgs()->once();
        $this->trafficSignalContextMock->shouldReceive('getState')->withNoArgs()->once()->andReturn($yellowStateMock);

        $normalTrafficStateMock = Mockery::mock(NormalTrafficState::class);
        $normalTrafficStateMock->shouldReceive('setDefaultStateForTrafficSignalContext')->once()->withNoArgs();

        $this->lowTrafficState->setNextState($normalTrafficStateMock);
        $this->trafficSignalSlotContextMock->shouldReceive('setState')->with($normalTrafficStateMock)->once();
        $this->trafficSignalSlotContextMock->shouldReceive('getState')->withNoArgs()->once()->andReturn($normalTrafficStateMock);

        $this->expectOutputString('01 - YELLOW' . PHP_EOL . '01 - YELLOW' . PHP_EOL);

        $this->lowTrafficState->start();
    }
}
