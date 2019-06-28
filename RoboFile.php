<?php declare(strict_types=1);

use Robo\Tasks;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

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
        $this->dirRemove();
        $this->dirPrepare();
        $this->phpLint();
        $this->phpTestComplete();
        $this->phpCodeCoverage(['percentage' => 100]);
        $this->phpCodeStyle();
        $this->yell('Build complete');
    }

    //===================================================//
    // Directory Targets                                 //
    //===================================================//

    /**
     * Prepares artifact directories
     *
     * @return void
     */
    public function dirPrepare(): void
    {
        $paths = $this->getPaths();
        $filesystem = $this->getFilesystem();
        $this->info('Preparing artifact directories');
        $filesystem->mkdir([
            sprintf('%s/build/coverage', $paths['var']),
            sprintf('%s/build/logs', $paths['var'])
        ]);
        $this->info('Artifact directories prepared');
    }

    /**
     * Removes artifact directories
     *
     * @return void
     */
    public function dirRemove(): void
    {
        $paths = $this->getPaths();
        $filesystem = $this->getFilesystem();
        $this->info('Removing artifact directories');
        $filesystem->remove([
            sprintf('%s/build/coverage', $paths['var']),
            sprintf('%s/build/logs', $paths['var'])
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
    public function phpCodeStyle($opts = ['report' => false]): void
    {
        $report = $opts['report'] ?? false;
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->info('Starting code style check for PHP source files');
        // src code
        $command = $this->taskExec('php');
        $command
            ->arg(sprintf('%s/bin/phpcs', $paths['vendor']));
        if ($report) {
            $command->option('report=checkstyle');
            $command->option(sprintf('report-file=%s/build/logs/checkstyle.xml', $paths['var']));
            $command->option('warning-severity=0');
        }
        $command
            ->option(sprintf('standard=%s/phpcs.xml', $paths['build']))
            ->arg($paths['src'])
            ->printOutput($report ? false : true)
            ->run();
        // test code
        $exclusions = [
            'PSR1.Methods.CamelCapsMethodName',
            'PSR1.Classes.ClassDeclaration',
            'Squiz.WhiteSpace.ScopeClosingBrace'
        ];
        $command = $this->taskExec('php');
        $command
            ->arg(sprintf('%s/bin/phpcs', $paths['vendor']));
        if ($report) {
            $command->option('report=checkstyle');
            $command->option(sprintf('report-file=%s/build/logs/test-checkstyle.xml', $paths['var']));
            $command->option('warning-severity=0');
        }
        $command
            ->option(sprintf('standard=%s/phpcs.xml', $paths['build']))
            ->option(sprintf('exclude=%s', implode(',', $exclusions)))
            ->arg($paths['tests'])
            ->printOutput($report ? false : true)
            ->run();
        $this->info('PHP source files passed code style check');
    }

    /**
     * Performs code coverage check
     *
     * @option $percentage What percentage of code coverage is required
     *
     * @return void
     *
     * @throws Exception
     */
    public function phpCodeCoverage($opts = ['percentage' => 100]): void
    {
        $minPercentage = $opts['percentage'] ?? 100;
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->info('Starting code coverage check for PHP source files');
        $cloverXml = new SimpleXMLElement(file_get_contents(sprintf('%s/build/logs/clover.xml', $paths['var'])));
        $statements = (int) $cloverXml->project->metrics['statements'];
        $coveredStatements = (int) $cloverXml->project->metrics['coveredstatements'];
        $percentage = number_format($coveredStatements / $statements * 100, 2);
        if ($percentage < $minPercentage) {
            $message = sprintf('Code coverage (%s%%) is less than minimum %s%%', $percentage, $minPercentage);
            throw new Exception($message);
        }
        $this->info('PHP source files passed code coverage check');
    }

    /**
     * Performs syntax check on PHP source
     *
     * @return void
     */
    public function phpLint(): void
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
     * Measures project size and analyzes project structure
     */
    public function phpLinesOfCode()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->info('Measuring project size and analyzing project structure');
        $this->taskExec('php')
            ->arg(sprintf('%s/bin/phploc', $paths['vendor']))
            ->option('log-csv', sprintf('%s/build/logs/phploc.csv', $paths['var']))
            ->arg($paths['src'])
            ->printOutput(true)
            ->run();
        $this->info('Project size measured and structure analyzed');
    }

    /**
     * Runs all PHPUnit test suites
     *
     * @return void
     */
    public function phpTestComplete(): void
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->info('Running all PHPUnit test suites');
        $command = $this->taskExec('php');
        $command
            ->arg(sprintf('%s/bin/phpunit', $paths['vendor']))
            ->option('configuration', $paths['build'])
            ->option('cache-result-file', sprintf('%s/.phpunit.result.cache', $paths['cache']))
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
    private function info(string $message): void
    {
        $this->say(sprintf('<fg=green>%s</>', $message));
    }

    /**
     * Retrieves the application paths
     *
     * @return array
     */
    private function getPaths(): array
    {
        $root = __DIR__;

        return [
            'bin'    => sprintf('%s/bin', $root),
            'build'  => sprintf('%s/etc/build', $root),
            'cache'  => sprintf('%s/var/cache', $root),
            'etc'    => sprintf('%s/etc', $root),
            'src'    => sprintf('%s/src', $root),
            'tests'  => sprintf('%s/tests', $root),
            'var'    => sprintf('%s/var', $root),
            'vendor' => sprintf('%s/vendor', $root)
        ];
    }

    /**
     * Retrieves the filesystem
     *
     * @return Filesystem
     */
    private function getFilesystem(): Filesystem
    {
        static $filesystem;

        if (!isset($filesystem)) {
            $filesystem = new Filesystem();
        }

        return $filesystem;
    }
}
