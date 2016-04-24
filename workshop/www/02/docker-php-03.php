<?php
// Essayons d'exécuter du PHP dans un container docker ;-)
// Objectif : montrer qu'on y arrive \o/
// Code PHP passé à php via un pipe, sur stdin
// et on récupére stdout et stderr
// => On passe par proc_open(), qui permet tout ça ;-)

header('Content-Type: text/plain; charset=UTF-8');

// Ou alors, on envoie notre code PHP sur l'entrée standard de php
// et on récupère la sortie standard et le code statut et la sortie d'erreurs
// => On peut exécuter à peu près ce qu'on veut comme code PHP, on peut différencier
//    ce qui arrive sur stdout et ce qui arrive sur stderr,
//    on peut utiliser les fonctions de flux (ne pas tout charger en mémoire, flux
//    non-bloquants, ...), on n'a pas besoin de créer un fichier temporaire
//    contenant le code ; bref, c'est cool !
// Notes :
//  * "-i", puisqu'on veut échanger avec stdin/stdout du processus -> interactif
//  * erreurs de PHP envoyées explicitement vers stderr ;-)

$cmd = "docker run -i --rm php:7.0-cli php -d 'display_errors=stderr'";
$descriptors = [
    0 => ['pipe', 'r'], // stdin
    1 => ['pipe', 'w'], // stdout
    2 => ['pipe', 'w'], // stderr
];
$process = proc_open($cmd, $descriptors, $pipes);
if (!is_resource($process)) {
    die("Echec exécution commande");
}

$php = '<?php echo PHP_VERSION; ?>';
fwrite($pipes[0], $php);
fclose($pipes[0]);

$output = stream_get_contents($pipes[1]);
fclose($pipes[1]);

$errors = stream_get_contents($pipes[2]);
fclose($pipes[2]);

$status = proc_close($process);

printf("Code statut : %d\n", $status);
if ($status) {
    printf("Erreurs : %s\n", $errors);
} else {
    printf("Version de PHP dans le container : %s\n", $output);
}
