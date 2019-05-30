<?php declare(strict_types=1);

use Robo\Tasks;

/**
 * RoboFile is the task runner for this project
 */
class RoboFile extends Tasks
{
    //===================================================//
    // Build Targets                                     //
    //===================================================//

    /**
     * Runs the default build process
     *
     * @return void
     *
     * @throws Exception
     */
    public function build(): void
    {
        $this->yell('Starting default build');
        $this->yell('Build complete');
    }
}
