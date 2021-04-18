<?php

spl_autoload_extensions( ".php" );
spl_autoload_register();

use controller\Router;
use model\Model;
use model\Auth;
use controller\IndexController;
use model\View;

$model = new Model();
$auth = new Auth($model);

session_start();

if ( isset( $_GET['logout'] ) ) {
	$auth->logout();
	header( 'Location: ' . $model->getPageUrl() );
}

switch ( isset( $_SESSION['ban'] ) ) {
	case ( true ):
		if ( $_SESSION['ban'] > time() - 300 ) {
			( new IndexController( $model ) )->actionBan();
			break;
		} else {
			unset( $_SESSION['ban'] );
		}

	default:
		if ( false === $auth->isAuthentificated() ) {

			$_SERVER['REQUEST_URI'] = 'sign/in';
			$model->setLayout( '401' );

			if ( isset( $_POST ) && ! empty( $_POST ) ) {

                if (!$auth->validLogData($_POST['login'], $_POST['password'])){
                    unset($_POST);
                } else
				if ((! $auth->tryToLogin())) {
                    $auth::setLogMessage( 'Неверные данные' );
					if ( ! isset( $_SESSION['count'] ) ) {
						$_SESSION['count'] = 1;
					} else {
						$_SESSION['count'] ++;
						if ( $_SESSION['count'] == 300 ) {
							unset( $_SESSION['count'] );
							$_SESSION['ban'] = time();
						}
					}
				} else {
					$model->setLayout( 'index' );
					if ( isset( $_SESSION['count'] ) ) {
						unset( $_SESSION['count'] );
					}
				}
			}
		}

		$router = new Router();

		if ( method_exists( $router->getController(), $router->getAction() ) ) {
			$controller = $router->getController();
			( new $controller( $model ) )->{$router->getAction()}();
			if ( $auth->isAuthentificated() && in_array( $model->getTemplate(), [ 'sign/in' ] ) ) {
				( new IndexController( $model ) )->actionIndex();
			}
		} else {
			( new IndexController( $model ) )->action404();
		}
}

try{
    ( new View( $model ) )->view();
} catch (Exception $e){
echo $e->getMessage();
}


