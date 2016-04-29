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
    '5.6' => [
        'image' => 'php-jessie',
    ],
    '7.0' => [
        'image' => 'php:7.0-cli',
    ],
    '7.1-dev' => [
        'image' => 'php-7.1',
        'options' => [
            '--volume /var/www/php-build/php-7.1-dev/:/usr/local/php-7.1-dev/:ro',
            '--env PATH=/usr/local/php-7.1-dev/bin/:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin',
        ],
    ],
];

$before = microtime(true);

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
