<?php

App::import('Core', 'Controller');
App::import('Controller','reports');

App::import('Vendor', 'PHPExcel', array(
    'file' => 'excel/PHPExcel.php'
));

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');


class ReportShell extends AppShell {
    
    
    
    public function main() {

        $this->reports = new ReportsController();
		$this->reports->_tni();
		$this->reports->_trainings();
		$this->reports->_summery_of_supplier_evaluations();
		$this->reports->_list_of_acceptable_suppliers();
		$this->reports->_daily_data_backups();
		$this->reports->_weekly_nc_report();
		$this->reports->_generate_daily_data_entry_report();
        
    }
}
/* "$HOME/html/app/vendors/cakeshell" report -cli "/web/cgi-bin/" -console  "$HOME/html/cake/console/" -app "$HOME/html/app/" */
?>


