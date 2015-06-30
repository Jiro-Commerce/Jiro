<?php namespace Jiro\Product\Tests;

use Jiro\Support\Testing\DbTestCase;

/**
 * Sets up application instance and DB for integration testing
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

abstract class TestCase extends DbTestCase 
{
    /** 
     * {@inheritdoc}
     */
	public function getServiceProviders()
	{
		return ['Jiro\Product\ProductServiceProvider'];
	}

    /** 
     * {@inheritdoc}
     */
	public function getMigrationsDirectory()
	{
		return __DIR__ . '/../database/migrations';
	}
}



