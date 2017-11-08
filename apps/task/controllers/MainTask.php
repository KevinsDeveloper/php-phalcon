<?php

use Phalcon\Cli\Task;

/**
 * Class MainTask
 */
class MainTask extends Task
{
    /**
     * main
     * @return string
     */
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
    }
}