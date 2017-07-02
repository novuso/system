<?php

use Robo\Tasks;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * RoboFile is the task runner for this project
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class RoboFile extends Tasks
{
    /**
     * Application paths
     *
     * Access with getPaths()
     *
     * @var array|null
     */
    private $paths;

    /**
     * Filesystem
     *
     * Access with getFilesystem()
     *
     * @var Filesystem|null
     */
    private $filesystem;

    //===================================================//
    // Build Targets                                     //
    //===================================================//

    /**
     * Runs the default build process
     *
     * @return void
     */
    public function build()
    {
        $this->yell('Starting default build');
        $this->dirRemove();
        $this->dirPrepare();
        $this->phpLint();
        $this->phpTestComplete();
        $this->phpCodeStyle();
        $this->yell('Build complete');
    }

    /**
     * Installs project dependencies
     *
     * @option $prod Optimize for production
     *
     * @return void
     */
    public function install($opts = ['prod' => false])
    {
        $prod = isset($opts['prod']) && $opts['prod'] ? true : false;
        $this->info('Installing project dependencies');
        $this->composerInstall(['prod' => $prod]);
        $this->info('Project dependencies installed');
    }

    /**
     * Updates project dependencies
     *
     * @option $prod Optimize for production
     *
     * @return void
     */
    public function update($opts = ['prod' => false])
    {
        $prod = isset($opts['prod']) && $opts['prod'] ? true : false;
        $this->info('Updating project dependencies');
        $this->composerUpdate(['prod' => $prod]);
        $this->info('Project dependencies updated');
    }

    //===================================================//
    // Composer Targets                                  //
    //===================================================//

    /**
     * Installs Composer dependencies
     *
     * @option $prod Optimize for production
     *
     * @return void
     */
    public function composerInstall($opts = ['prod' => false])
    {
        $prod = isset($opts['prod']) && $opts['prod'] ? true : false;
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->info('Installing Composer dependencies');
        $command = $this->taskExec('composer')->dir($paths['root']);
        $command
            ->arg('install')
            ->option('prefer-dist');
        if ($prod) {
            $command->option('no-dev');
            $command->option('optimize-autoloader');
        }
        $command
            ->printOutput(true)
            ->run();
        $this->info('Composer dependencies installed');
    }

    /**
     * Updates Composer dependencies
     *
     * @option $prod Optimize for production
     *
     * @return void
     */
    public function composerUpdate($opts = ['prod' => false])
    {
        $prod = isset($opts['prod']) && $opts['prod'] ? true : false;
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->info('Updating Composer dependencies');
        $command = $this->taskExec('composer')->dir($paths['root']);
        $command
            ->arg('update')
            ->option('prefer-dist');
        if ($prod) {
            $command->option('no-dev');
            $command->option('optimize-autoloader');
        }
        $command
            ->printOutput(true)
            ->run();
        $this->info('Composer dependencies updated');
    }

    /**
     * Updates composer.lock file hash
     *
     * @return void
     */
    public function composerUpdateHash()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->info('Updating Composer lock file');
        $command = $this->taskExec('composer')->dir($paths['root']);
        $command
            ->arg('update')
            ->option('lock')
            ->printOutput(true)
            ->run();
        $this->info('Composer lock file updated');
    }

    //===================================================//
    // Directory Targets                                 //
    //===================================================//

    /**
     * Prepares artifact directories
     *
     * @return void
     */
    public function dirPrepare()
    {
        $paths = $this->getPaths();
        $filesystem = $this->getFilesystem();
        $this->info('Preparing artifact directories');
        $filesystem->mkdir([
            $paths['coverage'],
            $paths['reports']
        ]);
        $this->info('Artifact directories prepared');
    }

    /**
     * Removes artifact directories
     *
     * @return void
     */
    public function dirRemove()
    {
        $paths = $this->getPaths();
        $filesystem = $this->getFilesystem();
        $this->info('Removing artifact directories');
        $filesystem->remove([
            $paths['coverage'],
            $paths['reports']
        ]);
        $this->info('Artifact directories removed');
    }

    //===================================================//
    // PHP Targets                                       //
    //===================================================//

    /**
     * Performs code style check on PHP source
     *
     * @option $report Generate an XML report for continuous integration
     *
     * @return void
     */
    public function phpCodeStyle($opts = ['report' => false])
    {
        $report = isset($opts['report']) && $opts['report'] ? true : false;
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->info('Starting code style check for PHP source files');
        $command = $this->taskExec('php');
        $command
            ->arg(sprintf('%s/phpcs', $paths['lib']));
        if ($report) {
            $command->option('report=checkstyle');
            $command->option(sprintf('report-file=%s/checkstyle.xml', $paths['reports']));
            $command->option('warning-severity=0');
        }
        $command
            ->option(sprintf('standard=%s/phpcs.xml', $paths['build']))
            ->arg($paths['src'])
            ->printOutput($report ? false : true)
            ->run();
        $this->info('PHP source files passed code style check');
    }

    /**
     * Performs syntax check on PHP source
     *
     * @return void
     */
    public function phpLint()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->info('Starting syntax check of PHP source files');
        $iterator = Finder::create()
            ->files()
            ->name('*.php')
            ->in($paths['src'])
            ->sortByName();
        /** @var SplFileInfo $file */
        foreach ($iterator as $file) {
            $command = $this->taskExec('php');
            $command
                ->arg('-l')
                ->arg($file->getRealPath())
                ->printOutput(false)
                ->run();
        }
        $this->info('PHP source files passed syntax check');
    }

    /**
     * Runs all PHPUnit test suites
     *
     * @return void
     */
    public function phpTestComplete()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->info('Running all PHPUnit test suites');
        $command = $this->taskExec('php');
        $command
            ->arg(sprintf('%s/phpunit', $paths['lib']))
            ->option('configuration', $paths['build'])
            ->option('testsuite', 'complete')
            ->printOutput(true)
            ->run();
        $this->info('Project passed all PHPUnit test suites');
    }

    //===================================================//
    // Helper Methods                                    //
    //===================================================//

    /**
     * Prints text with info color
     *
     * @param string $message The message
     *
     * @return void
     */
    private function info($message)
    {
        $this->say(sprintf('<%s>%s</>', 'fg=green', $message));
    }

    /**
     * Retrieves the application paths
     *
     * @return array
     */
    private function getPaths()
    {
        if ($this->paths === null) {
            $this->paths = require __DIR__.'/app/paths.php';
        }

        return $this->paths;
    }

    /**
     * Retrieves the filesystem
     *
     * @return Filesystem
     */
    private function getFilesystem()
    {
        if ($this->filesystem === null) {
            $this->filesystem = new Filesystem();
        }

        return $this->filesystem;
    }
}
