<?php
// On reprend notre exemple qui reçoit du code PHP en POST
// et l'évalue sur plusieurs versions de PHP (chacune via une image docker),
// mais ces exécutions se font maintenant en simultané, via reactphp/child-process

require __DIR__ . '/evaluator-multiple-async.php';


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


$before = microtime(true);

$evaluator = new EvaluatorMultipleAsync($images);
$evaluator->setCode($code);
$evaluator->run();
$results = $evaluator->getResults();

$after = microtime(true);
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
<hr>
<div>
    Temps total : <?= number_format($after-$before, 3, ',', ' ') ?> sec
</div>
</body>
</html>
