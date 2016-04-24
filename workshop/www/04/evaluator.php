<?php

class Evaluator
{
    private $phpCode;
    
    private $image;

    private $stdout;
    private $stderr;
    private $status;

    public function __construct(string $image)
    {
        $this->image = $image;
    }

    public function setCode(string $phpCode)
    {
        $this->phpCode = sprintf("<?php %s ?>", $phpCode);
    }

    public function run()
    {
        $cmd = sprintf("docker run -i --rm %s php -d 'display_errors=stderr'", escapeshellarg($this->image));
        $descriptors = [
            0 => ['pipe', 'r'], // stdin
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w'], // stderr
        ];
        $process = proc_open($cmd, $descriptors, $pipes);
        if (!is_resource($process)) {
            throw new \RuntimeException("Echec exécution commande");
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
