<?php
App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * Histories Controller
 *
 * @property History $History
 */
class HistoriesController extends AppController {
public $components = array('Ctrl');


public function _getSystemtableid()
{
    $this->loadModel('SystemTable');
    $this->SystemTable->recursive = -1;
    $sys_id = $this->SystemTable->find('first',array('conditions'=>array('SystemTable.system_name'=>$this->request->params['controller']))) ;
    return $sys_id['SystemTable']['id'];
}

/**
 * request handling by - TGS
 *
 */
/**
 * _check_request method
 *
 * @return void
 */

public $common_condition = array('OR'=>array('History.action'=>array('add','add_ajax'),
				array('History.model_name'=>array('CakeError','NotificationUser','History','UserSession','Page','Dashboard','Error',
								'NotificaionType','Approval','Benchmark','FileUpload','DataEntry','Help','MeetingBranch','MeetingDepartment',
								'MeetingEmployee','MeetingTopic','Message','NotificationUser','PurchaseOrderDetail','NotificationUser','PurchaseOrderDetail',
								'MasterListOfFormatBranch','MasterListOfFormatDepartment','MasterListOfFormatDistributor'),
				    'History.action <>' => 'delete',
				    'History.action <>' => 'soft_delete',
				    'History.action <>' => 'purge',
				    'History.post_values <>'=>'[[],[]]'
				    )));

public function _check_request(){

        $onlyBranch = null;
	$onlyOwn = null;
	$con1 = null;
	$con2 = null;

	if($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)$onlyBranch = array('History.branch_id'=>$this->Session->read('User.branch_id'));
	if($this->Session->read('User.is_view_all') == 0)$onlyOwn = array('History.created_by'=>$this->Session->read('User.id'));

        if($this->request->params['named']){
        if($this->request->params['named']['published']==null)$con1 = null ; else $con1 = array('History.publish'=>$this->request->params['named']['published']);
	if($this->request->params['named']['soft_delete']==null)$con2 = null ; else $con2 = array('History.soft_delete'=>$this->request->params['named']['soft_delete']);
	if($this->request->params['named']['soft_delete']==null)$conditions=array($onlyBranch,$onlyOwn,$con1,'History.soft_delete'=>0);
        else $conditions=array($onlyBranch,$onlyOwn,$con1,$con2);
	}else{
        $conditions=array($onlyBranch,$onlyOwn,null,'History.soft_delete'=>0);
        }

        return $conditions;
}

/**
 * request handling by - TGS
 * returns array of records created by user for branch , published / unpublished records & soft_deleted records
 */
/**
 * _get_count method
 *
 * @return void
 */

public function _get_count(){

        $onlyBranch = null;
	$onlyOwn = null;
	$condition = null;

	if($this->Session->read('User.is_mr') == 0)$onlyBranch = array('History.branch_id'=>$this->Session->read('User.branch_id'));
	if($this->Session->read('User.is_view_all') == 0)$onlyOwn = array('History.created_by'=>$this->Session->read('User.id'));
	$conditions = array($onlyBranch,$onlyOwn);

	$count = $this->History->find('count',array('conditions'=>$condition));
	$published = $this->History->find('count',array('conditions'=>array($condition,'History.publish'=>1,'History.soft_delete'=>0)));
	$unpublished = $this->History->find('count',array('conditions'=>array($condition,'History.publish'=>0,'History.soft_delete'=>0)));
	$deleted = $this->History->find('count',array('conditions'=>array($condition,'History.soft_delete'=>1)));
	$this->set(compact('count','published','unpublished','deleted'));
}


/**
 * index method
 *
 * @return void
 */
	public function index() {

		$conditions = $this->_check_request();
		$this->paginate = array('order'=>array('History.sr_no'=>'DESC'),'conditions'=>array($conditions));

		$this->History->recursive = 0;
		$this->set('histories', $this->paginate());

		$this->_get_count();
	}



/**
 * box layout by - TGS
 * box method
 *
 * @return void
 */
	public function box() {

		$conditions = $this->_check_request();
		$this->paginate = array('order'=>array('History.sr_no'=>'DESC'),'conditions'=>array($conditions));

		$this->History->recursive = 0;
		$this->set('histories', $this->paginate());

		$this->_get_count();
	}

/**
 * search method
 * Dynamic by - TGS
 * @return void
 */
	public function search() {


	$search_array = array();
		$search_keys = explode(" ",$this->request->data['History']['search']);

		foreach($search_keys as $search_key):
			foreach($this->request->data['History']['search_field'] as $search):
				$search_array[] = array('History.'.$search .' like' => '%'.$search_key.'%');
			endforeach;
		endforeach;

		if($this->Session->read('User.is_mr') == 0)
			{
				$cons = array('History.branch_id'=>$this->Session->read('User.branch_id'));
			}

		$this->History->recursive = 0;
		$this->paginate = array('order'=>array('History.sr_no'=>'DESC'),'conditions'=>array('or'=>$search_array , 'History.soft_delete'=>0 , $cons));
		$this->set('histories', $this->paginate());
                $this->render('index');

	}

/**
 * adcanced_search method
 * Advanced search by - TGS
 * @return void
 */
	public function advanced_search() {

		$conditions = array();
			if($this->request->data['Search']['keywords']){
				$search_array = array();
				$search_keys = explode(" ",$this->request->data['Search']['keywords']);

				foreach($search_keys as $search_key):
					foreach($this->request->data['Search']['search_fields'] as $search):
					if($this->request->data['Search']['strict_search'] == 0)$search_array[] = array('History.'.$search => $search_key);
					else $search_array[] = array('History.'.$search.' like ' => '%'.$search_key.'%');

					endforeach;
				endforeach;
				if($this->request->data['Search']['strict_search']==0)$conditions[] = array('and'=>$search_array);
				else $conditions[] = array('or'=>$search_array);
			}

		if($this->request->data['Search']['branch_list']){
			foreach($this->request->data['Search']['branch_list'] as $branches):
				$branch_conditions[]=array('History.branch_id'=>$branches);
			endforeach;
			$conditions[]=array('or'=>$branch_conditions);
		}

		if(!$this->request->data['Search']['to-date'])$this->request->data['Search']['to-date'] = date('Y-m-d');
		if($this->request->data['Search']['from-date']){
			$conditions[] = array('History.created >'=>date('Y-m-d h:i:s',strtotime($this->request->data['Search']['from-date'])),'History.created <'=>date('Y-m-d h:i:s',strtotime($this->request->data['Search']['to-date'])));
		}
		unset($this->request->data['Search']);


		if($this->Session->read('User.is_mr') == 0)$onlyBranch = array('History.branch_id'=>$this->Session->read('User.branch_id'));
		if($this->Session->read('User.is_view_all') == 0)$onlyOwn = array('History.created_by'=>$this->Session->read('User.id'));
		$conditions[] = array($onlyBranch,$onlyOwn);

		$this->History->recursive = 0;
		$this->paginate = array('order'=>array('History.sr_no'=>'DESC'),'conditions'=>$conditions , 'History.soft_delete'=>0 );
		$this->set('histories', $this->paginate());

	$this->render('index');

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->History->exists($id)) {
			throw new NotFoundException(__('Invalid history'));
		}
		$options = array('conditions' => array('History.' . $this->History->primaryKey => $id));
		$this->set('history', $this->History->find('first', $options));
	}



