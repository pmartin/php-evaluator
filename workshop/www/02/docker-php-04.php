<?php
// Essayons d'exécuter du PHP dans un container docker ;-)
// Objectif : montrer qu'on y arrive \o/
// Même chose qu'avant, avec proc_open(), mais encapsulation
// dans une classe, qu'on pourra ré-utiliser par la suite.

require __DIR__ . '/evaluator.php';

// Pas de balises PHP ouvrantes / fermantes ;-)
$code = 'echo PHP_VERSION;';

// Exécution du code
$evaluator = new Evaluator();
$evaluator->setCode($code);
$evaluator->run();

// Et lecture / affichage des résultats de cette exécution
$result = [
    'statusCode' => $evaluator->getStatusCode(),
    'output' => $evaluator->getOutput(),
    'error' => $evaluator->getErrors(),
];
var_dump($result);
