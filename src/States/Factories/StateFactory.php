<?php

namespace App\States\Factories;

use App\Contexts\TrafficSignalContext;
use App\Contexts\TrafficSignalSlotContext;
use App\States\Lights\Contracts\LightStateInterface;
use App\States\Slots\Contracts\SlotStateInterface;

class StateFactory
{
    /**
     * @param string $state
     * @param TrafficSignalContext $trafficSignalContext
     * @param TrafficSignalSlotContext|null $trafficSignalSlotContext
     * @param string $selfOrNext must contain either 'SELF' or 'NEXT'
     * @return mixed LightStateInterface|SlotStateInterface
     */
    public static function getState(
        string $state,
        TrafficSignalContext $trafficSignalContext,
        TrafficSignalSlotContext $trafficSignalSlotContext = null, $selfOrNext = 'SELF')
    {
        $stateInstance = null;
        $config = config($state);

        switch ($state) {
            case 'GREEN' :
            case 'GREEN-YELLOW' :
            case 'RED' :
            case 'YELLOW' :
            case 'OFF' :
                $stateInstance = new $config[$selfOrNext]($trafficSignalContext);
                break;
            case 'LOW_TRAFFIC' :
            case 'NORMAL_TRAFFIC' :
                $stateInstance = new $config[$selfOrNext]($trafficSignalSlotContext, $trafficSignalContext);
                break;
        }

        return $stateInstance;
    }
}
