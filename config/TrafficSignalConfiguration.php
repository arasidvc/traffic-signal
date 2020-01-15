<?php

return [
    'GREEN' => [
        'DURAION' => 30,
        'NEXT' => \App\States\Lights\GreenYellowState::class,
        'SELF' => \App\States\Lights\GreenState::class
    ],
    'GREEN-YELLOW' => [
        'DURATION' => 5,
        'NEXT' => \App\States\Lights\RedState::class,
        'SELF' => \App\States\Lights\GreenYellowState::class
    ],
    'RED' => [
        'DURATION' => 40,
        'NEXT' => \App\States\Lights\GreenState::class,
        'SELF' => \App\States\Lights\RedState::class
    ],
    'YELLOW' => [
        'DURATION' => 1,
        'NEXT' => \App\States\Lights\OffState::class,
        'SELF' => \App\States\Lights\YellowState::class
    ],
    'OFF' => [
        'DURATION' => 2,
        'NEXT' => \App\States\Lights\YellowState::class,
        'SELF' => \App\States\Lights\OffState::class
    ],
    'LOW_TRAFFIC' => [
        'NEXT' => \App\States\Slots\NormalTrafficState::class,
        'SELF' => \App\States\Slots\LowTrafficState::class,
        'START' => '',
        'END' => ''
    ],
    'NORMAL_TRAFFIC' => [
        'NEXT' => \App\States\Slots\LowTrafficState::class,
        'SELF' => \App\States\Slots\NormalTrafficState::class,
        'START' => '',
        'END' => ''
    ],
];
