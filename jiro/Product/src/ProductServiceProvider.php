<?php namespace Jiro\Product;

use Illuminate\Support\ServiceProvider;
use Jiro\Product\Eloquent\Product;
use Jiro\Product\Eloquent\ProductRepository;

/**
 * Product service provider.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class ProductServiceProvider extends ServiceProvider 
{
	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{ 
		// ..
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{ 
		$this->registerProduct();

		$this->registerProductRepository();
	}	

	/**
	 * Register Product class.
	 *
	 * @return void
	 */
	protected function registerProduct()
	{
		$this->app->bind(ProductInterface::class, Product::class);
	}		

	/**
	 * Register Product Repository class.
	 *
	 * @return void
	 */
	protected function registerProductRepository()
	{
		$this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
	}	
}
