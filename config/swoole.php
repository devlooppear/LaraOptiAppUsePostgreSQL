<?php

return [
    'host' => env('SWOOLE_HTTP_HOST', '127.0.0.1'),
    'port' => env('SWOOLE_HTTP_PORT', '1215'),
    'options' => [
        'pid_file' => env('SWOOLE_PID_FILE', storage_path('swoole.pid')),
        'log_file' => env('SWOOLE_LOG_FILE', storage_path('swoole.log')),
        'daemonize' => env('SWOOLE_DAEMONIZE', false),
        'log_level' => env('SWOOLE_LOG_LEVEL', 0),
    ],
];