/**
 * list method
 *
 * @return void
 */
	public function lists() {

        $this->_get_count();

	}


/**
 * add_ajax method
 *
 * @return void
 */
	public function add_ajax() {

		if($this->_show_approvals()){
			$this->loadModel('User');
			$this->User->recursive = 0;
			$userids = $this->User->find('list',array('order'=>array('User.name'=>'ASC'),'conditions'=>array('User.publish'=>1,'User.soft_delete'=>0)));
			$this->set(array('userids'=>$userids,'show_approvals'=>$this->_show_approvals()));
		}

		if ($this->request->is('post')) {
                        $this->request->data['History']['system_table_id'] = $this->_getSystemtableid();
			$this->History->create();
			if ($this->History->save($this->request->data)) {

				if($this->_show_approvals()){
					$this->loadModel('Approval');
					$this->Approval->create();
					$this->request->data['Approval']['model_name']='History';
					$this->request->data['Approval']['controller_name']=$this->request->params['controller'];
					$this->request->data['Approval']['user_id']=$this->request->data['Approval']['user_id'];
					$this->request->data['Approval']['from']=$this->Session->read('User.id');
					$this->request->data['Approval']['created_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['modified_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['record']=$this->History->id;
					$this->Approval->save($this->request->data['Approval']);
				}
				$this->Session->setFlash(__('The history has been saved'));
				if($this->_show_evidence() == true)$this->redirect(array('action' => 'view',$this->History->id));
				else $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The history could not be saved. Please, try again.'));
			}
		}
		$userSessions = $this->History->UserSession->find('list',array('conditions'=>array('UserSession.publish'=>1,'UserSession.soft_delete'=>0)));
		$systemTables = $this->History->SystemTable->find('list',array('conditions'=>array('SystemTable.publish'=>1,'SystemTable.soft_delete'=>0)));
		$masterListOfFormats = $this->History->MasterListOfFormat->find('list',array('conditions'=>array('MasterListOfFormat.publish'=>1,'MasterListOfFormat.soft_delete'=>0)));
		$this->set(compact('userSessions', 'systemTables', 'masterListOfFormats'));
		$count = $this->History->find('count');
		$published = $this->History->find('count',array('conditions'=>array('History.publish'=>1)));
		$unpublished = $this->History->find('count',array('conditions'=>array('History.publish'=>0)));
		$this->set(compact('count','published','unpublished'));

	}





/**
 * add method
 *
 * @return void
 */
	public function add() {

		if($this->_show_approvals()){
			$this->loadModel('User');
			$this->User->recursive = 0;
			$userids = $this->User->find('list',array('order'=>array('User.name'=>'ASC'),'conditions'=>array('User.publish'=>1,'User.soft_delete'=>0,'User.is_approvar'=>1)));
			$this->set(array('userids'=>$userids,'show_approvals'=>$this->_show_approvals()));
		}

		if ($this->request->is('post')) {
                        $this->request->data['History']['system_table_id'] = $this->_getSystemtableid();
			$this->History->create();
			if ($this->History->save($this->request->data)) {

				if($this->_show_approvals()){
					$this->loadModel('Approval');
					$this->Approval->create();
					$this->request->data['Approval']['model_name']='History';
					$this->request->data['Approval']['controller_name']=$this->request->params['controller'];
					$this->request->data['Approval']['user_id']=$this->request->data['Approval']['user_id'];
					$this->request->data['Approval']['from']=$this->Session->read('User.id');
					$this->request->data['Approval']['created_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['modified_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['record']=$this->History->id;
					$this->Approval->save($this->request->data['Approval']);
				}
				$this->Session->setFlash(__('The history has been saved'));
				if($this->_show_evidence() == true)$this->redirect(array('action' => 'view',$this->History->id));
				else $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The history could not be saved. Please, try again.'));
			}
		}
		$userSessions = $this->History->UserSession->find('list',array('conditions'=>array('UserSession.publish'=>1,'UserSession.soft_delete'=>0)));
		$systemTables = $this->History->SystemTable->find('list',array('conditions'=>array('SystemTable.publish'=>1,'SystemTable.soft_delete'=>0)));
		$masterListOfFormats = $this->History->MasterListOfFormat->find('list',array('conditions'=>array('MasterListOfFormat.publish'=>1,'MasterListOfFormat.soft_delete'=>0)));
				$this->set(compact('userSessions', 'systemTables', 'masterListOfFormats'));
	$count = $this->History->find('count');
	$published = $this->History->find('count',array('conditions'=>array('History.publish'=>1)));
	$unpublished = $this->History->find('count',array('conditions'=>array('History.publish'=>0)));

	$this->set(compact('count','published','unpublished'));

	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->History->exists($id)) {
			throw new NotFoundException(__('Invalid history'));
		}
		if($this->_show_approvals()){
			$this->loadModel('User');
			$this->User->recursive = 0;
			$userids = $this->User->find('list',array('order'=>array('User.name'=>'ASC'),'conditions'=>array('User.publish'=>1,'User.soft_delete'=>0)));
			$this->set(array('userids'=>$userids,'show_approvals'=>$this->_show_approvals()));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                        $this->request->data['History']['system_table_id'] = $this->_getSystemtableid();
			if ($this->History->save($this->request->data)) {
				if($this->_show_approvals()){
					$this->loadModel('Approval');
					$this->Approval->create();
					$this->request->data['Approval']['model_name']='History';
					$this->request->data['Approval']['controller_name']=$this->request->params['controller'];
					$this->request->data['Approval']['from']=$this->Session->read('User.id');
					$this->request->data['Approval']['user_id']=$this->request->data['Approval']['user_id'];
					$this->request->data['Approval']['created_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['modified_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['record']=$this->History->id;
					$this->Approval->save($this->request->data['Approval']);
				}
				$this->Session->setFlash(__('The history has been saved'));
				if($this->_show_evidence() == true)$this->redirect(array('action' => 'view',$id));
				else $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The history could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('History.' . $this->History->primaryKey => $id));
			$this->request->data = $this->History->find('first', $options);
		}
		$userSessions = $this->History->UserSession->find('list',array('conditions'=>array('UserSession.publish'=>1,'UserSession.soft_delete'=>0)));
		$systemTables = $this->History->SystemTable->find('list',array('conditions'=>array('SystemTable.publish'=>1,'SystemTable.soft_delete'=>0)));
		$masterListOfFormats = $this->History->MasterListOfFormat->find('list',array('conditions'=>array('MasterListOfFormat.publish'=>1,'MasterListOfFormat.soft_delete'=>0)));
		$this->set(compact('userSessions', 'systemTables', 'masterListOfFormats'));
		$count = $this->History->find('count');
		$published = $this->History->find('count',array('conditions'=>array('History.publish'=>1)));
		$unpublished = $this->History->find('count',array('conditions'=>array('History.publish'=>0)));

		$this->set(compact('count','published','unpublished'));
	}

/**
 * approve method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function approve($id = null, $approval_id = null) {
		if (!$this->History->exists($id)) {
			throw new NotFoundException(__('Invalid history'));
		}

		$this->loadModel('Approval');
		if (!$this->Approval->exists($approval_id)) {
			throw new NotFoundException(__('Invalid approval id'));
		}

		$approval = $this->Approval->read(null,$approval_id);
		$this->set('same',$approval['Approval']['user_id']);

		//$approval_history = $this->Approval->find('all',array('order'=>array('Approval.sr_no'=>'DESC'),'conditions'=>array('Approval.model_name'=>'History','Approval.record'=>$id)));
		//$this->set(compact('approval_history'));

		if($this->_show_approvals()){
			$this->loadModel('User');
			$this->User->recursive = 0;
			$userids = $this->User->find('list',array('order'=>array('User.name'=>'ASC'),'conditions'=>array('User.publish'=>1,'User.soft_delete'=>0)));
			$this->set(array('userids'=>$userids,'show_approvals'=>$this->_show_approvals()));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->History->save($this->request->data)) {
				if($this->request->data['History']['publish'] == 0 && $this->_show_approvals()){
					$this->loadModel('Approval');
					$this->Approval->create();
					$this->request->data['Approval']['model_name']='History';
					$this->request->data['Approval']['controller_name']=$this->request->params['controller'];
					$this->request->data['Approval']['from']=$this->Session->read('User.id');
					$this->request->data['Approval']['user_id']=$this->request->data['Approval']['user_id'];
					$this->request->data['Approval']['created_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['modified_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['record']=$this->History->id;
					$this->Approval->save($this->request->data['Approval']);

					$this->Session->setFlash(__('The history has been saved'));
					}else{
					$this->Approval->read(null, $approval_id);
					$data['Approval']['status'] = 'Approved';
					$data['Approval']['modified_by'] = $this->Session->read('User.id');
					$this->Approval->save($data);
					$this->Session->setFlash(__('The branch has been published'));
					}
                                         $this->redirect(array('controller'=>'users', 'action'=>'dashboard'));

			} else {
				$this->Session->setFlash(__('The history could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('History.' . $this->History->primaryKey => $id));
			$this->request->data = $this->History->find('first', $options);
		}
		$userSessions = $this->History->UserSession->find('list',array('conditions'=>array('UserSession.publish'=>1,'UserSession.soft_delete'=>0)));
		$systemTables = $this->History->SystemTable->find('list',array('conditions'=>array('SystemTable.publish'=>1,'SystemTable.soft_delete'=>0)));
		$masterListOfFormats = $this->History->MasterListOfFormat->find('list',array('conditions'=>array('MasterListOfFormat.publish'=>1,'MasterListOfFormat.soft_delete'=>0)));
		$this->set(compact('userSessions', 'systemTables', 'masterListOfFormats'));
		$count = $this->History->find('count');
		$published = $this->History->find('count',array('conditions'=>array('History.publish'=>1)));
		$unpublished = $this->History->find('count',array('conditions'=>array('History.publish'=>0)));

		$this->set(compact('count','published','unpublished'));
	}



       /**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {

            $model_name = $this->modelClass;
            if(!empty($id)){

            $data['id'] = $id;
            $data['soft_delete'] = 1;
            $model_name=$this->modelClass;
            $this->$model_name->save($data);
    }
    $this->redirect(array('action' => 'index'));


}




	public function report(){

		$result = explode('+',$this->request->data['histories']['rec_selected']);
		$this->History->recursive = 1;
		$histories = $this->History->find('all',array('History.publish'=>1,'History.soft_delete'=>1,'conditions'=>array('or'=>array('History.id'=>$result))));
		$this->set('histories', $histories);

		$userSessions = $this->History->UserSession->find('list',array('conditions'=>array('UserSession.publish'=>1,'UserSession.soft_delete'=>0)));
		$systemTables = $this->History->SystemTable->find('list',array('conditions'=>array('SystemTable.publish'=>1,'SystemTable.soft_delete'=>0)));
		$masterListOfFormats = $this->History->MasterListOfFormat->find('list',array('conditions'=>array('MasterListOfFormat.publish'=>1,'MasterListOfFormat.soft_delete'=>0)));
		$this->set(compact('userSessions', 'systemTables', 'masterListOfFormats', 'userSessions', 'systemTables', 'masterListOfFormats'));
}


	public function prepare_graph_datas($startDate = null, $endDate=null){

		//get benchmark agevare
		$this->loadModel('Benchmark');
		$agg_benchmarks = $this->Benchmark->find('all',array('conditions'=>array('Benchmark.publish'=>1,'Benchmark.soft_delete'=>0)));
		$i = 0;
		$b = 0;
		foreach($agg_benchmarks as $benchmark):
		    $b = $b + $benchmark['Benchmark']['benchmark'];
		$i++;
		endforeach;
		$benchmark = round($b/$i);


		$this->loadModel('History');
		App::import('HtmlHelper', 'View/Helper');

		$this->layout = "ajax";

		    if(!$startDate)$startDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'asc')));
		    if(!$endDate)$endDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'desc')));
		    $date = date("Y-m-d",strtotime($startDate['History']['created']));
		    $end_date = date("Y-m-d",strtotime($endDate['History']['created']));

		    while (strtotime($date) <= strtotime($end_date)) {
			    $count = 0;

			    $count1 = $this->History->find('count',array('conditions'=>array(
								$this->common_condition,'History.created BETWEEN ? AND ?'=> array(date('Y-m-d 00:00:00',strtotime($date)),date ("Y-m-d", strtotime("+1 day", strtotime($date)))))));


			    $count2 = $this->History->find('count',array('conditions'=>array(
								'History.action'=>'delete','History.action'=>'purge',
								'History.model_name <>'=>'CakeError',
								'History.model_name <>'=>'NotificationUsers',
								'History.created BETWEEN ? AND ?'=> array(date('Y-m-d 00:00:00',strtotime($date)),date ("Y-m-d", strtotime("+1 day", strtotime($date)))))));

			    $count = $count1-$count2;
			    if($count > 0)$output[] = array('count'=>$count,'date'=>$date);
			    $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

		    }
		   //  echo $output;

		            $data = "[['Date','Records','Data Entry Benchmark'],";
			    foreach($output as $graph_data):
				    $data .= "['".date('d-m-Y',strtotime($graph_data['date']))."',".$graph_data['count'].",".$benchmark."],";
			    endforeach;
			    $data .= "]]";
			    $data = str_replace("],]]","]]",$data);


			    $file = fopen(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/graph_data.txt","w") or die ('can not open file') ;
			    fwrite($file,$data);
			    fclose($file);
		//}
	}

	public function graph_data_departments($newDate = null){
	    ini_set('memory_limit', '64M');
            if($newDate == null)$newDate = date('Y-m-d');
	    $tempDate = strtotime($newDate);
            //Will be use in future for auto generate reports
            //if(!file_exists(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$newDate. DS . 'departments' . DS . "graph_data_departments.txt"))
            //    $this->prepare_graph_data_departments(date('Y-m-d 00:00:00', $tempDate), date('Y-m-d 59:59:59', $tempDate));

	   // $folder = new Folder();
	  //  $folder->create(WWW_ROOT. "files". DS .$this->Session->read('User.company_id'). DS ."graphs". DS . date('Y-m-d'));
          if(file_exists(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$newDate. "/graph_data_departments.txt"))
                 $file = new File(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$newDate. "/graph_data_departments.txt");
          if(isset($file)){
		    $data = $file->read();
		    $this->set('departmentData',$data);
		}else{
		    $data = false;
		    return $data;
		}
	}

	public function prepare_graph_data_departments($startDate = null, $endDate=null){
		$this->loadModel('Benchmark');
		$this->layout = "ajax";

                $departments = $this->_get_department_list();
		foreach($departments as $key => $value):
                    $get_avg=$this->Benchmark->find('all',array('conditions'=>array('Benchmark.department_id'=>$key)));
                    $avgs = 0;
                    foreach($get_avg as $avg):
                        $avgs = $avgs + $avg['Benchmark']['benchmark'];
                    endforeach;
                    $count = 0;
                    $count = $this->History->find('count',array('conditions'=>array(
                    $this->common_condition,
                    'History.created between ? and ? ' => array($startDate,$endDate),
                    'History.departmentid'=>$key)));

                    $output[] = array('count'=>$count,'department'=>$value,'benchmark'=>$avgs);
		endforeach;

		$department_data = "[['department','Records','Data Entry Benchmark'],";
		foreach($output as $graph_data):
			$department_data .= "['".$graph_data['department']."',".$graph_data['count'].",".$graph_data['benchmark']."],";
		endforeach;
		$department_data .= "]]";
		$department_data = str_replace("],]]","]]",$department_data);

		$folder = new Folder();
		if(isset($_ENV['company_id']) && $_ENV['company_id']!= null){
			$folder->create(WWW_ROOT. "files". DS .$_ENV['company_id']. DS ."graphs". DS . date('Y-m-d'));

			$file = fopen(WWW_ROOT."files/".$_ENV['company_id']."/graphs/".str_replace(' 00:00:00', '',$startDate)."/graph_data_departments.txt","w") or die ('can not open file') ;
			fwrite($file,$department_data);
			fclose($file);

			$file = fopen(WWW_ROOT."files/".$_ENV['company_id']."/graphs/".str_replace(' 00:00:00', '',$startDate)."/graph_data_departments_total.txt","w") or die ('can not open file') ;
			fwrite($file,json_encode($output));
			fclose($file);
		}else{
			$folder->create(WWW_ROOT. "files". DS .$this->Session->read('User.company_id'). DS ."graphs". DS . date('Y-m-d'));

			$file = fopen(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".str_replace(' 00:00:00', '',$startDate)."/graph_data_departments.txt","w") or die ('can not open file') ;
			fwrite($file,$department_data);
			fclose($file);

			$file = fopen(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".str_replace(' 00:00:00', '',$startDate)."/graph_data_departments_total.txt","w") or die ('can not open file') ;
			fwrite($file,json_encode($output));
			fclose($file);

		}


	}

	public function graph_data_branches($newDate = null){
	    ini_set('memory_limit', '64M');
            if($newDate == null)$newDate = date('Y-m-d');
            $tempDate = strtotime($newDate);
            //Will be use in future for auto generate reports
            // if(!file_exists(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$newDate."/graph_data_branches.txt") && $newDate != date('Y-m-d'))
            //    $this->prepare_graph_data_branches(date('Y-m-d 00:00:00', $tempDate), date('Y-m-d 59:59:59', $tempDate));

            if(file_exists(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$newDate."/graph_data_branches.txt") && $newDate != date('Y-m-d'))
                 $file = new File(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$newDate."/graph_data_branches.txt");
             
            if(isset($file)){
		    $data = $file->read();
		    $this->set('branch_data',$data);
		}else{
		    $data = false;
		    return $data;
		}
	}

	public function prepare_graph_data_branches($startDate = null, $endDate=null){

            $startDate = date('Y-m-d 00:00:00',  strtotime($startDate));
            $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
            $this->layout = "ajax";
            $this->loadModel('Benchmark');
            $branches = $this->_get_branch_list();
	    foreach($branches as $key => $value):
		$get_avg=$this->Benchmark->find('all',array('conditions'=>array('Benchmark.branch_id'=>$key)));
		$avgs = 0;
		$count = 0;
		foreach($get_avg as $avg):
                    $avgs = $avgs + $avg['Benchmark']['benchmark'];
		endforeach;
                $cons = array($this->common_condition,'History.created between ? And ? ' => array($startDate, $endDate),
                                'History.branchid'=>$key);
		$count = $this->History->find('count',array('conditions'=>$cons));

		/*$count = $this->History->find('count',array('conditions'=>array(
									'or'=>array('History.action'=>'add','History.action'=>'add_ajax'),
									'History.created >'=>$date.":00:00:000",'History.created < '=>$end_date.":23:59:000",'History.branchid'=>$key
									)));*/
		$output[] = array('count'=>$count,'branch'=>$value,'benchmark'=>$avgs);
	    endforeach;
            $branch_data = "[['branch','Records','Data Entry Benchmark'],";
            foreach($output as $graph_data):
		$branch_data .= "['".$graph_data['branch']."',".$graph_data['count'].",".$graph_data['benchmark']."],";
            endforeach;
            $branch_data .= "]]";
            $branch_data = str_replace("],]]","]]",$branch_data);
            $folder = new Folder();
            if(isset($_ENV['company_id']) && $_ENV['company_id']!= null){	
                $folder->create(WWW_ROOT. "files". DS .$_ENV['company_id']. DS ."graphs". DS . str_replace(' 00:00:00', '',$startDate));
                $file = fopen(WWW_ROOT."files/".$_ENV['company_id']."/graphs/".str_replace(' 00:00:00', '',$startDate)."/graph_data_branches.txt","w") or die ('can not open file') ;
                fwrite($file,$branch_data);
                fclose($file);
		$file = fopen(WWW_ROOT."files/".$_ENV['company_id']."/graphs/".str_replace(' 00:00:00', '',$startDate)."/graph_data_branches_total.txt","w") or die ('can not open file') ;
		fwrite($file,json_encode($output));
		fclose($file);
            }else{
                $folder->create(WWW_ROOT. "files". DS .$this->Session->read('User.company_id'). DS ."graphs". DS . str_replace(' 00:00:00', '',$startDate));
                $file = fopen(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".str_replace(' 00:00:00', '',$startDate)."/graph_data_branches.txt","w") or die ('can not open file') ;
		fwrite($file,$branch_data);
		fclose($file);
                $file = fopen(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".str_replace(' 00:00:00', '',$startDate)."/graph_data_branches_total.txt","w") or die ('can not open file') ;
		fwrite($file,json_encode($output));
		fclose($file);

		}

	}

	public function graph_data($newDate = null ,$type = null, $id = null){
            ini_set('memory_limit', '64M');
	    if(isset($this->request->params['pass'][0]))$date = $this->request->params['pass'][0];
	    else $date = date('Y-m-d');

	    if($type){
		if($type == 'Branch'){
		    $this->graph_data_branchwise($id,$newDate);
		}elseif($type == 'Department'){
		    $this->graph_data_departmentwise($id,$newDate);
		}
	    }
	    else{

                if(!file_exists(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$date."/graph_data.txt"))
                     $this->prepare_graph_data();

		$file = new File(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$date."/graph_data.txt");
		if($file){
		    $data = $file->read();
                    if($data == "[['Date','Records','Data Entry Benchmark']]")$data = false;
		    $this->set('data',$data);
		}else{
		    $data = false;
		    return $data;
		}
	    }
	}

	public function graph_data_branchwise($branchid,$newDate){
            if(file_exists(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$newDate."/branches/".$branchid."/".$branchid.".txt"))
                $file = new File(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$newDate."/branches/".$branchid."/".$branchid.".txt");
	    if(isset($file)){
		    $data = $file->read();
                    if($data == "[['Date','Records','Data Entry Benchmark']]")$data = false;
		    $this->set('data',$data);
		}else{
		    $data = false;
		    return $data;
		}
	}

	public function graph_data_departmentwise($departmentid,$newDate){
            if(file_exists(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$newDate."/departments/".$departmentid."/".$departmentid.".txt"))
                 $file = new File(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$newDate."/departments/".$departmentid."/".$departmentid.".txt");
	    if(isset($file)){
		    $data = $file->read();
                    if($data == "[['Date','Records','Data Entry Benchmark']]")$data = false;
		    $this->set('data',$data);
		}else{
		    $data = false;
		    return $data;
		}
	}

        public function deptwisegraph(){
            $departments = $this->_get_department_list();
            $total = null;
            $startDate = null;//date('Y-m-d 00:00:00');
            $endDate = null;//date('Y-m-d 59:59:59');
            foreach($departments as $dept_key => $dept_value):
                $this->prepare_graph_data_branchwise(null,null,null,$dept_key);
            endforeach;
            exit();           
        }
       
        public function branchwise_guage($newDate = null){
            $branches = $this->_get_branch_list();
            $record_found =0;
            foreach($branches as $key=>$val):
                $file = new File(WWW_ROOT . DS . "files" . DS . $this->Session->read('User.company_id') . DS . "graphs" . DS . $newDate . DS . "branches" . DS . $key . DS . "gauge" . DS . $key . ".txt");
                if(file_exists($file->path)){
                   $record_found =1;
                   break;
                }
            endforeach;
            $this->set(compact('newDate','record_found'));
        }


        public function prepare_graph_data_branchwise($startDate = null, $endDate=null, $total= null, $dept_key = null, $total_for_gauge = null){
        $this->loadModel('Benchmark');
        $branch_benchmark = 0;
        $branch_count = 0;
        $department_benchmark = 0;
        $data = null;
        $branches = $this->_get_branch_list();
        foreach($branches as $b_key => $b_value):
            $data = null;
            $branch_count++;
            $benchmark = array();
            
                $output = array();
                if($startDate == null && $endDate == null){
                    $startDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'asc')));
                    $endDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'desc')));
                    $date = date("Y-m-d",strtotime($startDate['History']['created']));
                    $end_date = date("Y-m-d",strtotime($endDate['History']['created']));
                    $fileDate = date("Y-m-d");
                }else{
                    $date = date("Y-m-d",  strtotime($startDate));
                    $end_date = date("Y-m-d",  strtotime($endDate));
                    $fileDate = date("Y-m-d",  strtotime($startDate));
                }
                
                $total_for_gauge = 0;
                $total = 0;
                $date_count = 0;
                $get_avg=$this->Benchmark->find('all',array('conditions'=>array('Benchmark.branch_id'=>$b_key)));
                $avgs = 0;
		$count = 0;
		foreach($get_avg as $avg):
                    $avgs = $avgs + $avg['Benchmark']['benchmark'];
                $count++;
		endforeach;
                $avgs = $avgs/$count;
                while (strtotime($date) <= strtotime($end_date))
                {
                    $cons = array($this->common_condition,'History.created between ? And ? ' => array($date." 00:00:00",$date." 23:59:00"),'History.branchid'=>$b_key);
                    $count = $this->History->find('count',array('conditions'=>$cons));
		    $output[] = array('count'=>$count,'date'=>$date);
		    $total = $total + $count;
		    $date_count++;
		    $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                $data = null;
                $data = "[['Date','Records','Data Entry Benchmark'],";
                foreach($output as $graph_data):
                        if($graph_data['count'] > 0)$data .= "['".date('d-m-Y',strtotime($graph_data['date']))."',".$graph_data['count'].",10],";
                endforeach;
                $data .= "]]";
                $data = str_replace("],]]","]]",$data);
                $folder = new Folder();
                if(isset($_ENV['company_id']) && $_ENV['company_id']!= null){
		    $folder->create(WWW_ROOT. "files". DS .$_ENV['company_id']. DS ."graphs". DS .$fileDate . DS . "branches" ,0777);
		    $folder->create(WWW_ROOT. "files". DS .$_ENV['company_id']. DS ."graphs". DS .$fileDate . DS . "branches". DS . $b_key,0777);
		    $folder->create(WWW_ROOT. "files". DS .$_ENV['company_id']. DS ."graphs". DS .$fileDate . DS . "branches". DS . $b_key . DS .'gauge', 0777);
		    $file = fopen(WWW_ROOT."files/".$_ENV['company_id']."/graphs/".$fileDate."/branches/".$b_key."/".$b_key.".txt","w") or die ('can not open file') ;

                }else{
		    $folder->create(WWW_ROOT. "files". DS .$this->Session->read('User.company_id'). DS ."graphs". DS .$fileDate . DS . "branches" ,0777);
		    $folder->create(WWW_ROOT. "files". DS .$this->Session->read('User.company_id'). DS ."graphs". DS .$fileDate . DS . "branches". DS . $b_key,0777);
		    $folder->create(WWW_ROOT."files". DS .$this->Session->read('User.company_id'). DS ."graphs". DS .$fileDate. DS . "branches". DS . $b_key . DS .'gauge', 0777);
		    $file = fopen(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$fileDate."/branches/".$b_key."/".$b_key.".txt","w") or die ('can not open file') ;
                }
                fwrite($file,$data);
                fclose($file);
                if(isset($_ENV['company_id']) && $_ENV['company_id']!= null){
		    $file = fopen(WWW_ROOT."files/".$_ENV['company_id']."/graphs/".$fileDate."/branches/".$b_key."/gauge/".$b_key.".txt","w") or die ('can not open file') ;
		    fwrite($file,json_encode($output));
		    fclose($file);
		    $folder = new Folder();
		    $folder->create(WWW_ROOT. "files". DS .$_ENV['company_id']. DS ."graphs". DS ."branches". DS . $b_key .DS . 'gauge' ,0777);
		    $total_for_gauge = $total / $date_count;
                    $total_ave = array('g'=>$total_for_gauge,'b'=>$avgs);
		    $file = fopen(WWW_ROOT."files/".$_ENV['company_id']."/graphs/".$fileDate."/branches/".$b_key."/gauge/".$b_key.".txt","w") or die ('can not open file') ;

                }else{
		    $file = fopen(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$fileDate."/branches/".$b_key."/gauge/".$b_key.".txt","w") or die ('can not open file') ;
		    fwrite($file,json_encode($output));
		    fclose($file);

		    $folder = new Folder();
		    $folder->create(WWW_ROOT. "files". DS .$this->Session->read('User.company_id'). DS ."graphs". DS ."branches". DS . $b_key .DS . 'gauge' ,0777);
                    $total_for_gauge = 0;
		    $total_for_gauge = $total / $date_count;
                    $total_ave = array('g'=>$total_for_gauge,'b'=>$avgs);
		    $file = fopen(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$fileDate."/branches/".$b_key."/gauge/".$b_key.".txt","w") or die ('can not open file') ;
                }
                fwrite($file,json_encode($total_ave));
                fclose($file);
            endforeach;


    }

