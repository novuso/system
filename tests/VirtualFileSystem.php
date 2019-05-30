<?php declare(strict_types=1);

namespace Novuso\System\Test;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\visitor\vfsStreamStructureVisitor;

/**
 * Trait VirtualFileSystem
 */
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
    protected function createVfs(array $structure, $baseDir = 'root', $umask = 0022): vfsStreamDirectory
    {
        vfsStream::umask($umask);

        return vfsStream::setup($baseDir, null, $structure);
    }

    /**
     * Retrieves the virtual file system structure
     *
     * @return array
     */
    protected function inspectVfs(): array
    {
        /** @var vfsStreamStructureVisitor $visitor */
        $visitor = vfsStream::inspect(new vfsStreamStructureVisitor());

        return $visitor->getStructure();
    }

    /**
     * Retrieves the virtual file system path
     *
     * @param string $path The path relative to the root folder
     *
     * @return string
     */
    protected function vfsPath($path = ''): string
    {
        /** @var vfsStreamDirectory $rootDirectory */
        $rootDirectory = vfsStreamWrapper::getRoot();
        $root = $rootDirectory->getName();

        if (empty($path)) {
            return vfsStream::url($root);
        }

        return vfsStream::url(sprintf('%s/%s', $root, $path));
    }
}
