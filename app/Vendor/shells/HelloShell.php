<?php

App::import('Core', 'Controller');
App::import('Controller','histories');


class HelloShell extends AppShell {
    
    
    
    public function main() {
        $this->out('Preparing data ... ');        
        $this->histories = new HistoriesController();
        
		$this->histories->data_entries();
		
        $this->histories->_prepare_graph_data();
        echo "graph data is ready ...
        
        ";
        $this->histories->_prepare_graph_data_departments();
        echo "department data is ready ...
        
        ";
        $this->histories->_prepare_graph_data_branches();
        echo "branch data is ready ...
        
        ";
        $this->histories->_prepare_graph_data_branchwise();
        echo "daily branch data is ready ...
        
        ";
        
        $this->histories->_prepare_graph_data_departmentwise();
        echo "daily branch data is ready ...
        
        ";
        echo "done !"; 
    }
}
?>


