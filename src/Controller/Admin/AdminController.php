<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 14/12/18
 * Time: 14:08
 */

namespace App\Controller\Admin;

use Core\Controller\AbstractController;
use Core\Form\Form;
use Core\Router\Router;

class AdminController extends AbstractController
{
    /**
     * @param Router $router
     * @throws \ReflectionException
     */
    public function addRoutes(Router $router)
    {
        $router->get('/admin', self::class, 'adminIndex');
        $router->post('/admin', self::class, 'adminConnection');
    }

    /**
     * @return false|string
     * @throws \ReflectionException
     */
    public function adminIndex()
    {
        $form = $this->container->get(Form::class);
        $form->createForm(["method" => "POST"]);
        $form
            ->addInput(['type' => 'text', 'name' => 'text'])
            ->addInput(['type' => 'password', 'name' => 'text'])
            ->addInput(['type' => "submit", 'name' => 'submit']);

        return $this->render("admin/connexion.php", [
            'form' => $form->renderForm()
        ]);
    }

    public function adminConnection()
    {
        dump($_POST);
    }
}
