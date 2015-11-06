<?php 

namespace Jiro\Product\Eloquent;

use Jiro\Product\ProductRepositoryInterface;

/**
 * Base product repository.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class ProductRepository implements ProductRepositoryInterface 
{
	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function findAll()
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function find($id)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function store($id, array $input)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function create(array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function update($id, array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function delete($id)
	{
		
	}	
}
