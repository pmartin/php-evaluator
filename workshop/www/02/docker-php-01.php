<?php
// Essayons d'exécuter du PHP dans un container docker ;-)
// Objectif : montrer qu'on y arrive \o/
// Code PHP passé en paramètre à php via option -r

header('Content-Type: text/plain; charset=UTF-8');

// Brutalement, tout est fait dans le container
$php = 'echo "Version de PHP : ", PHP_VERSION, "\n";';
$cmd = "docker run --rm php:7.0-cli php -r " . escapeshellarg($php);
passthru($cmd);
