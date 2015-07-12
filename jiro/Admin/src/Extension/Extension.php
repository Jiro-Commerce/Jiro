<?php namespace Jiro\Admin\Extension;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Contracts\Support\Arrayable;
use Jiro\Admin\Extension\ExtensionInterface;

/**
 * Manages the admin extension functionality
 *
 * @author Andrew McLagan <andrewmclagan@gmail.com>
 */

abstract class Extension implements Arrayable, Extensible
{
    /**
     * Event dispatcher instance.
     *
     * @var \Illuminate\Events\Dispacher
     */
    protected static $dispatcher;

    /**
     * Extension migrator.
     *
     * @var \Illuminate\Database\Migrations\Migrator
     */
    protected static $migrator;

    /**
     * Connection name for the extension.
     *
     * @var string
     */
    protected $connection;

    /**
     * Connection resolver instance.
     *
     * @var \Illuminate\Database\ConnectionResolverInterface|\Illuminate\Database\Capsule\Manager
     */
    protected static $resolver;    

    /**
     * Resolve a connection instance by name.
     *
     * @param  string  $connection
     * @return \Illuminate\Database\Connection
     */
    public static function resolveConnection($connection)
    {
        return static::$resolver->connection($connection);
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
     * Unsets the database migrator for models.
     *
     * @return void
     */
    public static function unsetMigrator()
    {
        static::$migrator = null;
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
     * Unsets the event dispatcher for models.
     *
     * @return void
     */
    public static function unsetEventDispatcher()
    {
        static::$dispatcher = null;
    }    

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {

    }      
}