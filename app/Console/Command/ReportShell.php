<?php

App::import('Core', 'Controller');

App::import('Controller','reports');
App::import('Controller','users');

App::import('Vendor', 'PHPExcel', array(
    'file' => 'Excel/PHPExcel.php'
));

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class ReportShell extends AppShell {
    
    public $uses = array('Company'); 
    
    public function main() {

        $this->reports = new ReportsController();
	
	// Running Daily Reports
	$companies = $this->Company->find('all', array('conditions'=>array('Company.publish'=>1,'Company.soft_delete'=>0),'fields'=>'id','recursive'=>-1));
        foreach($companies as $company){
           
            $_ENV['company_id'] =  $company['Company']['id'];
	    $var1 = $this->reports->_daily_data_backups();
	    $var2 = $this->reports->_generate_daily_data_entry_report();
            
	}   
        if($var1 || $var2){
            $this->reports->send_email('Daily');
	}    
//	$this->users = new UsersController();
//	$this->users->expiry_reminder(3);
//	$this->users->login_reminder();
		 
    }
}
/* "$HOME/html/demo-application/app/Console/cake" report -cli "/web/cgi-bin/" -console  "$HOME/html/demo-application/app/Console/" -app "$HOME/html/app/" */
/* "$HOME/html/demo-application/app/Console/cake" hello -cli "/web/cgi-bin/" -console  "$HOME/html/demo-application/app/Console/" -app "$HOME/html/app/" */
?>