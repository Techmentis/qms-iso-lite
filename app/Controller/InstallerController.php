<?php
App::uses('ConnectionManager', 'Model');
set_time_limit(0);
class InstallerController extends AppController {
    var $name = 'Installer';
    var $uses = array();
    var $helpers = array('Html');

    function beforeFilter() {
        if (file_exists(APP.'Config/installed.txt')) {
            $this->Session->setFlash(__('Application is already installed.'), 'default', array('class'=>'alert-danger'));
            $this->redirect(array('controller'=>'users','action' => 'login'));
        }
    }
    function beforeRender(){

         
    }

    function index() {
        $this->layout = "login";
        if ($this->request->is('post') || $this->request->is('put')) {
	    if(isset($this->request->data['Installer']['prefix']) && $this->request->data['Installer']['prefix']!='')
		 $this->request->data['Installer']['prefix'] =  rtrim($this->request->data['Installer']['prefix'], '_').'_';
            $string = '<?php
                        /**
                         * This is core configuration file.
                         *
                         * Use it to configure core behaviour of Cake.
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
                         *
                         * Database configuration class.
                         * You can specify multiple configurations for production, development and testing.
                         *
                         * datasource => The name of a supported datasource; valid options are as follows:
                         *		Database/Mysql 		- MySQL 4 & 5,
                         *		Database/Sqlite		- SQLite (PHP5 only),
                         *		Database/Postgres	- PostgreSQL 7 and higher,
                         *		Database/Sqlserver	- Microsoft SQL Server 2005 and higher
                         *
                         * You can add custom database datasources (or override existing datasources) by adding the
                         * appropriate file to app/Model/Datasource/Database. Datasources should be named MyDatasource.php,
                         *
                         *
                         * persistent => true / false
                         * Determines whether or not the database should use a persistent connection
                         *
                         * host =>
                         * the host you connect to the database. To add a socket or port number, use port => #
                         *
                         * prefix =>
                         * Uses the given prefix for all the tables in this database. This setting can be overridden
                         * on a per-table basis with the Model::$tablePrefix property.
                         *
                         * schema =>
                         * For Postgres/Sqlserver specifies which schema you would like to use the tables in. Postgres defaults to public. For Sqlserver, it defaults to empty and use
                         * the connected users default schema (typically dbo).
                         *
                         * encoding =>
                         * For MySQL, Postgres specifies the character encoding to use when connecting to the
                         * database. Uses database default not specified.
                         *
                         * unix_socket =>
                         * For MySQL to connect via socket specify the `unix_socket` parameter instead of `host` and `port`
                         */
                                       
                                     
                        
                        class DATABASE_CONFIG {
                        
                                        public $default = array(
                                            "datasource" => "Database/Mysql",
                                            "persistent" => false,
                                            "host" => "'.$this->request->data['Installer']['host'].'",
                                            "login" => "'.$this->request->data['Installer']['login'].'",
                                            "password" => "'.$this->request->data['Installer']['password'].'",
                                            "database" => "'.$this->request->data['Installer']['database'].'",
                                            "prefix" => "'.$this->request->data['Installer']['prefix'].'",
                                            //"encoding" => "utf8",
                                        );
                                        
                                        public $test = array(
                                            "datasource" => "Database/Mysql",
                                            "persistent" => false,
                                            "host" => "localhost",
                                            "login" => "user",
                                            "password" => "password",
                                            "database" => "test_database_name",
                                            "prefix" => "",
                                            //"encoding" => "utf8",
                                        );
                                        
                                        }
                        ?>';
            $fp = fopen(APP."Config/database.php", "w");
            fwrite($fp, $string);
           // chmod(APP."Config/database.php", 0755);
            fclose($fp);
            $con = mysql_connect($this->request->data['Installer']['host'],
                   $this->request->data['Installer']['login'],
                   $this->request->data['Installer']['password']);
            if (!$con) {
                $this->Session->setFlash(__('Can not connect to mysql. Make sure username and password is correct.'), 'default', array('class'=>'alert-danger'));
                $this->redirect(array('action' => 'index'));
            }
             
            if (mysql_query("CREATE DATABASE ".$this->request->data['Installer']['database'], $con)) 
            { 
                $this->__writeCoreFile();
                $this->__database();
            } else {
               
                $this->Session->setFlash(__('Error creating database.'.mysql_error()), 'default', array('class'=>'alert-danger'));
                $this->redirect(array('action' => 'index'));
            }
        
        }
    }

