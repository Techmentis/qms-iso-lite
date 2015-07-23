<?php

App::import('Core', 'Controller');
App::import('Controller','reports');

App::import('Vendor', 'PHPExcel', array(
    'file' => 'Excel/PHPExcel.php'
));

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class MonthlyReportShell extends AppShell {
    
     public $uses = array('Company'); 
    
    public function main() {

        $this->reports = new ReportsController();
	
	//Running Monthly Reports
	$companies = $this->Company->find('all', array('conditions'=>array('Company.publish'=>1,'Company.soft_delete'=>0),'fields'=>'id','recursive'=>-1));
        foreach($companies as $company){
           
            $_ENV['company_id'] =  $company['Company']['id'];
	    $successReport = $this->reports->generate_table_report('Monthly');
	    $successTask = $this->reports->generate_task_report('Monthly');
            if($successReport || $successTask){
                $this->reports->send_email('Monthly');
            }
	}

    }
}
/* "$HOME/html/demo-application/app/Console/cake" report -cli "/web/cgi-bin/" -console  "$HOME/html/demo-application/app/Console/" -app "$HOME/html/app/" */
/* "$HOME/html/demo-application/app/Console/cake" hello -cli "/web/cgi-bin/" -console  "$HOME/html/demo-application/app/Console/" -app "$HOME/html/app/" */
?>