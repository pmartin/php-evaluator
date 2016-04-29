<?php
require_once __DIR__ . '/vendor/autoload.php';

class EvaluatorMultipleAsync
{
    private $phpCode;
    
    private $images;

    private $results;

    public function __construct(array $images)
    {
        $this->images = $images;
    }

    public function setCode(string $phpCode)
    {
        $this->phpCode = sprintf("<?php %s ?>", $phpCode);
    }

    public function run()
    {
        $loop = React\EventLoop\Factory::create();
        $loop->addTimer(0.001, function(React\EventLoop\Timer\Timer $timer) {
            $loop = $timer->getLoop();

            foreach ($this->images as $version => $image) {
                $this->results[$version] = [
                    'output' => null,
                    'error' => null,
                    'statusCode' => null,
                ];

                $cmd = sprintf("docker run -i --rm %s php -d 'display_errors=stderr'", escapeshellarg($image));

                $process = new React\ChildProcess\Process($cmd);
                $process->start($loop);

                // Code PHP envoyé sur l'entrée standard du processus 'php'
                $process->stdin->write($this->phpCode);
                $process->stdin->end();

                $process->on('exit', function ($code, $signal) use ($version) {
                    $this->results[$version]['statusCode'] = $code;
                });

                $process->stdout->on('data', function ($output) use ($version) {
                    $this->results[$version]['output'] .= $output;
                });

                $process->stderr->on('data', function ($output) use ($version) {
                    $this->results[$version]['error'] .= $output;
                });
            }
        });
        $loop->run();
    }

    public function getResults()
    {
        return $this->results;
    }
}