    function __database() {
      
        $db = ConnectionManager::getDataSource('default');
        if(!$db->isConnected()) {
            $this->Session->setFlash(__('Could not connect to database. Please check the settings in app/config/database.php and try again.'), 'default', array('class'=>'alert-danger'));
            $this->redirect(array('action' => 'index'));
        }
        try {
                if(file_exists(WWW_ROOT.'DB'.DS.'flinkdem0.sql')){
                    $this->__executeSQLScript($db, WWW_ROOT.'DB'.DS.'flinkdem0.sql');
                }else{
                    $this->Session->setFlash(__('Databse file missing'), 'default', array('class'=>'alert-success'));
                    $this->redirect(array('controller'=>'users','action' => 'register'));
                }
            }catch (Exception $e) {
                $this->Session->setFlash(__('failed to add data' . json_encode($e)), 'default', array('class'=>'alert-success'));
                $this->redirect(array('controller'=>'installer','action' => 'index'));
            }
            if(isset($this->request->data['Installer']['prefix']) && !empty($this->request->data['Installer']['prefix'])){
               
                 $this->__addPrefixToTables($db);
            }

           
            file_put_contents(APP.'Config/installed_db.txt', date('Y-m-d, H:i:s'));
            $this->Session->setFlash(__('FlinkISO install successfully.'), 'default', array('class'=>'alert-success'));
            $this->redirect(array('controller'=>'users','action' => 'register'));
       
    }
		
  
		
    function __executeSQLScript($db, $fileName) {

        $statements = file_get_contents($fileName);
        $statements = explode('@#@', $statements);
        foreach ($statements as $statement) {
            if (trim($statement) != '') {
                $db->query($statement);
            }
        }
    }
    
    function __addPrefixToTables($db){
       
        $sql = "SHOW TABLES FROM `" . $this->request->data['Installer']['database'] . "`";
        $result = $db->query($sql);
        foreach($result as $row)
        {  
            $table_name = $row['TABLE_NAMES']['Tables_in_'.$this->request->data['Installer']['database']]; 
            $new_table_name =  $this->request->data['Installer']['prefix'] . $table_name;  
            
            $sql = "RENAME TABLE `" . $this->request->data['Installer']['database'] . "`.`" . $table_name . "`";  
            $sql .= " TO `" . $this->request->data['Installer']['database'] . "`.`" . $new_table_name . "`";  
            
            $result = $db->query($sql); 
          
        }
        
    }
    