public function prepare_graph_data_departmentwise($startDate = null, $endDate=null,$total= null, $total_for_gauge = null, $benchmark = null){
    $this->loadModel('Benchmark');
    $department_benchmark = 0;
    $branch_benchmark = 0;
    $department_count = 0;
    $departments = $this->_get_department_list();

    foreach($departments as $dept_key => $dept_value):

	$department_count++;
	$benchmark = array();
	$benchmark = $this->Benchmark->find('first',array(
				'fields'=>array('Benchmark.benchmark'),
				'conditions'=>array('Benchmark.department_id'=>$dept_key)));
	if(isset($benchmark['Benchmark']['benchmark']))
	$branch_benchmark = $benchmark['Benchmark']['benchmark'];
	$department_benchmark = round(($department_benchmark + $branch_benchmark)/$department_count);
        $output = array();
	if($startDate == null && $endDate == null){
            $startDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'asc')));
            $endDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'desc')));
            $date = date("Y-m-d",strtotime($startDate['History']['created']));
            $end_date = date("Y-m-d",strtotime($endDate['History']['created']));
            $fileDate = date("Y-m-d");
        }else{
            $date = date("Y-m-d",  strtotime($startDate));
            $end_date = date("Y-m-d",  strtotime($endDate));
            $fileDate = date("Y-m-d",  strtotime($startDate));
        }
	$subCount = 0;
	$total = 0;
	$total_for_gauge = 0;
        
	$this->loadModel('MasterListOfFormatDepartment');
	    $this->MasterListOfFormatDepartment->recursive = 0;
	    $options = array('conditions' => array('MasterListOfFormatDepartment.department_id' => $dept_key));

	    $forms =  $this->MasterListOfFormatDepartment->find('all', $options);
	    $date_count = 0;
            while (strtotime($date) <= strtotime($end_date))
	    {
		$subCount = 0;
		    foreach($forms as $form):

			if($form['SystemTable']['name']){

			    $count = 0;
			    $getModelName = Inflector::Classify($form['SystemTable']['name']);
			    $this->loadModel($getModelName);
			    $getModelName." model ".$count = $this->$getModelName->find('count',array('conditions'=>array($getModelName.'.created BETWEEN ? AND ? '=> array($date." 00:00:00",$date." 23:59:00"))));
			    $subCount = $subCount + $count;
			}

		    endforeach;

		    $output[] = array('count'=>$subCount,'date'=>$date);
		    $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

		    $total = $total + $subCount;
		    $date_count++;
	    }
            
	    	    $data = null;
		    $data = "[['Date','Records','Data Entry Benchmark'],";
		    foreach($output as $graph_data):
		    	   $data .= "['".date('d-m-Y',strtotime($graph_data['date']))."',".$graph_data['count'].",$department_benchmark],";
		    endforeach;
		    $data .= "]]";
		    $data = str_replace("],]]","]]",$data);

	    if($dept_key != 'UsersController'){

		    $folder = new Folder();
		    if(isset($_ENV['company_id']) && $_ENV['company_id']!= null){
			$folder->create(WWW_ROOT. "files". DS .$_ENV['company_id']. DS ."graphs". DS . $fileDate);
			$folder->create(WWW_ROOT. "files". DS .$_ENV['company_id']. DS ."graphs". DS . $fileDate . DS ."departments" ,0777);
			$folder->create(WWW_ROOT. "files". DS .$_ENV['company_id']. DS ."graphs". DS . $fileDate . DS ."departments". DS . $dept_key,0777);
			$folder->create(WWW_ROOT. "files". DS .$_ENV['company_id']. DS ."graphs". DS . $fileDate . DS ."departments". DS . $dept_key . DS . 'gauge' ,0777);
			$file = fopen(WWW_ROOT."files/".$_ENV['company_id']."/graphs/".$fileDate."/departments/".$dept_key."/".$dept_key.".txt","w") or die ('can not open file') ;
		    }else{
			$folder->create(WWW_ROOT. "files". DS .$this->Session->read('User.company_id'). DS ."graphs". DS . $fileDate);
			$folder->create(WWW_ROOT. "files". DS .$this->Session->read('User.company_id'). DS ."graphs". DS . $fileDate . DS ."departments" ,0777);
			$folder->create(WWW_ROOT. "files". DS .$this->Session->read('User.company_id'). DS ."graphs". DS . $fileDate . DS ."departments". DS . $dept_key,0777);
			$folder->create(WWW_ROOT. "files". DS .$this->Session->read('User.company_id'). DS ."graphs". DS . $fileDate . DS ."departments". DS . $dept_key . DS . 'gauge' ,0777);
			$file = fopen(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$fileDate."/departments/".$dept_key."/".$dept_key.".txt","w") or die ('can not open file') ;

		    }

		    fwrite($file,$data);
		    fclose($file);

		    $total_for_gauge = 0;
		    $total_for_gauge = $total;
                    $total_ave = 0;
		    $total_ave = array('g'=>$total_for_gauge,'b'=>$department_benchmark);
                    if(isset($_ENV['company_id']) && $_ENV['company_id']!= null){
			    $file = fopen(WWW_ROOT."files/".$_ENV['company_id']."/graphs/".$fileDate."/departments/".$dept_key."/gauge/".$dept_key.".txt","w") or die ('can not open file') ;
		    }else{
			    $file = fopen(WWW_ROOT."files/".$this->Session->read('User.company_id')."/graphs/".$fileDate."/departments/".$dept_key."/gauge/".$dept_key.".txt","w") or die ('can not open file') ;
		    }
		    fwrite($file,json_encode($total_ave));
		    fclose($file);
	    }
    endforeach;
    //exit();

}



	/**
	  * restore method
	  *
	  * @throws NotFoundException
	  * @param string $id
	  * @return void
	*/
	public function restore($id = null) {

            $model_name = $this->modelClass;
            if(!empty($id)){

		$data['id'] = $id;
		$data['soft_delete'] = 0;
		$model_name=$this->modelClass;
		$this->$model_name->save($data);
	    }
	    $this->redirect(array('action' => 'index'));
	}

    public function get() {

        $aCtrlClasses = App::objects('controller');
        foreach ($aCtrlClasses as $controller) {
            if ($controller != 'AppController') {
                App::import('Controller', str_replace('Controller', '', $controller));
                $aMethods = get_class_methods($controller);
                foreach ($aMethods as $idx => $method) {
                    if ($method{0} == '_') {
                        unset($aMethods[$idx]);
                    }
                }
                App::import('Controller', 'AppController');
                $parentActions = get_class_methods('AppController');
                $controllers[$controller] = array_diff($aMethods, $parentActions);
            }
        }

        return $controllers;
    }

    public function prepare_graph_data($startDate = null, $endDate=null){
	App::import('AppController', 'Controller');
        //get benchmark agevare
        $this->loadModel('Benchmark');
        $agg_benchmarks = $this->Benchmark->find('all',array('conditions'=>array('Benchmark.publish'=>1,'Benchmark.soft_delete'=>0)));
        $i = 0;
        $b = 0;
        foreach($agg_benchmarks as $benchmark):
            $b = $b + $benchmark['Benchmark']['benchmark'];
            if($benchmark['Benchmark']['benchmark'] > 0)$i++;
        endforeach;
        if($i!=0)
        $benchmark = round($b/$i);
        else
            $benchmark =  0;

	$this->loadModel('History');
	App::import('HtmlHelper', 'View/Helper');


	    $aControllers = $this->get();
	    if($startDate == null && $endDate == null){
                $startDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'asc')));
                $endDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'desc')));
                $date = date("Y-m-d",strtotime($startDate['History']['created']));
                $end_date = date("Y-m-d",strtotime($endDate['History']['created']));
                $filedate = date('Y-m-d');
            }else{
                $date = date("Y-m-d",strtotime($startDate));
                $end_date = date("Y-m-d",strtotime($endDate));
                $filedate = date('Y-m-d',  strtotime($date));
            }
            

	    
      $output = array();
    while (strtotime($date) <= strtotime($end_date))
    {
    $subCount = 0;
    	foreach($aControllers as $key=>$value):
            if($key == 'DashboardsController' || $key == 'ErrorsController' || $key == 'InstallerController' || $key == 'PagesController'){
                continue;
            }
            if($key !=='UpdatesController'){
	    $count = 0;
	    $getModelName = Inflector::Classify(str_replace('Controller','',$key));
	    $this->loadModel($getModelName);
                $this->$getModelName->recursive = -1;
if(
                            $getModelName != 'History' && $getModelName != 'UserSession'
                            && $getModelName != 'App' && $getModelName != 'Benchmarks'
                            && $getModelName != 'Page' && $getModelName != 'Dashboard'
                            && $getModelName != 'Error' && $getModelName != 'NotificaionType'
                            && $getModelName != 'Approval' && $getModelName != 'Benchmark'
                            && $getModelName != 'FileUpload' && $getModelName != 'DataEntry'
                            && $getModelName != 'Help' && $getModelName != 'MeetingBranch'
                            && $getModelName != 'MeetingDepartment' && $getModelName != 'MeetingEmployee'
                            && $getModelName != 'MeetingTopic' && $getModelName != 'Message'
                            && $getModelName != 'NotificationUser' && $getModelName != 'PurchaseOrderDetail'
                            && $getModelName != 'NotificationUser' && $getModelName != 'PurchaseOrderDetail'
                            && $getModelName != 'MasterListOfFormatBranch' && $getModelName != 'MasterListOfFormatDepartment'
                            && $getModelName != 'MasterListOfFormatDistributor'
                            )
                        {

                            $count = $this->$getModelName->find('count',array('conditions'=>array(
                                                                                    $getModelName.'.created BETWEEN ? AND ? ' => array($date.":00:00:000",$date.":23:59:000")
                                                                                    )));
                            $subCount = $subCount + $count;
                        }
            }
        endforeach;
                        if($subCount > 0)$output[] = array('count'=>$subCount,'date'=>$date);
                        $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

    }
	$data = null;
	$data = "[['Date','Records','Data Entry Benchmark'],";
	foreach($output as $graph_data):
		$data .= "['".date('d-m-Y',strtotime($graph_data['date']))."',".$graph_data['count'].",".$benchmark."],";
	endforeach;
	$data .= "]]";
	$data = str_replace("],]]","]]",$data);



	$folder = new Folder();
        if(isset($_ENV['company_id']) && $_ENV['company_id']!= null){
	    $folder->create(WWW_ROOT."files". DS .$_ENV['company_id']. DS ."graphs". DS ."departments". DS . $key,0777);
	    $folder->create(WWW_ROOT. "files". DS .$_ENV['company_id']. DS ."graphs". DS . $filedate,0777);
	    $file = fopen(WWW_ROOT."files/". DS .$_ENV['company_id']."/graphs/".$filedate."/graph_data.txt","w") or die ('can not open file-1') ;

	}else{
            $folder->create(WWW_ROOT. "files". DS .$this->Session->read('User.company_id'). DS ."graphs". DS ."departments". DS . $key,0777);
	    $folder->create(WWW_ROOT. "files". DS .$this->Session->read('User.company_id'). DS ."graphs". DS . $filedate,0777   );
	    $file = fopen(WWW_ROOT."files/" .$this->Session->read('User.company_id')."/graphs/".$filedate."/graph_data.txt","w") or die ('can not open file-2') ;
            }
        fwrite($file,$data);
	fclose($file);
    }



	// add to data_entries tables

	public function data_entries($startDate=null,$endDate=null){

			$this->History->recursive = -1;
			if(!$startDate)$startDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'asc')));
			if(!$endDate)$endDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'desc')));

			$date = date("Y-m-d",strtotime($startDate['History']['created']));
			$end_date = date("Y-m-d",strtotime($endDate['History']['created']));


			//$date = '2013-9-1 00:00:00';
			//$end_date = '2013-11-21 00:00:00';
			$this->loadModel('DataEntry');
			$this->DataEntry->deleteAll(array('1 = 1'));

			$i = 0;
			$this->loadModel('User');
			$this->User->recursive = -1;
			$users = $this->User->find('all');
			foreach($users as $user):
				$count = 0;
				while (strtotime($date) <= strtotime($end_date)) {
						$count = $this->History->find('count',array(
										'fields'=>array('History.sr_no','History.created_by','History.branchid','History.departmentid'),
										'conditions'=>array(
										$this->common_condition,
										'History.created_by'=> $user['User']['id'],
										'History.created BETWEEN ? AND ?'=> array(date('Y-m-d 00:00:00',strtotime($date)),date ("Y-m-d", strtotime("+1 day", strtotime($date)))))));

						$i++;
				$this->DataEntry->create();
				$data['branch_id'] = $user['User']['branch_id'];
				$data['department_id'] = $user['User']['department_id'];
				$data['user_id'] = $user['User']['id'];
				$data['record_date'] = date('Y-m-d',strtotime($date));
				$data['count'] = $count;
				$this->DataEntry->save($data);
				$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
			}


			endforeach;

	}
