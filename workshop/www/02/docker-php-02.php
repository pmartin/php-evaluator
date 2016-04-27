<?php
// Essayons d'exécuter du PHP dans un container docker ;-)
// Objectif : montrer qu'on y arrive \o/
// Code PHP passé à php via un pipe, sur stdin
// Note : passthru(), ça répond pas tout à fait à notre besoin non plus ;-)
// Et échapper tout le code PHP, bof quoi.

header('Content-Type: text/plain; charset=UTF-8');

$php = '<?php echo PHP_VERSION; ?>';
$cmdEcho = 'echo ' . escapeshellarg($php);
$cmd = $cmdEcho . ' | docker run -i --rm php:7.0-cli php';

echo "Version de PHP dans le container : ";
passthru($cmd);
