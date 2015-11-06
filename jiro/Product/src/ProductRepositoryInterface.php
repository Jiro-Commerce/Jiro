<?php 

namespace Jiro\Product;

/**
 * Base product repository interface.
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

interface ProductRepositoryInterface
{
	/**
	 * Returns all the products entries.
	 *
	 * @return \Andrewmclagan\Products\Models\Product
	 */
	public function findAll();

	/**
	 * Returns a products entry by its primary key.
	 *
	 * @param  int  $id
	 * @return \Andrewmclagan\Products\Models\Product
	 */
	public function find($id);

	/**
	 * Creates or updates the given products.
	 *
	 * @param  int  $id
	 * @return bool|array
	 */
	public function store($id, array $input);

	/**
	 * Creates a products entry with the given data.
	 *
	 * @param  array  $data
	 * @return \Andrewmclagan\Products\Models\Product
	 */
	public function create(array $data);

	/**
	 * Updates a products entry with the given data.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Andrewmclagan\Products\Models\Product
	 */
	public function update($id, array $data);

	/**
	 * Deletes a products entry.
	 *
	 * @param  int  $id
	 * @return bool
	 */
	public function delete($id);
}
