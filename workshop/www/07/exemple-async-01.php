<?php
// Objectif : un premier exemple d'exécution de processus "enfant" en asynchrone,
// avec reactphp/child-process

require __DIR__ . '/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$cmd = "ls -l /";
$process = new React\ChildProcess\Process($cmd);

// Timer : pour éviter que le process ne soit lancé avant l'event-loop
$loop->addTimer(0.001, function(React\EventLoop\Timer\Timer $timer) use ($process) {
    $loop = $timer->getLoop();

    $process->start($loop);
    $process->stdout->on('data', function ($output) {
        var_dump($output);
    });
});

$loop->run();
