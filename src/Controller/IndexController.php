<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 28/02/18
 * Time: 11:41
 */

namespace App\Controller;

use App\Model\Adress;
use App\Model\Person;
use Core\Controller\AbstractController;
use Core\DependencyInjection\Container;
use Core\Router\Router;

class IndexController extends AbstractController
{
    public function addRoutes(Router $router)
    {
        $router->get('/', self::class, 'indexAction');
        $router->get('/books/:id', self::class, 'booksAction');
        $router->get('/retrieveUser/:id', self::class, 'retrieveUser');
    }

    public function indexAction()
    {
        return $this->render('indexAction.php', array(
            'content' => 'Welcome to Horizon v1.0.0'
        ));
    }

    public function booksAction($id)
    {
        return $this->render('booksAction.php', array(
            'id' => $id
        ));
    }

    public function retrieveUser($id)
    {
        $user = $this->databaseManager->getTable('admin')->find($id);

        return $user;
    }
}
