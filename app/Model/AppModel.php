<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    var $actsAs= array('WhoDidIt');
    /*public $belongsTo = array( 'ApprovedBy' => array('className' => 'Employee','foreignKey' => 'approved_by','conditions' => '','fields' => '', 'order' => '' ), 'PreparedBy' => array('className' => 'Employee', 'foreignKey' => 'prepared_by', 'conditions' => '', 'fields' => '', 'order' => '' ),
		'ApproveBy' => array(
			'className' => 'Employee',
			'foreignKey' => 'approved_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PreparedBy' => array(
			'className' => 'Employee',
			'foreignKey' => 'prepared_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
        );*/

    public function beforeFind($query){

        if(isset($query)){

            if(isset($_SESSION['User']) &&   $_SESSION['show_all_formats'] == false && array_key_exists('company_id',$this->schema()) && ($this->alias != 'Company'))
            {
                if(substr($_SERVER['REQUEST_URI'],-5) != 'login'){
                $query['conditions'] = array_merge(array($this->alias.'.company_id'=>$_SESSION['User']['company_id']),array($query['conditions']));
                return $query;


            }
            }
            if(isset($_ENV['company_id']) && $_ENV['company_id']!= null && array_key_exists('company_id',$this->schema()) && ($this->alias != 'Company'))
            {
                $query['conditions'] = array_merge(array($this->alias.'.company_id'=>$_ENV['company_id']),array($query['conditions']));
                return $query;


            }
        }
   }

}
