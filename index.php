<?php

spl_autoload_extensions(".php");
spl_autoload_register();

use controller\Router;
use model\Model;
use model\Auth;
use controller\IndexController;
use model\View;

$model = new Model();
$auth = new Auth($model, 1);    //Если вместо 0 ввести 1, будут отображаться подсказки при неверном вводе логина и пароля

session_start();

if (isset($_GET['logout'])) {
    $auth->logout();
    header('Location: ' . $model->getPageUrl());
}

switch (isset($_SESSION['ban'])) {
    case (true):
        if ($_SESSION['ban'] > time() - 300) {
            (new IndexController($model))->actionBan();
            break;
        } else {
            unset($_SESSION['ban']);
        }

    default:
        if (!$auth->isAuthentificated()) {

            $_SERVER['REQUEST_URI'] = 'sign/in';
            $model->setLayout('401');

            if (isset($_POST) && !empty($_POST)) {
                try {
                    $auth->validateLogData($_POST['login'], $_POST['password']);
                    if (isset($_SESSION['count'])) {
                        unset($_SESSION['count']);
                    }
                } catch (Exception $e) {
                    $model->setMessage(['text' => $e->getMessage(), 'code' => $e->getCode()]);
                    if (!isset($_SESSION['count'])) {
                        $_SESSION['count'] = 1;
                    } else {
                        $_SESSION['count']++;
                        if ($_SESSION['count'] == 300) {
                            unset($_SESSION['count']);
                            $_SESSION['ban'] = time();
                        }
                    }
                }
            }
        }

        $router = new Router();

        if (method_exists($router->getController(), $router->getAction())) {
            $controller = $router->getController();
            (new $controller($model))->{$router->getAction()}();
            if ($auth->isAuthentificated() && in_array($model->getTemplate(), ['sign/in'])) {
                (new IndexController($model))->actionIndex();
            }
        } else {
            (new IndexController($model))->action404();
        }
}

try {
    (new View($model))->view();
} catch (Exception $e) {
    echo $e->getMessage();
}


