<?php

App::import('Core', 'Controller');

App::import('Controller','reports');

App::import('Vendor', 'PHPExcel', array(
    'file' => 'Excel/PHPExcel.php'
));

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class WeeklyReportShell extends AppShell {
    
    public $uses = array('Company'); 
    
    public function main() {

        $this->reports = new ReportsController();
	
	//Running Weekly Reports
	$companies = $this->Company->find('all', array('conditions'=>array('Company.publish'=>1,'Company.soft_delete'=>0),'fields'=>'id','recursive'=>-1));
        foreach($companies as $company){
		$_ENV['company_id'] =  $company['Company']['id'];
		$Wsuccess = $this->reports->_weekly_nc_report();
		$WTsuccess = $this->reports->generate_table_report('Weekly');
		$Wtasksuccess = $this->reports->generate_task_report('Weekly');
		
                if($WTsuccess || $Wsuccess || $Wtasksuccess){
                    $this->reports->send_email('Weekly');
                }
                
	
	}	
	
		
		
        
    }
}
/* "$HOME/html/demo-application/app/Console/cake" report -cli "/web/cgi-bin/" -console  "$HOME/html/demo-application/app/Console/" -app "$HOME/html/app/" */
/* "$HOME/html/demo-application/app/Console/cake" hello -cli "/web/cgi-bin/" -console  "$HOME/html/demo-application/app/Console/" -app "$HOME/html/app/" */
?>