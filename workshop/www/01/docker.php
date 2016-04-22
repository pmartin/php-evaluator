<?php
// Essayons de lancer une commande docker
// pour vérifier qu'on accède bien au démon

header('Content-Type: text/plain; charset=UTF-8');

echo "Objectif :\n";
echo "  * Un tout premier `docker exec`\n";
echo "  * Depuis PHP-FPM\n";
echo "(Oui, c'est mal...)\n";
echo "\n";

echo str_repeat('=', 80), "\n";
passthru("docker run hello-world");
echo str_repeat('=', 80), "\n";
