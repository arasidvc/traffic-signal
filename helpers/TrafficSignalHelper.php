<?php

function config($state)
{
    $config = [];
    foreach (glob("./config/*.php") as $filename) {
        $config = array_merge($config, include($filename));
    }

    return $config[$state];
}
