<?php
/**
 * This file is part of the Novuso Framework
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */

$root_dir = dirname(__DIR__);

return [
    'root'     => $root_dir,
    'api'      => $root_dir.'/var/build/api',
    'app'      => $root_dir.'/app',
    'bin'      => $root_dir.'/bin',
    'build'    => $root_dir.'/etc/build',
    'cache'    => $root_dir.'/var/cache',
    'config'   => $root_dir.'/etc',
    'coverage' => $root_dir.'/var/build/coverage',
    'lib'      => $root_dir.'/vendor/bin',
    'reports'  => $root_dir.'/var/build/logs',
    'src'      => $root_dir.'/src',
    'test'     => $root_dir.'/test',
    'var'      => $root_dir.'/var',
    'vendor'   => $root_dir.'/vendor'
];
