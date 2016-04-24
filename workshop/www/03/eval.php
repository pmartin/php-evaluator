<?php
require __DIR__ . '/evaluator.php';

// Récupération du code soumis
// On supposera que c'est du PHP -- et uniquement quelque chose qu'on est prêt à exécuter !
if (!isset($_POST['code'])) {
    echo "Code attendu en entrée";
    die;
}
$code = trim($_POST['code']);


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
?>
<html>
<head>
    <title>Evaluateur de code PHP</title>
</head>
<body>
<div>
    <p>Code PHP exécuté :</p>
    <p><?= highlight_string('<?php ' . $code . ' ?>', true); ?></p>
</div>
<div>
    <p>Code statut : <?= intval($result['statusCode']) ?></p>
</div>
<div>
    <p>Sortie standard :</p>
    <pre><?= htmlspecialchars($result['output']) ?></pre>
</div>
<div>
    <p>Sortie d'erreurs :</p>
    <pre><?= htmlspecialchars($result['error']) ?></pre>
</div>
</body>
</html>
