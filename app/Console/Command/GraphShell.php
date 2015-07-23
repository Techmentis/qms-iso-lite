<?php

App::import('Core', 'Controller');
App::import('Controller','histories');
App::uses('CtrlComponent', 'Controller/Component');
App::uses('CakeSession', 'Model/Datasource');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

 
class GraphShell extends AppShell {
   
 public $uses = array('Company'); 
    
    
    public function main() {
        
   
        $companies = $this->Company->find('all', array('conditions'=>array('Company.publish'=>1,'Company.soft_delete'=>0),'fields'=>'id','recursive'=>-1));
        foreach($companies as $company){
           
            $_ENV['company_id'] =  $company['Company']['id'];
            $this->out('Preparing data ... ');        
            $this->histories = new HistoriesController();        
            
            $this->histories->prepare_graph_data();
            $this->histories->_prepare_graph_data_departments(date('Y-m-d 00:00:00'), date('Y-m-d 59:59:59'));
            $this->histories->_prepare_graph_data_branches(date('Y-m-d 00:00:00'), date('Y-m-d 59:59:59'));        
            $this->histories->_prepare_graph_data_departmentwise();
            $this->histories->_prepare_graph_data_branchwise();
       }
    }
}
?>


