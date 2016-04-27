<?php
require __DIR__ . '/evaluator.php';

// Récupération du code soumis
// On supposera que c'est du PHP -- et uniquement quelque chose qu'on est prêt à exécuter !
if (!isset($_POST['code'])) {
    echo "Code attendu en entrée";
    die;
}
$code = trim($_POST['code']);

$images = [
    '5.6' => 'php-jessie',
    '7.0' => 'php:7.0-cli',
];

$results = [];
foreach ($images as $version => $image) {
    $evaluator = new Evaluator($image);
    $evaluator->setCode($code);
    $evaluator->run();
    $results[$version] = [
        'statusCode' => $evaluator->getStatusCode(),
        'output' => $evaluator->getOutput(),
        'error' => $evaluator->getErrors(),
    ];
}
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
<?php foreach ($results as $version => $result): ?>
    <hr>
    <div>Version de PHP : <?= htmlspecialchars($version); ?></div>
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
<?php endforeach; ?>
</body>
</html>
