<?php namespace Jiro\Admin\Extension;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Contracts\Support\Arrayable;
use Jiro\Admin\Extension\ExtensionInterface;

/**
 * Manages the admin extiontion functionality
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

class Extension implements Arrayable, ExtensionInterface
{
	/**
	 * Migrator 
	 * 
	 * @var \Illuminate\Database\Migrations\Migrator
	 */
	private static $migrator;

	/**
	 * Event dispatcher
	 * 
	 * @var \Illuminate\Events\Dispatcher
	 */	
	private static $dispatcher;

	/**
	 * DB Connection resolver
	 * 
	 * @var \Illuminate\Database\ConnectionResolverInterface|\Illuminate\Database\Capsule\Manager
	 */		
	private static $resolver;

    /**
     * Constructor.
     *
     * @param  \Jiro\Extension\Container  $extensionContainer
     * @param  string  $slug
     * @param  string  $path
     * @param  array  $attributes
     * @param  string  $namespace
     * @param  \Illuminate\Cache\CacheManager  $cache
     * @return void
     */
    public function __construct(ExtensionContainer $extensionBag, $slug, $path, Array $attributes = [], $namespace = null, CacheManager $cache = null) 
    {

    }    

    /**
     * Returns the database migrator instance.
     *
     * @return \Illuminate\Database\Migrations\Migrator
     */
    public static function getMigrator()
    {
        return static::$migrator;
    }

    /**
     * Sets the database migrator instance.
     *
     * @param  \Illuminate\Database\Migrations\Migrator
     * @return void
     */
    public static function setMigrator(Migrator $migrator)
    {
        static::$migrator = $migrator;
    }

    /**
     * Returns the event dispatcher instance.
     *
     * @return \Illuminate\Events\Dispatcher
     */
    public static function getEventDispatcher()
    {
        return static::$dispatcher;
    }

    /**
     * Sets the event dispatcher instance.
     *
     * @param  \Illuminate\Events\Dispatcher
     * @return void
     */
    public static function setEventDispatcher(Dispatcher $dispatcher)
    {
        static::$dispatcher = $dispatcher;
    }

    /**
     * Returns the connection resolver instance.
     *
     * @return \Illuminate\Database\ConnectionResolverInterface|\Illuminate\Database\Capsule\Manager
     */
    public static function getConnectionResolver()
    {
        return static::$resolver;
    }

    /**
     * Sets the connection resolver instance.
     *
     * @param  \Illuminate\Database\ConnectionResolverInterface|\Illuminate\Database\Capsule\Manager  $resolver
     * @return void
     */
    public static function setConnectionResolver($resolver)
    {
        if ( ! $resolver instanceof ConnectionResolverInterface && ! $resolver instanceof Capsule)
        {
            throw new InvalidArgumentException('Invalid resolver. Resolver must be an instance of Illuminate\Database\ConnectionResolverInterface or Illuminate\Database\Capsule\Manager');
        }

        static::$resolver = $resolver;
    }   

    /**
     * Returns the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $array['attributes'] = $this->attributes;

        foreach ($array['attributes'] as $key => $value) {
            if ($value instanceof Closure) {
                unset($array['attributes'][$key]);
            }
        }

        $properties = array(
            'path',
            'slug',
            'booted',
            'namespace',
            'registered',
            'databaseAttributes',
        );

        foreach ($properties as $property) {
            $array[$property] = $this->$property;
        }

        return $array;
    }         
}