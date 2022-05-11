<?php

namespace Aigletter\App\Components\Logging;

use Aigletter\Contracts\ComponentFactory;
use Mursalov\Logger\FileWriter;
use Mursalov\Logger\Formatter;
use Mursalov\Logger\Logger;

class LoggerFactory extends ComponentFactory
{
    public const KEY_FILEPATH = 'filepath';

    public const KEY_FILENAME = 'filename';

    protected function createConcreteComponent()
    {
        $formatter = new Formatter();
        $writer = new FileWriter($formatter, $this->arguments[self::KEY_FILEPATH], $this->arguments[self::KEY_FILENAME]);
        $logger = new Logger($writer);

        return $logger;
    }
}