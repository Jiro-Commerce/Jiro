<?php namespace Jiro\Core\Extension;

/**
 * Extension Interface
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

interface Extensible
{
    /**
     * Checks if the extension is installed.
     *
     * @return bool
     */
    public function isInstalled();

    /**
     * Installs the extension.
     *
     * @return void
     * @throws \RuntimeException
     */
    public function install();

    /**
     * Uninstalls the extension.
     *
     * @return void
     * @throws \RuntimeException
     */
    public function uninstall();
}
