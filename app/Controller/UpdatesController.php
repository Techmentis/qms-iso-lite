<?php

App::uses('AppController', 'Controller');
App::uses('Xml', 'Utility');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::import('Vendor', 'FlxZipArchive', array(
    'file' => 'zip/zipClass.php'
));

/**
 * AppraisalQuestions Controller
 *
 * @property Upgrades $AppraisalQuestion
 */
class UpdatesController extends AppController {

    public function index(){
       
    }

    public function upgrade($last_update = null){
       
    }



}