<?php

class Evaluator
{
    private $phpCode;
    
    private $imageConfig;

    private $stdout;
    private $stderr;
    private $status;

    public function __construct(array $imageConfig)
    {
        $this->imageConfig = $imageConfig;
    }

    public function setCode(string $phpCode)
    {
        $this->phpCode = sprintf("<?php %s ?>", $phpCode);
    }

    public function run()
    {
        $imageName = $this->imageConfig['image'];
        $optionsStr = isset($this->imageConfig['options']) ? implode(' ', $this->imageConfig['options']) : '';
        $cmd = sprintf("docker run -i --rm %s %s php -d 'display_errors=stderr'", $optionsStr, escapeshellarg($imageName));
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
