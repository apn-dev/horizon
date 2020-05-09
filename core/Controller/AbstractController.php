<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 28/02/18
 * Time: 15:38
 */

namespace Core\Controller;

use Core\Database\DatabaseInterface;
use Core\Database\Factory\DatabaseFactory;
use Core\DependencyInjection\Container;
use Core\DependencyInjection\ContainerInterface;
use Core\Templating\TemplateBuilder;

abstract class AbstractController implements ControllerInterface
{
    /* @var ContainerInterface */
    protected $container;

    /* @var DatabaseInterface */
    protected $databaseManager;

    public function __construct()
    {
        if (!$this->container) {
            $this->container = new Container();
        }

        $this->databaseManager = $this->container->get(DatabaseFactory::class)->getDatabaseManager($this->container);
    }

    public function render(string $view, $params = array())
    {
        return $this->container->get(TemplateBuilder::class)->render($view, $params);
    }
}
