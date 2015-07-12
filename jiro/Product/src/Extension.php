<?php namespace Jiro\Product;

use Jiro\Admin\Extension\Extension as BaseExtension;

/**
 * Product extension provider.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class Extension extends BaseExtension
{
    /**
     * {@inheritDoc}
     */
    public function isInstalled()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function install()
    {
        // ...
    }  

    /**
     * {@inheritDoc}
     */
    public function unInstall()
    {
        // ...
    }    
}