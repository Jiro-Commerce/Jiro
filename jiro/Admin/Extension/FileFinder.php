<?php namespace Jiro\Admin\Extension;

use Illuminate\Filesystem\Filesystem;

/**
 * File based extension finder.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class FileFinder implements FinderInterface
{
    /**
     * Filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Array of paths.
     *
     * @var Array
     */
    protected $paths = [];

    /**
     * Array of paths to exclude.
     *
     * @var Array
     */
    protected $excludePaths = [];    

    /**
     * Object constructor.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     * @param  Array  $paths
     * @return void
     */
    public function __construct(Filesystem $filesystem, Array $paths, Array $excludePaths = [])
    {
        $this->paths = $paths;

        $this->excludePaths = $excludePaths;

        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritDoc}
     */
    public function findExtensions()
    {
        $extensions = [];
        
        foreach ($this->paths as $path) {
            $extensions = array_merge($extensions, $this->findExtensionsInPath($path));
        }
        
        return $extensions;
    }

    /**
     * {@inheritDoc}
     */
    public function addPath($path)
    {
        $this->paths[] = $path;
    }

    /**
     * {@inheritDoc}
     */
    public function addExcludePath($path)
    {
        $this->exludePaths[] = $path;
    }    

    /**
     * {@inheritDoc}
     */
    public function findExtensionsInPath($path)
    {
        $extensions = $this->filesystem->glob($path.'/*/*/extension.php');

        if ($extensions === false) {
            return [];
        }

        $extensions = $this->removeExclusions($extensions);

        return $extensions;
    }

    /**
     * remove any exluded extension paths
     *
     * @param  Array $paths
     */
    private function removeExclusions($paths)
    {
        // to lower case
        $excluded = array_map('strtolower', $this->excludePaths);

        foreach ($paths as $key => $path) {
            if (in_array(strtolower($path), $excluded)) { 
                unset($paths[$key]);
            }
        }

        return $paths;
    }
}
