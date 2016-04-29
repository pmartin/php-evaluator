<?php
// Exemple sans asynchrone : le code est exécuté sur un container après l'autre
// => Durée totale = X fois la durée d'exécution du code


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

foreach ($images as $image) {
    printf("** Avec l'image '%s' :**\n", $image);
    $cmd = sprintf("docker run --rm %s php -r %s", escapeshellarg($image), escapeshellarg($php));
    passthru($cmd);
    echo "\n\n";
}

