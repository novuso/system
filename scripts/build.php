<?php declare(strict_types=1);

use Symfony\Component\Finder\Finder;

$rootDirectory = dirname(__DIR__);

$paths = [
    'bin'     => $rootDirectory.'/bin',
    'build'   => $rootDirectory.'/etc/build',
    'cache'   => $rootDirectory.'/var/cache',
    'etc'     => $rootDirectory.'/etc',
    'reports' => $rootDirectory.'/var/reports',
    'scripts' => $rootDirectory.'/scripts',
    'src'     => $rootDirectory.'/src',
    'tests'   => $rootDirectory.'/tests',
    'var'     => $rootDirectory.'/var',
    'vendor'  => $rootDirectory.'/vendor'
];

require $rootDirectory.'/vendor/autoload.php';

function print_line(string $color, string $message): void
{
    $colors = [
        'red'         => '0;31',
        'green'       => '0;32',
        'blue'        => '0;34',
        'purple'      => '0;35',
        'cyan'        => '0;36',
        'white'       => '1;37'
    ];

    if (!isset($colors[$color])) {
        throw new Exception('Color not defined');
    }

    echo sprintf("\033[%sm%s\033[0m\n\n", $colors[$color], $message);
}

// LINT
$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($paths['src'])
    ->sortByName();

/** @var SplFileInfo $file */
foreach ($iterator as $file) {
    passthru(sprintf('php -l %s', $file->getRealPath()), $result);
    if ($result !== 0) {
        return $result;
    }
}

print_line('green', 'Syntax check completed');

// UNIT TESTS
passthru(sprintf(
    'php %s/bin/phpunit --configuration=%s --cache-directory=%s --testsuite=complete',
    $paths['vendor'],
    $paths['build'],
    $paths['cache']
), $result);

if ($result !== 0) {
    return $result;
}

print_line('green', 'PhpUnit tests passed');

// CODE COVERAGE
$minPercentage = 100;
$cloverFilePath = sprintf('%s/reports/artifacts/clover.xml', $paths['var']);
$cloverXml = new SimpleXMLElement(file_get_contents($cloverFilePath));
$statements = (int) $cloverXml->project->metrics['statements'];
$coveredStatements = (int) $cloverXml->project->metrics['coveredstatements'];
$percentage = number_format($coveredStatements / $statements * 100, 2);
if ($percentage < $minPercentage) {
    print_line('red', sprintf(
        'Code coverage (%s%%) is less than minimum %s%%',
        $percentage,
        $minPercentage
    ));

    return 1;
} else {
    print_line('green', 'Code coverage check passed');
}

// CODE STYLE
passthru(sprintf(
    'php %s/bin/phpcs -s --standard=%s/phpcs.xml %s',
    $paths['vendor'],
    $paths['build'],
    $paths['src']
), $result);

if ($result !== 0) {
    return $result;
} else {
    print_line('green', 'Code style check passed');
}

return 0;