    function __writeCoreFile(){
        $salt = $this->generateRandom(41);
        $cypherSeed = $this->generateRandom(29,1);
        $string = '<?php
        /**
         * This is core configuration file.
         *
         * Use it to configure core behavior of Cake.
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
         * CakePHP Debug Level:
         *
         * Production Mode:
         * 	0: No error messages, errors, or warnings shown. Flash messages redirect.
         *
         * Development Mode:
         * 	1: Errors and warnings shown, model caches refreshed, flash messages halted.
         * 	2: As in 1, but also with full debug messages and SQL output.
         *
         * In production mode, flash messages redirect after a time interval.
         * In development mode, you need to click the flash message to continue.
         */
                Configure::write("debug",0);
        
        /**
         * Configure the Error handler used to handle errors for your application. By default
         * ErrorHandler::handleError() is used. It will display errors using Debugger, when debug > 0
         * and log errors with CakeLog when debug = 0.
         *
         * Options:
         *
         * - `handler` - callback - The callback to handle errors. You can set this to any callable type,
         *   including anonymous functions.
         *   Make sure you add App::uses("MyHandler", "Error"); when using a custom handler class
         * - `level` - int - The level of errors you are interested in capturing.
         * - `trace` - boolean - Include stack traces for errors in log files.
         *
         * @see ErrorHandler for more information on error handling and configuration.
         */
                Configure::write("Error", array(
                        "handler" => "ErrorHandler::handleError",
                        "level" => E_ALL & ~E_DEPRECATED,
                        "trace" => true
                ));
        
        /**
         * Configure the Exception handler used for uncaught exceptions. By default,
         * ErrorHandler::handleException() is used. It will display a HTML page for the exception, and
         * while debug > 0, framework errors like Missing Controller will be displayed. When debug = 0,
         * framework errors will be coerced into generic HTTP errors.
         *
         * Options:
         *
         * - `handler` - callback - The callback to handle exceptions. You can set this to any callback type,
         *   including anonymous functions.
         *   Make sure you add App::uses("MyHandler", "Error"); when using a custom handler class
         * - `renderer` - string - The class responsible for rendering uncaught exceptions. If you choose a custom class you
         *   should place the file for that class in app/Lib/Error. This class needs to implement a render method.
         * - `log` - boolean - Should Exceptions be logged?
         *
         * @see ErrorHandler for more information on exception handling and configuration.
         */
                Configure::write("Exception", array(
                        "handler" => "ErrorHandler::handleException",
                        "renderer" => "ExceptionRenderer",
                        "log" => true
                ));
        
        /**
         * Application wide charset encoding
         */
                Configure::write("App.encoding", "UTF-8");
        
        /**
         * To configure CakePHP *not* to use mod_rewrite and to
         * use CakePHP pretty URLs, remove these .htaccess
         * files:
         *
         * /.htaccess
         * /app/.htaccess
         * /app/webroot/.htaccess
         *
         * And uncomment the App.baseUrl below. But keep in mind
         * that plugin assets such as images, CSS and Javascript files
         * will not work without url rewriting!
         * To work around this issue you should either symlink or copy
         * the plugin assets into you app"s webroot directory. This is
         * recommended even when you are using mod_rewrite. Handling static
         * assets through the Dispatcher is incredibly inefficient and
         * included primarily as a development convenience - and
         * thus not recommended for production applications.
         */
                //Configure::write("App.baseUrl", env("SCRIPT_NAME"));
        
        /**
         * Uncomment the define below to use CakePHP prefix routes.
         *
         * The value of the define determines the names of the routes
         * and their associated controller actions:
         *
         * Set to an array of prefixes you want to use in your application. Use for
         * admin or other prefixed routes.
         *
         * 	Routing.prefixes = array("admin", "manager");
         *
         * Enables:
         *	`admin_index()` and `/admin/controller/index`
         *	`manager_index()` and `/manager/controller/index`
         *
         */
        Configure::write("Routing.prefixes", array("admin"));
        
        /**
         * Turn off all caching application-wide.
         *
         */
                Configure::write("Cache.disable", true);
        
        /**
         * Enable cache checking.
         *
         * If set to true, for view caching you must still use the controller
         * public $cacheAction inside your controllers to define caching settings.
         * You can either set it controller-wide by setting public $cacheAction = true,
         * or in each action using $this->cacheAction = true.
         *
         */
                //Configure::write("Cache.check", true);
        
        /**
         * Enable cache view prefixes.
         *
         * If set it will be prepended to the cache name for view file caching. This is
         * helpful if you deploy the same application via multiple subdomains and languages,
         * for instance. Each version can then have its own view cache namespace.
         * Note: The final cache file name will then be `prefix_cachefilename`.
         */
                //Configure::write("Cache.viewPrefix", "prefix");
        
        /**
         * Session configuration.
         *
         * Contains an array of settings to use for session configuration. The defaults key is
         * used to define a default preset to use for sessions, any settings declared here will override
         * the settings of the default config.
         *
         * ## Options
         *
         * - `Session.cookie` - The name of the cookie to use. Defaults to "CAKEPHP"
         * - `Session.timeout` - The number of minutes you want sessions to live for. This timeout is handled by CakePHP
         * - `Session.cookieTimeout` - The number of minutes you want session cookies to live for.
         * - `Session.checkAgent` - Do you want the user agent to be checked when starting sessions? You might want to set the
         *    value to false, when dealing with older versions of IE, Chrome Frame or certain web-browsing devices and AJAX
         * - `Session.defaults` - The default configuration set to use as a basis for your session.
         *    There are four builtins: php, cake, cache, database.
         * - `Session.handler` - Can be used to enable a custom session handler. Expects an array of callables,
         *    that can be used with `session_save_handler`. Using this option will automatically add `session.save_handler`
         *    to the ini array.
         * - `Session.autoRegenerate` - Enabling this setting, turns on automatic renewal of sessions, and
         *    sessionids that change frequently. See CakeSession::$requestCountdown.
         * - `Session.ini` - An associative array of additional ini values to set.
         *
         * The built in defaults are:
         *
         * - "php" - Uses settings defined in your php.ini.
         * - "cake" - Saves session files in CakePHP"s /tmp directory.
         * - "database" - Uses CakePHP"s database sessions.
         * - "cache" - Use the Cache class to save sessions.
         *
         * To define a custom session handler, save it at /app/Model/Datasource/Session/<name>.php.
         * Make sure the class implements `CakeSessionHandlerInterface` and set Session.handler to <name>
         *
         * To use database sessions, run the app/Config/Schema/sessions.php schema using
         * the cake shell command: cake schema create Sessions
         *
         */
                Configure::write("Session", array(
                        "defaults" => "php",
                        "Session.timeout" => 20,
                        "Session.checkAgent"=>true
                ));
        
        /**
         * A random string used in security hashing methods.
         */
                Configure::write("Security.salt", "'.$salt.'");
        
        /**
         * A random numeric string (digits only) used to encrypt/decrypt strings.
         */
                Configure::write("Security.cipherSeed", "'.$cypherSeed.'");
        
        /**
         * Apply timestamps with the last modified time to static assets (js, css, images).
         * Will append a query string parameter containing the time the file was modified. This is
         * useful for invalidating browser caches.
         *
         * Set to `true` to apply timestamps when debug > 0. Set to "force" to always enable
         * timestamping regardless of debug value.
         */
                //Configure::write("Asset.timestamp", true);
        
        /**
         * Compress CSS output by removing comments, whitespace, repeating tags, etc.
         * This requires a/var/cache directory to be writable by the web server for caching.
         * and /vendors/csspp/csspp.php
         *
         * To use, prefix the CSS link URL with "/ccss/" instead of "/css/" or use HtmlHelper::css().
         */
                //Configure::write("Asset.filter.css", "css.php");
        
        /**
         * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
         * output, and setting the config below to the name of the script.
         *
         * To use, prefix your JavaScript link URLs with "/cjs/" instead of "/js/" or use JavaScriptHelper::link().
         */
                //Configure::write("Asset.filter.js", "custom_javascript_output_filter.php");
        
        /**
         * The class name and database used in CakePHP"s
         * access control lists.
         */
                Configure::write("Acl.classname", "DbAcl");
                Configure::write("Acl.database", "default");
        
        /**
         * Uncomment this line and correct your server timezone to fix
         * any date & time related errors.
         */
                date_default_timezone_set("Asia/Calcutta");
        
        /**
         *
         * Cache Engine Configuration
         * Default settings provided below
         *
         * File storage engine.
         *
         * 	 Cache::config("default", array(
         *		"engine" => "File", //[required]
         *		"duration" => 3600, //[optional]
         *		"probability" => 100, //[optional]
         * 		"path" => CACHE, //[optional] use system tmp directory - remember to use absolute path
         * 		"prefix" => "cake_", //[optional]  prefix every cache file with this string
         * 		"lock" => false, //[optional]  use file locking
         * 		"serialize" => true, [optional]
         *	));
         *
         * APC (http://pecl.php.net/package/APC)
         *
         * 	 Cache::config("default", array(
         *		"engine" => "Apc", //[required]
         *		"duration" => 3600, //[optional]
         *		"probability" => 100, //[optional]
         * 		"prefix" => Inflector::slug(APP_DIR) . "_", //[optional]  prefix every cache file with this string
         *	));
         *
         * Xcache (http://xcache.lighttpd.net/)
         *
         * 	 Cache::config("default", array(
         *		"engine" => "Xcache", //[required]
         *		"duration" => 3600, //[optional]
         *		"probability" => 100, //[optional]
         *		"prefix" => Inflector::slug(APP_DIR) . "_", //[optional] prefix every cache file with this string
         *		"user" => "user", //user from xcache.admin.user settings
         *		"password" => "password", //plaintext password (xcache.admin.pass)
         *	));
         *
         * Memcache (http://www.danga.com/memcached/)
         *
         * 	 Cache::config("default", array(
         *		"engine" => "Memcache", //[required]
         *		"duration" => 3600, //[optional]
         *		"probability" => 100, //[optional]
         * 		"prefix" => Inflector::slug(APP_DIR) . "_", //[optional]  prefix every cache file with this string
         * 		"servers" => array(
         * 			"127.0.0.1:11211" // localhost, default port 11211
         * 		), //[optional]
         * 		"persistent" => true, // [optional] set this to false for non-persistent connections
         * 		"compress" => false, // [optional] compress data in Memcache (slower, but uses less memory)
         *	));
         *
         *  Wincache (http://php.net/wincache)
         *
         * 	 Cache::config("default", array(
         *		"engine" => "Wincache", //[required]
         *		"duration" => 3600, //[optional]
         *		"probability" => 100, //[optional]
         *		"prefix" => Inflector::slug(APP_DIR) . "_", //[optional]  prefix every cache file with this string
         *	));
         */
        
        /**
         * Configure the cache handlers that CakePHP will use for internal
         * metadata like class maps, and model schema.
         *
         * By default File is used, but for improved performance you should use APC.
         *
         * Note: "default" and other application caches should be configured in app/Config/bootstrap.php.
         *       Please check the comments in bootstrap.php for more info on the cache engines available
         *       and their settings.
         */
        $engine = "File";
        
        // In development mode, caches should expire quickly.
        $duration = "+999 days";
        if (Configure::read("debug") > 0) {
                $duration = "+10 seconds";
        }
        
        // Prefix each application on the same server with a different string, to avoid Memcache and APC conflicts.
        $prefix = "myapp_";
        
        /**
         * Configure the cache used for general framework caching. Path information,
         * object listings, and translation cache files are stored with this configuration.
         */
        Cache::config("_cake_core_", array(
                "engine" => $engine,
                "prefix" => $prefix . "cake_core_",
                "path" => CACHE . "persistent" . DS,
                "serialize" => ($engine === "File"),
                "duration" => $duration
        ));
        
        /**
         * Configure the cache for model and datasource caches. This cache configuration
         * is used to store schema descriptions, and table listings in connections.
         */
        Cache::config("_cake_model_", array(
                "engine" => $engine,
                "prefix" => $prefix . "cake_model_",
                "path" => CACHE . "models" . DS,
                "serialize" => ($engine === "File"),
                "duration" => $duration
        ));
        
        Configure::write("MinifyAsset", true);
        
         /** 
         * Configure the default values for model user(regiter function) in flinkISO 
         */
        
         Configure::write("department", "MR");
         Configure::write("language", "English");
         Configure::write("designation", "Management Representative");
         
        ?>';

        $fp = fopen(APP."Config/core.php", "w");
        fwrite($fp, $string);
       // chmod(APP."Config/core.php", 0755);
        fclose($fp);
               
    }
    
    
    public function generateRandom($length = 10, $numeric = 0) {
            if($numeric == 1)
                $possible = '0123456789';
            else
                $possible = '0123456789abcdefghijklmnopqrstuvwxyz';
            
            $token = "";
            $i = 0;

            while ($i < $length) {
                    $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
                    $token .= $char;
                    $i++;
            }
            return $token;
    }
}
?>