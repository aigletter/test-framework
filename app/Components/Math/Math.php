<?php

namespace Aigletter\App\Components\Math;

class Math implements MathInterface
{
    protected $logger;

    protected $mode;

    public function __construct(\Psr\Log\LoggerInterface $logger, string $mode)
    {
        $this->logger = $logger;
        $this->mode = $mode;
    }

    public function sum($a, $b): float
    {
        $result = $a + $b;
        $this->logger->debug('Sum of ' . $a . ' and ' . $b . ' is '. $result);

        return $result;
    }
}