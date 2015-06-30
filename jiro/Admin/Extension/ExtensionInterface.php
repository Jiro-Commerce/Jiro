<?php namespace Jiro\Admin\Extension;

/**
 * Extension Interface
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

interface ExtensionInterface
{
    /**
     * Returns the extension slug.
     *
     * @return string
     */
    public function getSlug();

    /**
     * Returns the extension path.
     *
     * @return string
     */
    public function getPath();

    /**
     * Returns the extension namespace.
     *
     * @return string
     */
    public function getNamespace();

    /**
     * Returns the extension vendor name.
     *
     * @return string
     */
    public function getVendor();

    /**
     * Returns all the dependencies of the extension.
     *
     * @return array
     */
    public function getDependencies();

    /**
     * Checks if the extension is versioned or not.
     *
     * @return bool
     */
    public function isVersioned();

    /**
     * Returns the extension version.
     *
     * @return string
     */
    public function getVersion();

    /**
     * Checks if the extension can be installed or not.
     *
     * @return bool
     */
    public function canInstall();

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
     * Checks if the extension can be uninstalled.
     *
     * @return bool
     */
    public function canUninstall();

    /**
     * Checks if the extension is uninstalled.
     *
     * @return bool
     */
    public function isUninstalled();

    /**
     * Uninstalls the extension.
     *
     * @return void
     * @throws \RuntimeException
     */
    public function uninstall();

    /**
     * Checks if the extension can be enabled.
     *
     * @return bool
     */
    public function canEnable();

    /**
     * Checks if the extension is enabled.
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Enables the extension.
     *
     * @return void
     * @throws \RuntimeException
     */
    public function enable();

    /**
     * Checks if the extension can be disabled.
     *
     * @return bool
     */
    public function canDisable();

    /**
     * Checks if the extension is disabled.
     *
     * @return bool
     */
    public function isDisabled();

    /**
     * Disables the extension.
     *
     * @return void
     * @throws \RuntimeException
     */
    public function disable();

    /**
     * Checks if the extension has service providers.
     *
     * @return bool
     */
    public function hasProviders();

    /**
     * Checks if the extension needs to be upgraded.
     *
     * @return bool
     */
    public function needsUpgrade();

    /**
     * Upgrades the extension.
     *
     * @return void
     * @throws \RuntimeException
     */
    public function upgrade();

    /**
     * Checks if the extension is registered.
     *
     * @return bool
     */
    public function isRegistered();

    /**
     * Register the extension, this is done while adding the
     * extension to the extension bag. All the extensions
     * should be registered befored being booted.
     *
     * @return void
     */
    public function register();

    /**
     * Checks if the extension is booted.
     *
     * @return bool
     */
    public function isBooted();

    /**
     * Boots the extension.
     *
     * @return void
     * @throws \RuntimeException
     */
    public function boot();
}
