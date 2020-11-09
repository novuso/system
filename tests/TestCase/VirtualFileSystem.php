<?php declare(strict_types=1);

namespace Novuso\System\Test\TestCase;

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
     */
    protected function createVfs(array $structure, string $baseDir = 'root', int $umask = 0022): vfsStreamDirectory
    {
        vfsStream::umask($umask);

        return vfsStream::setup($baseDir, null, $structure);
    }

    /**
     * Retrieves the virtual file system structure
     */
    protected function inspectVfs(): array
    {
        /** @var vfsStreamStructureVisitor $visitor */
        $visitor = vfsStream::inspect(new vfsStreamStructureVisitor());

        return $visitor->getStructure();
    }

    /**
     * Retrieves the virtual file system path
     */
    protected function vfsPath(string $path = ''): string
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
