<?php
//exec('mysqldump --user=... --password=... --host=... DB_NAME > /path/to/output/file.sql');
//App::import('Core', 'Controller');
//App::import('Controller','histories');
//
//App::uses('CtrlComponent', 'Controller/Component');
//
//App::uses('Folder', 'Utility');
//App::uses('File', 'Utility');
//App::uses('ConnectionManager', 'Model');

App::import('Core', 'Controller');
App::import('Controller','histories');

App::uses('CtrlComponent', 'Controller/Component');

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');



class DBConnectionShell extends AppShell {
        public function main() {
            $this->histories = new HistoriesController();        
            $this->histories->db_backup();
          
           // $dataSource = ConnectionManager::getDataSource('default');
           //
           // $username = $dataSource->config['login'];
           // $password = $dataSource->config['password'];
           // $dbname = $dataSource->config['database'];
           // $date = date('d-m-Y');
           // $old_date = date('d-m-Y', strtotime('-7 day',strtotime($date)));
           // $fileName = WWW_ROOT.'dbbackup/'.$dbname .'_'. $date. '.sql';
           // if(file_exists(WWW_ROOT.'dbbackup/'.$dbname .'_'. $old_date. '.sql')){
           //     unlink(WWW_ROOT.'dbbackup/'.$dbname .'_'. $old_date. '.sql');
           // }
           // $dir = new Folder(WWW_ROOT.'dbbackup', true, 0777);
           //// echo 'mysqldump -u '.$username.' -p '.$password.' '.$dbname.' > ' .$fileName . '.sql';die;
           // if (exec('/usr/bin/mysqldump -u '.$username.' -p'.$password.' '.$dbname.' > ' .$fileName, $output)) {
           //     echo "Success";
           //     //$h=fopen($fileName, "w+");
           //     //fputs($h, $output);
           //     //fclose($h);
           // } else {
           //     echo "Failed";
           // }
           //// var_dump($output);
           //
           // $this->out('Preparing data ... ');        
        }
}
?>