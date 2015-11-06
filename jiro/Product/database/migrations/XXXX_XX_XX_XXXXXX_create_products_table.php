<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function($table)
		{
			$table->increments('id');
			
            $table->string('name');
            $table->string('slug');
            $table->string('SKU')->nullable();
            $table->decimal('price', 5, 2);
            $table->decimal('sale_price', 5, 2)->nullable();
            $table->dateTime('sale_price_from')->nullable();
            $table->dateTime('sale_price_to')->nullable();
            $table->longText('description')->nullable();
            $table->longText('short_description')->nullable();
            $table->boolean('enabled')->default(true);
            $table->integer('stock')->nullable();
            $table->boolean('in_stock')->default(true);
            $table->dateTime('available_on');

            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}
}