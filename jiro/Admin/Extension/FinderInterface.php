<?php namespace Jiro\Admin\Extension;

/**
 * Extension Finder Interface
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

interface FinderInterface
{
    /**
     * Return array of absolute extension paths.
     *
     * @return array
     */
    public function findExtensions();

    /**
     * Adds a path to the extensions finder.
     *
     * @param  string  $path
     * @return void
     */
    public function addPath($path);

    /**
     * Adds an exclude path to the extensions finder.
     *
     * @param  string  $path
     * @return void
     */
    public function addExcludePath($path);    

    /**
     * Return array of absolute extension paths in a given $path
     *
     * @param  string  $path
     * @return array
     */
    public function findExtensionsInPath($path);
}
