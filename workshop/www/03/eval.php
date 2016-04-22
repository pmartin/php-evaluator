<?php

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



class Evaluator
{
    private $phpCode;

    private $stdout;
    private $stderr;
    private $status;
    
    public function __construct()
    {
        
    }
    
    public function setCode(string $phpCode)
    {
        $this->phpCode = sprintf("<?php %s ?>", $phpCode);
    }
    
    public function run()
    {
        $cmd = "docker run -i php:7.0-cli php -d 'display_errors=stderr'";
        $descriptors = [
            0 => ['pipe', 'r'], // stdin
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w'], // stderr
        ];
        $process = proc_open($cmd, $descriptors, $pipes);
        if (!is_resource($process)) {
            die("Echec exécution commande");
        }

        fwrite($pipes[0], $this->phpCode);
        fclose($pipes[0]);

        $this->stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $this->stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        $this->status = proc_close($process);
    }

    public function getOutput()
    {
        return $this->stdout;
    }

    public function getErrors()
    {
        return $this->stderr;
    }

    public function getStatusCode()
    {
        return $this->status;
    }
}

