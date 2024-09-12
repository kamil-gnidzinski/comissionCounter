<?php

namespace App\Logger;

class SimpleLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        echo $message . PHP_EOL;
    }
}
