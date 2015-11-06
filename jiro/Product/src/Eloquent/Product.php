<?php 

namespace Jiro\Product\Eloquent;

use Jiro\Core\Sluggable;
use Jiro\Product\ProductInterface;

class Product implements ProductInterface 
{
	use Sluggable;

	/**
	 * {@inheritDoc}
	 */
	protected $table = 'products';

	/**
	 * {@inheritDoc}
	 */
	protected $guarded = [
		'id',
	];

	/**
	 * {@inheritDoc}
	 */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!array_key_exists('available_on', $attributes))
        {
            $this->setAvailableOn(new \DateTime);
        }
    }	

   /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable()
    {
        return new \DateTime() >= $this->available_on;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableOn()
    {
        return $this->available_on;
    }

    /**
     * {@inheritdoc}
     */
    public function setAvailableOn(\DateTime $available_on = null)
    {
        $this->available_on = $available_on;

        return $this;
    }

}
