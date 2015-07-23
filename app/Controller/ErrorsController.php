<?php

class ErrorsController extends Controller {

    public $name = 'Errors';

    public function error500() {
        parent::beforeFilter();
        $this->layout = 'default';
    }

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function error404() {

    }

}

?>
