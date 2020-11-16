<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class FileParserService
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $path
     * @return mixed []
     */
    public function readFileAndConvertToArray(string $path)
    {
        try {
            $file = file_get_contents($path, true);
        } catch (\Exception $exception) {
            $this->logger->error('File does not exist on given path.');

            return [];
        }

        return json_decode($file);
    }
}
