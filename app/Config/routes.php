<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */

//echo TMP.'installed.txt'; die;
if (file_exists(APP.'Config/installed.txt')) {
    // the routes for when the application has been installed
    Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
    Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
    
}else if (file_exists(APP.'Config/installed_db.txt')) {
    // the routes for when the application has been db installed but user not registered
    Router::connect('/', array('controller' => 'users', 'action' => 'register'));
    Router::redirect('/', array('controller' => 'users', 'action' => 'register')); 
} else {
    
     // the routes for when the application has been ready but db not installed.
    Router::connect('/', array('controller' => 'installer', 'action' => 'index'));
    Router::redirect('/', array('controller' => 'installer', 'action' => 'index')); 
  
}

	//Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
        
        

