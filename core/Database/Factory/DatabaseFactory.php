<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 21/04/19
 * Time: 00:10
 */

namespace Core\Database\Factory;

use Core\Database\MongoDB\MongoDB;
use Core\Database\MySQL\MySQL;
use Core\DependencyInjection\ContainerInterface;

class DatabaseFactory
{
    /**
     * @param ContainerInterface $container
     * @return mixed
     */
    public function getDatabaseManager(ContainerInterface $container)
    {
        // Defined in config/parameters.php
        /** @var array $database_parameters */
        switch ($database_parameters['manager']) {
            case 'mysql':
                $classToLoad = MySQL::class;
                break;
            case 'mongodb':
                $classToLoad = MongoDB::class;
                break;
            default:
                $classToLoad = MySQL::class;
        }

        return $container->get($classToLoad);
    }
}
