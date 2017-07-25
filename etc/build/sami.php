<?php

use Sami\Sami;
use Sami\Parser\Filter\PublicFilter;
use Symfony\Component\Finder\Finder;

$paths = require sprintf('%s/app/paths.php', dirname(dirname(__DIR__)));

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($paths['src']);

$options = [
    'theme'                => 'default',
    'title'                => 'Novuso System',
    'build_dir'            => $paths['api'],
    'cache_dir'            => $paths['cache'].'/sami',
    'default_opened_level' => 2
];

$sami = new Sami($iterator, $options);

$sami['filter'] = function () {
    return new PublicFilter();
};

return $sami;
