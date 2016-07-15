<?php

namespace Novuso\Test\System\Traits;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\visitor\vfsStreamStructureVisitor;

trait VirtualFileSystem
{
    /**
     * Creates a virtual file system
     *
     * @param array  $structure A nested array keyed by folder or filename;
     *                           array values for sub-directories
     * @param string $baseDir   The name of the base directory
     * @param int    $umask     Umask setting for the virtual file system
     *
     * @return vfsStreamDirectory
     */
    protected function createVfs(array $structure, $baseDir = 'root', $umask = 0022)
    {
        vfsStream::umask($umask);

        return vfsStream::setup($baseDir, null, $structure);
    }

    /**
     * Retrieves the virtual file system structure
     *
     * @return array
     */
    protected function inspectVfs()
    {
        return vfsStream::inspect(new vfsStreamStructureVisitor())->getStructure();
    }

    /**
     * Retrieves the virtual file system path
     *
     * @param string $path The path relative to the root folder
     *
     * @return string
     */
    protected function vfsPath($path = '')
    {
        $root = vfsStreamWrapper::getRoot()->getName();

        if (empty($path)) {
            return vfsStream::url($root);
        }

        return vfsStream::url($root.'/'.$path);
    }
}