public function testo(){
	    App::uses('AppShell', 'Console/Command');
	    App::uses('DBConnectionShell', 'Console/Command');
	     $this->Test = new DBConnectionShell();
	      $this->Test->main();
	}

public function db_backup($tables = '*') {

    $return = '';
    $modelName = $this->modelClass;
    $dataSource = $this->{$modelName}->getDataSource();
    $databaseName = $dataSource->getSchemaName();


    // Do a short header
    $return .= '-- Database: `' . $databaseName . '`' . "\n";
    $return .= '-- Generation time: ' . date('D jS M Y H:i:s') . "\n\n\n";


    if ($tables == '*') {
	$tables = array();
	$result = $this->{$modelName}->query('SHOW TABLES');
	foreach($result as $resultKey => $resultValue){
	    $tables[] = current($resultValue['TABLE_NAMES']);
	}
    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }

    // Run through all the tables
    foreach ($tables as $table) {
	$tableData = $this->{$modelName}->query('SELECT * FROM ' . $table);
    	$return .= 'DROP TABLE IF EXISTS ' . $table . ';';
	$createTableResult = $this->{$modelName}->query('SHOW CREATE TABLE ' . $table);
	$createTableEntry = current(current($createTableResult));
	$return .= "\n\n" . $createTableEntry['Create Table'] . ";\n\n";

	// Output the table data
	foreach($tableData as $tableDataIndex => $tableDataDetails) {
    	    $return .= 'INSERT INTO ' . $table . ' VALUES(';

	    foreach($tableDataDetails[$table] as $dataKey => $dataValue) {

		if(is_null($dataValue)){
		    $escapedDataValue = 'NULL';
		}
		else {
		    // Convert the encoding
		    $escapedDataValue = mb_convert_encoding( $dataValue, "UTF-8", "ISO-8859-1" );

		    // Escape any apostrophes using the datasource of the model.
		    $escapedDataValue = $this->{$modelName}->getDataSource()->value($escapedDataValue);
		}

		$tableDataDetails[$table][$dataKey] = $escapedDataValue;
	    }
	    $return .= implode(',', $tableDataDetails[$table]);
	    $return .= ");\n";
	}
    	$return .= "\n\n\n";
    }

    // Set the default file name
    $date = date('d-m-Y');
    $old_date = date('d-m-Y', strtotime('-7 day',strtotime($date)));
    $fileName = WWW_ROOT.'files/dbbackup/'.$databaseName .'_'. $date. '.sql';

    //Remove old file
    if(file_exists(WWW_ROOT.'files/dbbackup/'.$databaseName .'_'. $old_date. '.sql')){
	unlink(WWW_ROOT.'files/dbbackup/'.$databaseName .'_'. $old_date. '.sql');
    }
    file_put_contents($fileName, $return);
    die;

}



}
