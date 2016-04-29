<?php
// Exemple avec de l'asynchrone : on exécute un script PHP "long",
// sur deux images docker, "en même temps"
// Objectif : montrer qu'on y gagne sur la durée totale, en exécutant les deux
// run "en parallèle" et plus "à la suite l'un de l'autre"

require __DIR__ . '/vendor/autoload.php';

$php = <<<'PHP'
echo "Avant sleep()\n";
sleep(1);
echo "TIC... ";
sleep(1);
echo "TOC !\n";
echo "Après sleep()\n";
PHP;

$images = [
    '5.6' => 'php-jessie',
    '7.0' => 'php:7.0-cli',
];

$processesData = [];


$loop = React\EventLoop\Factory::create();
$loop->addTimer(0.001, function(React\EventLoop\Timer\Timer $timer) use ($images, $php, & $processesData) {
    $loop = $timer->getLoop();

    foreach ($images as $version => $image) {
        $cmd = sprintf("docker run --rm %s php -r %s", escapeshellarg($image), escapeshellarg($php));

        $process = new React\ChildProcess\Process($cmd);

        $processData = [
            'process' => $process,
            'output' => null,
            'error' => null,
        ];
        $processesData[$version] = & $processData;

        $process->start($loop);

        $process->on('exit', function ($code, $signal) use (& $processData) {
            $processData['statusCode'] = $code;
        });

        $process->stdout->on('data', function ($output) use (& $processData) {
            $processData['output'] .= $output;
        });

        $process->stderr->on('data', function ($output) use (& $processData) {
            $processData['error'] .= $output;
        });
    }
});
$loop->run();


foreach ($images as $version => $image) {
    echo "===================================\n";
    printf("** Avec l'image '%s' :**\n", $image);
    printf("Code status :\n%d\n\n", $processesData[$version]['statusCode']);
    printf("Sortie standard :\n%s\n\n", $processesData[$version]['output']);
    printf("Sortie d'erreurs :\n%s\n\n", $processesData[$version]['error']);
}
