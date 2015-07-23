<?php
/**
 * Bake Template for Controller action generation.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.actions
 * @since         CakePHP(tm) v 1.3
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<?php if($currentModelName == 'User'){ ?>
public $components = array('Ctrl');
<?php } ?>

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
 * <?php echo $admin ?>_check_request method
 *
 * @return void
 */
	
public function <?php echo $admin ?>_check_request(){

        $onlyBranch = null;
	$onlyOwn = null;
	$con1 = null;
	$con2 = null;

	if($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)$onlyBranch = array('<?php echo $currentModelName; ?>.branch_id'=>$this->Session->read('User.branch_id'));
	if($this->Session->read('User.is_view_all') == 0)$onlyOwn = array('<?php echo $currentModelName; ?>.created_by'=>$this->Session->read('User.id'));
	
        if($this->request->params['named']){
        if($this->request->params['named']['published']==null)$con1 = null ; else $con1 = array('<?php echo $currentModelName; ?>.publish'=>$this->request->params['named']['published']);
	if($this->request->params['named']['soft_delete']==null)$con2 = null ; else $con2 = array('<?php echo $currentModelName; ?>.soft_delete'=>$this->request->params['named']['soft_delete']);
	if($this->request->params['named']['soft_delete']==null)$conditions=array($onlyBranch,$onlyOwn,$con1,'<?php echo $currentModelName; ?>.soft_delete'=>0);
        else $conditions=array($onlyBranch,$onlyOwn,$con1,$con2);
	}else{
        $conditions=array($onlyBranch,$onlyOwn,null,'<?php echo $currentModelName; ?>.soft_delete'=>0);
        }
        
        return $conditions;
}

/**
 * request handling by - TGS
 * returns array of records created by user for branch , published / unpublished records & soft_deleted records
 */
/**
 * <?php echo $admin ?>_get_count method
 *
 * @return void
 */
	
public function <?php echo $admin ?>_get_count(){
        
        $onlyBranch = null;
	$onlyOwn = null;
	$condition = null;
        
	if($this->Session->read('User.is_mr') == 0)$onlyBranch = array('<?php echo $currentModelName; ?>.branch_id'=>$this->Session->read('User.branch_id'));
	if($this->Session->read('User.is_view_all') == 0)$onlyOwn = array('<?php echo $currentModelName; ?>.created_by'=>$this->Session->read('User.id'));
	$conditions = array($onlyBranch,$onlyOwn);
	
	$count = $this-><?php echo $currentModelName; ?>->find('count',array('conditions'=>$condition));
	$published = $this-><?php echo $currentModelName; ?>->find('count',array('conditions'=>array($condition,'<?php echo $currentModelName; ?>.publish'=>1,'<?php echo $currentModelName; ?>.soft_delete'=>0)));
	$unpublished = $this-><?php echo $currentModelName; ?>->find('count',array('conditions'=>array($condition,'<?php echo $currentModelName; ?>.publish'=>0,'<?php echo $currentModelName; ?>.soft_delete'=>0)));
	$deleted = $this-><?php echo $currentModelName; ?>->find('count',array('conditions'=>array($condition,'<?php echo $currentModelName; ?>.soft_delete'=>1)));
	$this->set(compact('count','published','unpublished','deleted'));
}

<?php if($currentModelName == 'Approval'){ ?>

/**
 * <?php echo $admin ?>index method
 *
 * @return void
 */
	public function <?php echo $admin ?>index() {
		
		
		$this->paginate = array('order'=>array('<?php echo $currentModelName ?>.sr_no'=>'DESC'),'conditions'=>array($conditions));
	
		$this-><?php echo $currentModelName ?>->recursive = 0;
		$this->set('<?php echo $pluralName ?>', $this->paginate());
		
		
	}

<?php }else  { ?>

/**
 * <?php echo $admin ?>index method
 *
 * @return void
 */
	public function <?php echo $admin ?>index() {
		
		$conditions = $this->_check_request();
		$this->paginate = array('order'=>array('<?php echo $currentModelName ?>.sr_no'=>'DESC'),'conditions'=>array($conditions));
	
		$this-><?php echo $currentModelName ?>->recursive = 0;
		$this->set('<?php echo $pluralName ?>', $this->paginate());
		
		$this->_get_count();
	}


<?php }?> 
/**
 * box layout by - TGS
 * <?php echo $admin ?>box method
 *
 * @return void
 */
	public function <?php echo $admin ?>box() {
	
		$conditions = $this->_check_request();
		$this->paginate = array('order'=>array('<?php echo $currentModelName ?>.sr_no'=>'DESC'),'conditions'=>array($conditions));
		
		$this-><?php echo $currentModelName ?>->recursive = 0;
		$this->set('<?php echo $pluralName ?>', $this->paginate());
		
		$this->_get_count();
	}

/**
 * <?php echo $admin ?>search method
 * Dynamic by - TGS
 * @return void
 */
	public function <?php echo $admin ?>search() {
		if ($this->request->is('post')) {
	
	$search_array = array();
		$search_keys = explode(" ",$this->request->data['<?php echo $currentModelName ?>']['search']);
	
		foreach($search_keys as $search_key):
			foreach($this->request->data['<?php echo $currentModelName ?>']['search_field'] as $search):
				$search_array[] = array('<?php echo $currentModelName; ?>.'.$search .' like' => '%'.$search_key.'%');
			endforeach;
		endforeach;
		
		if($this->Session->read('User.is_mr') == 0)
			{
				$cons = array('<?php echo $currentModelName ?>.branch_id'=>$this->Session->read('User.branch_id'));
			}
		
		$this-><?php echo $currentModelName ?>->recursive = 0;
		$this->paginate = array('order'=>array('<?php echo $currentModelName ?>.sr_no'=>'DESC'),'conditions'=>array('or'=>$search_array , '<?php echo $currentModelName ?>.soft_delete'=>0 , $cons));
		$this->set('<?php echo $pluralName ?>', $this->paginate());
		}
                $this->render('index');
	}

/**
 * <?php echo $admin ?>adcanced_search method
 * Advanced search by - TGS
 * @return void
 */
	public function <?php echo $admin ?>advanced_search() {
		if ($this->request->is('post')) {
		$conditions = array();
			if($this->request->data['Search']['keywords']){
				$search_array = array();
				$search_keys = explode(" ",$this->request->data['Search']['keywords']);
	
				foreach($search_keys as $search_key):
					foreach($this->request->data['Search']['search_fields'] as $search):
					if($this->request->data['Search']['strict_search'] == 0)$search_array[] = array('<?php echo $currentModelName ?>.'.$search => $search_key);
					else $search_array[] = array('<?php echo $currentModelName ?>.'.$search.' like ' => '%'.$search_key.'%');
						
					endforeach;
				endforeach;
				if($this->request->data['Search']['strict_search']==0)$conditions[] = array('and'=>$search_array);
				else $conditions[] = array('or'=>$search_array);
			}
			
		if($this->request->data['Search']['branch_list']){
			foreach($this->request->data['Search']['branch_list'] as $branches):
				$branch_conditions[]=array('<?php echo $currentModelName ?>.branch_id'=>$branches);
			endforeach;
			$conditiions[]=array('or'=>$branch_conditions);
		}
		
		if(!$this->request->data['Search']['to-date'])$this->request->data['Search']['to-date'] = date('Y-m-d');
		if($this->request->data['Search']['from-date']){
			$conditions[] = array('<?php echo $currentModelName ?>.created >'=>date('Y-m-d h:i:s',strtotime($this->request->data['Search']['from-date'])),'<?php echo $currentModelName ?>.created <'=>date('Y-m-d h:i:s',strtotime($this->request->data['Search']['to-date'])));
		}
		unset($this->request->data['Search']);
		
		
		if($this->Session->read('User.is_mr') == 0)$onlyBranch = array('<?php echo $currentModelName; ?>.branch_id'=>$this->Session->read('User.branch_id'));
		if($this->Session->read('User.is_view_all') == 0)$onlyOwn = array('<?php echo $currentModelName; ?>.created_by'=>$this->Session->read('User.id'));
		$conditions[] = array($onlyBranch,$onlyOwn);
		
		$this-><?php echo $currentModelName ?>->recursive = 0;
		$this->paginate = array('order'=>array('<?php echo $currentModelName ?>.sr_no'=>'DESC'),'conditions'=>$conditions , '<?php echo $currentModelName ?>.soft_delete'=>0 );
		$this->set('<?php echo $pluralName ?>', $this->paginate());
		}
                $this->render('index');
	}

/**
 * <?php echo $admin ?>view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function <?php echo $admin ?>view($id = null) {
		if (!$this-><?php echo $currentModelName; ?>->exists($id)) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		$options = array('conditions' => array('<?php echo $currentModelName; ?>.' . $this-><?php echo $currentModelName; ?>->primaryKey => $id));
		$this->set('<?php echo $singularName; ?>', $this-><?php echo $currentModelName; ?>->find('first', $options));
	}



<?php $compact = array(); ?>
/**
 * <?php echo $admin ?>list method
 *
 * @return void
 */
	public function <?php echo $admin ?>lists() {
	
        $this->_get_count();		

	}

<?php if($currentModelName != 'InternalAuditPlan' && $currentModelName != 'Meeting'){ ?>

<?php $compact = array(); ?>
/**
 * <?php echo $admin ?>add_ajax method
 *
 * @return void
 */
	public function <?php echo $admin ?>add_ajax() {
	
		if($this->_show_approvals()){
			$this->loadModel('User');
			$this->User->recursive = 0;
			$userids = $this->User->find('list',array('order'=>array('User.name'=>'ASC'),'conditions'=>array('User.publish'=>1,'User.soft_delete'=>0)));
			$this->set(array('userids'=>$userids,'show_approvals'=>$this->_show_approvals()));
		}
		
		if ($this->request->is('post')) {
                        $this->request->data['<?php echo $currentModelName; ?>']['system_table_id'] = $this->_getSystemtableid();
			$this-><?php echo $currentModelName; ?>->create();
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>

				if($this->_show_approvals()){
					$this->loadModel('Approval');
					$this->Approval->create();
					$this->request->data['Approval']['model_name']='<?php echo $currentModelName; ?>';
					$this->request->data['Approval']['controller_name']=$this->request->params['controller'];
					$this->request->data['Approval']['user_id']=$this->request->data['Approval']['user_id'];
					$this->request->data['Approval']['from']=$this->Session->read('User.id');
					$this->request->data['Approval']['created_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['modified_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['record']=$this-><?php echo $currentModelName; ?>->id;
					$this->Approval->save($this->request->data['Approval']);
				}
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been saved'));
				if($this->_show_evidence() == true)$this->redirect(array('action' => 'view',$this-><?php echo $currentModelName; ?>->id));
				else $this->redirect(str_replace('/lists','/add_ajax',$this->referer()));
<?php else: ?>
				$this->flash(__('<?php echo ucfirst(strtolower($currentModelName)); ?> saved.'), array('action' => 'add_ajax'));
<?php endif; ?>
			} else {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.'));
<?php endif; ?>
			}
		}
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = $this->_pluralName($associationName);
				if($otherModelName != 'BranchId' && $otherModelName != 'DepartmentId'){
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list',array('conditions'=>array('{$otherModelName}.publish'=>1,'{$otherModelName}.soft_delete'=>0)));\n";
				$compact[] = "'{$otherPluralName}'";
                                }
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
	$count = $this-><?php echo $currentModelName; ?>->find('count');
	$published = $this-><?php echo $currentModelName; ?>->find('count',array('conditions'=>array('<?php echo $currentModelName; ?>.publish'=>1)));
	$unpublished = $this-><?php echo $currentModelName; ?>->find('count',array('conditions'=>array('<?php echo $currentModelName; ?>.publish'=>0)));
		
	$this->set(compact('count','published','unpublished'));

	}

<?php $compact = array(); ?>

<?php } ?>



<?php $compact = array(); ?>
/**
 * <?php echo $admin ?>add method
 *
 * @return void
 */
	public function <?php echo $admin ?>add() {
	
		if($this->_show_approvals()){
			$this->loadModel('User');
			$this->User->recursive = 0;
			$userids = $this->User->find('list',array('order'=>array('User.name'=>'ASC'),'conditions'=>array('User.publish'=>1,'User.soft_delete'=>0,'User.is_approvar'=>1)));
			$this->set(array('userids'=>$userids,'show_approvals'=>$this->_show_approvals()));
		}
		
		if ($this->request->is('post')) {
                        $this->request->data['<?php echo $currentModelName; ?>']['system_table_id'] = $this->_getSystemtableid();
			$this-><?php echo $currentModelName; ?>->create();
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>

				if($this->_show_approvals()){
					$this->loadModel('Approval');
					$this->Approval->create();
					$this->request->data['Approval']['model_name']='<?php echo $currentModelName; ?>';
					$this->request->data['Approval']['controller_name']=$this->request->params['controller'];
					$this->request->data['Approval']['user_id']=$this->request->data['Approval']['user_id'];
					$this->request->data['Approval']['from']=$this->Session->read('User.id');
					$this->request->data['Approval']['created_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['modified_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['record']=$this-><?php echo $currentModelName; ?>->id;
					$this->Approval->save($this->request->data['Approval']);
				}
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been saved'));
				if($this->_show_evidence() == true)$this->redirect(array('action' => 'view',$this-><?php echo $currentModelName; ?>->id));
				else $this->redirect(array('action' => 'index'));
<?php else: ?>
				$this->flash(__('<?php echo ucfirst(strtolower($currentModelName)); ?> saved.'), array('action' => 'index'));
<?php endif; ?>
			} else {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.'));
<?php endif; ?>
			}
		}
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = $this->_pluralName($associationName);
				if($otherModelName != 'BranchId' && $otherModelName != 'DepartmentId'){
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list',array('conditions'=>array('{$otherModelName}.publish'=>1,'{$otherModelName}.soft_delete'=>0)));\n";
				$compact[] = "'{$otherPluralName}'";
                                }
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
	$count = $this-><?php echo $currentModelName; ?>->find('count');
	$published = $this-><?php echo $currentModelName; ?>->find('count',array('conditions'=>array('<?php echo $currentModelName; ?>.publish'=>1)));
	$unpublished = $this-><?php echo $currentModelName; ?>->find('count',array('conditions'=>array('<?php echo $currentModelName; ?>.publish'=>0)));
		
	$this->set(compact('count','published','unpublished'));

	}

<?php $compact = array(); ?>
<?php if($currentModelName != 'InternalAuditPlan'){ ?>
/**
 * <?php echo $admin ?>edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>edit($id = null) {
		if (!$this-><?php echo $currentModelName; ?>->exists($id)) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		if($this->_show_approvals()){
			$this->loadModel('User');
			$this->User->recursive = 0;
			$userids = $this->User->find('list',array('order'=>array('User.name'=>'ASC'),'conditions'=>array('User.publish'=>1,'User.soft_delete'=>0)));
			$this->set(array('userids'=>$userids,'show_approvals'=>$this->_show_approvals()));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                        $this->request->data['<?php echo $currentModelName; ?>']['system_table_id'] = $this->_getSystemtableid();
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
				if($this->_show_approvals()){
					$this->loadModel('Approval');
					$this->Approval->create();
					$this->request->data['Approval']['model_name']='<?php echo $currentModelName; ?>';
					$this->request->data['Approval']['controller_name']=$this->request->params['controller'];
					$this->request->data['Approval']['from']=$this->Session->read('User.id');
					$this->request->data['Approval']['user_id']=$this->request->data['Approval']['user_id'];
					$this->request->data['Approval']['created_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['modified_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['record']=$this-><?php echo $currentModelName; ?>->id;
					$this->Approval->save($this->request->data['Approval']);
				}
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been saved'));
				if($this->_show_evidence() == true)$this->redirect(array('action' => 'view',$id));
				else $this->redirect(array('action' => 'index'));
<?php else: ?>
				$this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'), array('action' => 'index'));
<?php endif; ?>
			} else {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.'));
<?php endif; ?>
			}
		} else {
			$options = array('conditions' => array('<?php echo $currentModelName; ?>.' . $this-><?php echo $currentModelName; ?>->primaryKey => $id));
			$this->request->data = $this-><?php echo $currentModelName; ?>->find('first', $options);
		}
<?php
		foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
			foreach ($modelObj->{$assoc} as $associationName => $relation):
				if (!empty($associationName)):
					$otherModelName = $this->_modelName($associationName);
					$otherPluralName = $this->_pluralName($associationName);
					if($otherModelName != 'BranchId' && $otherModelName != 'DepartmentId'){
                                        echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list',array('conditions'=>array('{$otherModelName}.publish'=>1,'{$otherModelName}.soft_delete'=>0)));\n";
                                        $compact[] = "'{$otherPluralName}'";
                                }
				endif;
			endforeach;
		endforeach;
		if (!empty($compact)):
			echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
		endif;
	?>
		$count = $this-><?php echo $currentModelName; ?>->find('count');
		$published = $this-><?php echo $currentModelName; ?>->find('count',array('conditions'=>array('<?php echo $currentModelName; ?>.publish'=>1)));
		$unpublished = $this-><?php echo $currentModelName; ?>->find('count',array('conditions'=>array('<?php echo $currentModelName; ?>.publish'=>0)));
		
		$this->set(compact('count','published','unpublished'));
	}
<?php } ?>

<?php $compact = array(); ?>
/**
 * <?php echo $admin ?>approve method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>approve($id = null, $approval_id = null) {
		if (!$this-><?php echo $currentModelName; ?>->exists($id)) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		
		$this->loadModel('Approval');
		if (!$this->Approval->exists($approval_id)) {
			throw new NotFoundException(__('Invalid approval id'));
		}
		
		$approval = $this->Approval->read(null,$approval_id);
		$this->set('same',$approval['Approval']['user_id']);
		
		//$approval_history = $this->Approval->find('all',array('order'=>array('Approval.sr_no'=>'DESC'),'conditions'=>array('Approval.model_name'=>'<?php echo $currentModelName; ?>','Approval.record'=>$id)));
		//$this->set(compact('approval_history'));
		
		if($this->_show_approvals()){
			$this->loadModel('User');
			$this->User->recursive = 0;
			$userids = $this->User->find('list',array('order'=>array('User.name'=>'ASC'),'conditions'=>array('User.publish'=>1,'User.soft_delete'=>0)));
			$this->set(array('userids'=>$userids,'show_approvals'=>$this->_show_approvals()));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
				if($this->request->data['<?php echo $currentModelName; ?>']['publish'] == 0 && $this->_show_approvals()){
					$this->loadModel('Approval');
					$this->Approval->create();
					$this->request->data['Approval']['model_name']='<?php echo $currentModelName; ?>';
					$this->request->data['Approval']['controller_name']=$this->request->params['controller'];
					$this->request->data['Approval']['from']=$this->Session->read('User.id');
					$this->request->data['Approval']['user_id']=$this->request->data['Approval']['user_id'];
					$this->request->data['Approval']['created_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['modified_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['record']=$this-><?php echo $currentModelName; ?>->id;
					$this->Approval->save($this->request->data['Approval']);
					
					$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been saved'));
					if($this->_show_evidence() == true)$this->redirect(array('action' => 'view',$id));
					else $this->redirect(array('action' => 'index'));
				}else{
					$this->Approval->read(null, $approval_id);
					$data['Approval']['status'] = 'Approved';
					$data['Approval']['modified_by'] = $this->Session->read('User.id');
					$this->Approval->save($data);
					$this->Session->setFlash(__('The branch has been published'));
					if($this->_show_evidence() == true)$this->redirect(array('action' => 'view',$id));
					else $this->redirect(array('action' => 'index'));
				}
				
<?php else: ?>
				$this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'), array('action' => 'index'));
<?php endif; ?>
			} else {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.'));
<?php endif; ?>
			}
		} else {
			$options = array('conditions' => array('<?php echo $currentModelName; ?>.' . $this-><?php echo $currentModelName; ?>->primaryKey => $id));
			$this->request->data = $this-><?php echo $currentModelName; ?>->find('first', $options);
		}
<?php
		foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
			foreach ($modelObj->{$assoc} as $associationName => $relation):
				if (!empty($associationName)):
					$otherModelName = $this->_modelName($associationName);
					$otherPluralName = $this->_pluralName($associationName);
					if($otherModelName != 'BranchId' && $otherModelName != 'DepartmentId'){
                                        echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list',array('conditions'=>array('{$otherModelName}.publish'=>1,'{$otherModelName}.soft_delete'=>0)));\n";
                                        $compact[] = "'{$otherPluralName}'";
                                }
				endif;
			endforeach;
		endforeach;
		if (!empty($compact)):
			echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
		endif;
	?>
		$count = $this-><?php echo $currentModelName; ?>->find('count');
		$published = $this-><?php echo $currentModelName; ?>->find('count',array('conditions'=>array('<?php echo $currentModelName; ?>.publish'=>1)));
		$unpublished = $this-><?php echo $currentModelName; ?>->find('count',array('conditions'=>array('<?php echo $currentModelName; ?>.publish'=>0)));
		
		$this->set(compact('count','published','unpublished'));
	}


/**
 * <?php echo $admin ?>purge method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>purge($id = null) {
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this-><?php echo $currentModelName; ?>->delete()) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted'));
			$this->redirect(array('action' => 'index'));
<?php else: ?>
			$this->flash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> deleted'), array('action' => 'index'));
<?php endif; ?>
		}
<?php if ($wannaUseSession): ?>
		$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not deleted'));
<?php else: ?>
		$this->flash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> was not deleted'), array('action' => 'index'));
<?php endif; ?>
		$this->redirect(array('action' => 'index'));
	}
        
       /**
 * <?php echo $admin ?>delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>delete($id = null) {
	
            $model_name = $this->modelClass;
            if(!empty($id)){
    
            $data['id'] = $id;
            $data['soft_delete'] = 1;
            $model_name=$this->modelClass;
            $this->$model_name->save($data);
    }
    $this->redirect(array('action' => 'index'));
     
    
}
 
	
	
	
	public function <?php echo $admin; ?>report(){
		
		$result = explode('+',$this->request->data['<?php echo $pluralName ?>']['rec_selected']);
		$this-><?php echo $currentModelName; ?>->recursive = 1;
		$<?php echo $pluralName ?> = $this-><?php echo $currentModelName; ?>->find('all',array('<?php echo $currentModelName; ?>.publish'=>1,'<?php echo $currentModelName; ?>.soft_delete'=>1,'conditions'=>array('or'=>array('<?php echo $currentModelName; ?>.id'=>$result))));
		$this->set('<?php echo $pluralName ?>', $<?php echo $pluralName ?>);
		
		<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = $this->_pluralName($associationName);
                                if($otherModelName != 'BranchId' && $otherModelName != 'DepartmentId'){
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list',array('conditions'=>array('{$otherModelName}.publish'=>1,'{$otherModelName}.soft_delete'=>0)));\n";
				$compact[] = "'{$otherPluralName}'";
                                }
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
}

<?php if($currentModelName == 'User'){ ?>
/**
/**
 * Bake Following Methods ONLY for USERS model - By TGS
 *
 */

public function reset_password($params = null, $user = null) {
    if (empty($params)) {
        if ($this->request->is('post') || $this->request->is('put')) {
	    $user = $this->User->find('first',array('conditions'=>array('User.status'=>1,'User.username'=> $this->data['User']['username'])));
	    if(!empty($user)){
		if($user['Employee']['office_email']){
		    $email = $user['Employee']['office_email'];
		}else{
		    $email = $user['Employee']['personal_email'];	
		}
                
                $this->_sendPasswordReset($email);
	    }else{
		$this->Session->setFlash(__('Invalid Username, try again.'));
		$this->redirect(array('action' => 'reset_password'));
	    }
	}else{
	    $this->_sendPasswordReset();
	}
	}else {
	    $this->_checkResetPassword($params);
    }
}

public function _checkResetPassword($params) {
    $user = $this->User->checkPasswordToken($params);
    if (empty($user)) {
	$this->Session->setFlash(__('Invalid password reset token, try again.'));
	$this->redirect(array('action' => 'reset_password1'));
    }
    
    if (!empty($this->request->data) && $this->User->resetPassword($this->request->data)) {
	$this->Session->setFlash('Password changed, you can now login with your new password.');
	$this->redirect(array('controller'=>'users','action' => 'login'));
    }

    $this->set('token', $params['token']);
    $this->set('username', $params['username']);
		
}

public function _getMailInstance() {
    return new CakeEmail();
}

public function _sendPasswordReset($email = null) {
    $options = array(
        'from' => Configure::read('App.defaultEmail'),
	'subject' => __('Password Reset'),
	'template' => 'password_reset_request',
	'layout' => 'default'
    );

    if (!empty($this->request->data)) {
	$user = $this->User->passwordReset($email);
        if (!empty($user)) {
	    $Email = new CakeEmail();
            /*$Email->smtpOptions = array(
		'port'=>'465', 
		'timeout'=>'30',
		'host' => 'ssl://smtp.gmail.com',
		'username'=>'ruchitamantri@gmail.com',
		'password'=>'',
	    );
        
            $Email->delivery('smtp');
		//$Email->send = 'debug';
		$Email->from('ruchitamantri@gmail.com');
		$Email->to('ruchita.ladha@techmentis.biz'); 
		$Email->subject('hurrah'); 
		//
	    
            $Email->send('dghdfgdd');*/
            $Email->from(array('admin@techmentis.biz' => 'FlinkIso'));
	    $Email->to('ruchita.ladha@techmentis.biz');
	    $Email->subject('About');
	    $Email->send('My message');
	    
            /*$Email_Config = $this->_getMailInstance();
            $Email_Config->to($email);
	    $Email_Config->from($options['from']);
	    $Email_Config->subject($options['subject']);
            $Email_Config->template($options['template'], $options['layout']);
	    $Email_Config->viewVars(array(
		'model' => 'User',
		'user' => $this->User->data,'params'=>array(
			'token' => $this->User->data['User']['password_token'], 'username'=>$this->User->data['User']['username'])));
			->send();*/

	    $this->Session->setFlash('An email has been sent with instruction to reset their password.');
	    $this->redirect(array('controller'=>'users','action' => 'login'));			
            }
	}
	$this->render('request_password_change');
    }
        
public function login(){
	
		if($this->Session->read('User.id')){
			
			$this->redirect(array('controller'=>'users','action' => 'dashboard'));
		}
		$this->layout = 'login';
		
		$allUsers = $this->User->find('all',array('conditions'=>array('User.login_status'=>1)));
		foreach($allUsers as $user){
			$current_time = date('Y-m-d H:i:s');
			$last_act_time = date('Y-m-d H:i:s', strtotime('+1 mins', strtotime($user['User']['last_activity'])));
			if($last_act_time < $current_time)
				{
					$this->User->read(null,$user['User']['id']);
					$data['User']['last_activity'] = date('Y-m-d H:i:s');
					$data['User']['login_status'] = 0;
					$this->User->save($data, false);
			
			}
		}
	
	if ($this->request->is('post')) 
	{
		$user = $this->User->find('first',array('conditions'=>array('User.status'=>1,'User.login_status'=>0,'User.username'=> $this->data['User']['username'])));
		
		if(empty($user))
		{
			$users = $this->User->find('first',array('conditions'=>array('User.login_status'=>1,'User.username'=> $this->data['User']['username'])));
			
			if($users['User']['login_status'] == 1){
				$this->Session->setFlash(__('Already Logged In', true));
				$this->redirect(array('controller'=>'users','action' => 'login'));			
			}
			if($users)
			{
				
				$current_time = date('Y-m-d H:i:s');
				$last_act_time = date('Y-m-d H:i:s', strtotime('-10 mins', strtotime($users['User']['last_activity'])));
				if($last_act_time < $current_time)
					{
						//echo "1";
						$this->User->read(null,$users['User']['id']);
						$data['User']['last_activity'] = date('Y-m-d H:i:s');
						$this->User->save($data, false);
						
						if($users['User']['last_activity'] != NULL){
							$this->Session->setFlash(__('Please wait while your earlier session expires', true));
							$this->redirect(array('controller'=>'users','action' => 'login'));					
						}
					}else{
						$this->Session->setFlash(__('Username incorrect or Account is locked or Already logged in', true));
						$this->redirect(array('controller'=>'users','action' => 'login'));	
					}
			}		
		}elseif($user['User']['password'] != $this->data['User']['password'])
		{
			if($this->Session->read('Login.username') == $this->data['User']['username']){
				$this->Session->write('Login.count',$this->Session->read('Login.count')+1);
			}else{
				$this->Session->write('Login.count',0);	
			}
				$this->Session->write('Login.username',$this->data['User']['username']);
				if(3 < ($this->Session->read('Login.count')+2) ){
						// set account_status to 3
							$this->User->read(null,$user['User']['id']);
							$data['User']['status'] = 3;
							$this->User->save($data, false);
						// distroy session
							$this->Session->destroy();									
						$this->Session->setFlash(__('Your account is locked', true));
						$this->redirect(array('controller'=>'users','action' => 'login'));
				}else{
					$this->Session->write('Login.username',$user['User']['username']);	
				}
			$this->Session->setFlash(__('Password is incorrect : You have '. (3 - $this->Session->read('Login.count')-1). ' attempts left', true));
			$this->redirect(array('controller'=>'users','action' => 'login'));
		
		}else{
			$this->User->read(null,$user['User']['id']);
			$data['User']['last_login'] = date('Y-m-d H:i:s');
			$data['User']['last_activity'] = date('Y-m-d H:i:s');
			$data['User']['login_status'] = 1;
			$this->User->save($data, false);
			$this->Session->write('User.id', $user['User']['id']);
			$this->Session->write('User.employee_id', $user['Employee']['id']);
			$this->Session->write('User.branch_id', $user['User']['branch_id']);
			$this->Session->write('User.department_id', $user['User']['department_id']);
			$this->Session->write('User.branch', $user['Branch']['name']);
			$this->Session->write('User.department', $user['Department']['name']);
			$this->Session->write('User.name',$user['Employee']['name']);
			$this->Session->write('User.username',$user['User']['username']);			
			$this->Session->write('User.lastLogin',$user['User']['last_login']);
			$this->Session->write('User.is_mr',$user['User']['is_mr']);			
			$this->Session->write('User.is_view_all',$user['User']['is_view_all']);
			$this->Session->write('User.is_approvar',$user['User']['is_approvar']);
			
			$_SESSION['User']['id'] = $user['User']['id'];	
		
			if($user['User']['last_login'] == NULL) 
			{
				$this->Session->setFlash(__('Please change your password', true));
				$this->redirect(array('controller'=>'users','action' => 'password'));	
			}else{			
				//$this->Session->setFlash(__('Please change your password', true));
				$this->loadModel('UserSession');
				$this->UserSession->create();
				$data['UserSession']['ip_address'] = $_SERVER['REMOTE_ADDR'];
				$data['UserSession']['browser_details'] = json_encode($_SERVER);
				$data['UserSession']['start_time'] =  date('Y-m-d H:i:s');
				$data['UserSession']['end_time'] =  date('Y-m-d H:i:s');
				$data['UserSession']['user_id'] = $this->Session->read('User.id');
				$data['UserSession']['employee_id'] = $this->Session->read('User.employee_id');
				$this->UserSession->save($data, false);
				$this->Session->write('User.user_session_id',$this->UserSession->id);
				$this->redirect(array('controller'=>'users','action' => 'dashboard'));	
			}
		}
		
		$this->Session->setFlash(__('Username incorrect or Account is locked or Already logged in', true));
		$this->redirect(array('controller'=>'users','action' => 'login'));	
	}
	}

	public function logout(){		
			$this->User->read(null,$this->Session->read('User.id'));			
			$data['User']['login_status'] = 0;
			$this->User->save($data, false);
			
			$this->Session->write('User.id',NULL);
			$this->Session->destroy('User');						
			$this->Session->setFlash(__('You have been logged out'.$this->Session->read('User.id'), true));
			$this->redirect(array('controller'=>'users','action' => 'login'));
	}
                
        
public function dashboard(){
	
	$this->loadModel('Approval');
	$this->Approval->recursive=0;
	$approvals = $this->Approval->find('all',array('order'=>array('Approval.created'=>'desc'),'conditions'=>array('OR'=>array('Approval.status'=>null,'Approval.status'=>0),'Approval.user_id'=>$this->Session->read('User.id'))));
	$approvals_count = $this->Approval->find('count',array('conditions'=>array('OR'=>array('Approval.status'=>null,'Approval.status'=>0),'Approval.user_id'=>$this->Session->read('User.id'))));
	$this->set(compact('approvals','approvals_count'));
	
	//get upload folder size
	$var = APP . DS;
	$upload_size = $this->_foldersize($var.'webroot/files');
	$upload_size = $this->_formatfilesize($upload_size[0]);
	$this->set('upload_size',$upload_size);
	//echo json_encode($upload_size[0]*9.9999/10000000);
	
	$file_uploads = $this->User->FileUpload->find('all',array('limit'=>4));
	
	$this->loadModel('CustomerComplaint');
	$complaint_received = $this->CustomerComplaint->find('count');
	$complaint_resolved = $this->CustomerComplaint->find('count',array('CustomerComplaint.current_status <> '=>0));
	
	
	$this->loadModel('SuggestionForm');
	$Suggestions = $this->SuggestionForm->find('count');
	
	$this->set(array('complaint_received'=>$complaint_received,'complaint_resolved'=>$complaint_resolved,'Suggestions'=>$Suggestions,'file_uploads'=>$file_uploads,'dbsize'=>$this->_getDbSize()));
	
    }

	
public function _getDbSize(){
		$link = mysql_connect('localhost', 'root');        
		mysql_select_db('flink002');
		$result = mysql_query("SHOW TABLE STATUS");
		//debug(mysql_select_db('flink002'));
		$dbsize = 0;
		
		while($row = mysql_fetch_array($result)) {
		
		    $dbsize += $row["Data_length"] + $row["Index_length"];
		
		}
		return $this->_formatfilesize($dbsize);
	}
	
public function _foldersize($dir){

 $count_size = 0;
 $count = 0;
 $dir_array = scandir($dir);
 foreach($dir_array as $key=>$filename){
  if($filename!=".." && $filename!="."){
   if(is_dir($dir."/".$filename)){
    $new_foldersize = $this->_foldersize($dir."/".$filename);
    $count_size = $count_size + $new_foldersize[0];
    $count = $count + $new_foldersize[1];
   }else if(is_file($dir."/".$filename)){
    $count_size = $count_size + filesize($dir."/".$filename);
    $count++;
   }
  }
 
 }
 
 return array($count_size,$count);
}	

    public function user_access($id = null){
	$this->User->recursive = 0;
	if (!$this->User->exists($id)) {
	    throw new NotFoundException(__('Invalid user'));
	}
		
	if ($this->request->is('post') || $this->request->is('put'))
	    {
                $this->User->read(null,$id);
		$data['User']['user_access'] = json_encode($this->request->data);
		if ($this->User->save($data,false)) {
			$this->Session->setFlash(__('Saved', true));
			$this->redirect(array('controller'=>'users','action' => 'index'));					
                }else{
			$this->Session->setFlash(__('Not Saved', true));
			$this->redirect(array('controller'=>'users','action' => 'index'));						
		}
            } else {
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->request->data = $this->User->find('first', $options);
			
		$new_data = array(json_decode($this->request->data['User']['user_access']));
		$this->set($this->request->data['User']['user_access'],$new_data);
	    }
			
		$aControllers = $this->Ctrl->get();
		$this->set('allAcess',$aControllers);
	}


    public function access_denied(){}    
<?php } ?>  

<?php if($currentModelName == 'Approval'){ ?>
public function approve_many() {
		$failed = 0;
		if ($this->request->is('post')) {
		    $records = explode("+",ltrim($this->request->data['approvals']['recs_selected'],'+'));
		    debug($this->request->data);
		    foreach($records as $record):
			$data['Approval']['record'] = $record;
			$data['Approval']['model_name']= $this->request->data['Approval']['model_name'] ;
			$data['Approval']['controller_name'] = $this->request->data['Approval']['controller_name'] ;
			$data['Approval']['from'] = $this->Session->read('User.id') ;
			$data['Approval']['user_id'] = $this->request->data['Approval']['user_id'] ;
			$data['Approval']['comments'] = $this->request->data['Approval']['comments'] ;
			$data['Approval']['status'] = 0;
			$this->Approval->create();
			if(!$this->Approval->save($data))$failed = 1;
		    endforeach;
		}
		    if($failed == 1){
			$this->Session->setFlash(__('There was a issue sending the approvals for some of the records'));
		    }else{
			$this->Session->setFlash(__('Sent for approvals'));
		    }
		$this->redirect(array('action' => 'index'));
		
	}
<?php } ?>

<?php if($currentModelName == 'MasterListOfFormatDepartment'){ ?>
public function listing() {
		$options = array('conditions' => array('MasterListOfFormatDepartment.department_id' => $this->request->params['pass']['0']));
		$this->set('masterListOfFormatDepartment', $this->MasterListOfFormatDepartment->find('all', $options));
	}
        
<?php } ?>

<?php if($currentModelName == 'MasterListOfFormat'){ ?>
/**
 * add_new_ajax method
 *
 * @return void
 */
	public function add_new_ajax() {
	
		if($this->_show_approvals()){
			$this->loadModel('User');
			$this->User->recursive = 0;
			$userids = $this->User->find('list',array('order'=>array('User.name'=>'ASC'),'conditions'=>array('User.publish'=>1,'User.soft_delete'=>0,'User.is_approvar'=>1)));
			$this->set(array('userids'=>$userids,'show_approvals'=>$this->_show_approvals()));
		}
		
		if ($this->request->is('post')) {
                       
			$this->MasterListOfFormat->create();
			debug($this->request->data);
			if ($this->MasterListOfFormat->save($this->request->data)) {
			    $this->_add_branches_and_departments($this->request->data['MasterListOfFormat']['branch_id'],$this->request->data['MasterListOfFormat']['department_id'],$this->request->data['MasterListOfFormat']['system_table_id'],$this->MasterListOfFormat->id,1);
				if($this->_show_approvals()){
					$this->_add_branches_and_departments($this->request->data['MasterListOfFormat']['branch_id'],$this->request->data['MasterListOfFormat']['department_id'],$this->MasterListOfFormat->id,0);
					$this->loadModel('Approval');
					$this->Approval->create();
					$this->request->data['Approval']['model_name']='MasterListOfFormat';
					$this->request->data['Approval']['controller_name']=$this->request->params['controller'];
					$this->request->data['Approval']['user_id']=$this->request->data['Approval']['user_id'];
					$this->request->data['Approval']['from']=$this->Session->read('User.id');
					$this->request->data['Approval']['created_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['modified_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['record']=$this->MasterListOfFormat->id;
					$this->Approval->save($this->request->data['Approval']);
				}
				$this->Session->setFlash(__('The master list of format has been saved'));
				if($this->_show_evidence() == true)$this->redirect(array('action' => 'view',$this->MasterListOfFormat->id));
				else $this->redirect(array('controller'=>'master_list_of_formats','action'=>'add_new_ajax'));
			} else {
				$this->Session->setFlash(__('The master list of format could not be saved. Please, try again.'));
			}
		}
		
		$systemTables = $this->MasterListOfFormat->SystemTable->find('list',array('conditions'=>array('SystemTable.publish'=>1,'SystemTable.soft_delete'=>0)));
		$createdBies = $this->MasterListOfFormat->CreatedBy->find('list',array('conditions'=>array('CreatedBy.publish'=>1,'CreatedBy.soft_delete'=>0)));
		$modifiedBies = $this->MasterListOfFormat->ModifiedBy->find('list',array('conditions'=>array('ModifiedBy.publish'=>1,'ModifiedBy.soft_delete'=>0)));
	    	$this->set(compact('systemTables', 'createdBies', 'modifiedBies'));
		
		$count = $this->MasterListOfFormat->find('count');
		$published = $this->MasterListOfFormat->find('count',array('conditions'=>array('MasterListOfFormat.publish'=>1)));
		$unpublished = $this->MasterListOfFormat->find('count',array('conditions'=>array('MasterListOfFormat.publish'=>0)));
		
	$this->set(compact('count','published','unpublished'));

	}


    public function _add_branches_and_departments($branches,$departments,$system_table_id,$newid,$publish){
	
	$new_data = array();
	foreach($branches as $branchids):
	    $this->MasterListOfFormat->MasterListOfFormatBranch->create();
	    $new_data['MasterListOfFormatBranch']['master_list_of_format_id'] = $newid;
	    $new_data['MasterListOfFormatBranch']['branch_id'] = $branchids;
	    $new_data['MasterListOfFormatBranch']['system_table_id'] = $system_table_id;
	    $new_data['MasterListOfFormatBranch']['publish'] = $publish;
	    $new_data['MasterListOfFormatBranch']['soft_delete'] = 0;
	    $this->MasterListOfFormat->MasterListOfFormatBranch->save($new_data);
	 endforeach;
	$new_data = array(); 
	 foreach($departments as $departmentids):
	    $this->MasterListOfFormat->MasterListOfFormatDepartment->create();
	    $new_data['MasterListOfFormatDepartment']['master_list_of_format_id'] = $newid;
	    $new_data['MasterListOfFormatDepartment']['department_id'] = $departmentids;
	    $new_data['MasterListOfFormatDepartment']['system_table_id'] = $system_table_id;
	    $new_data['MasterListOfFormatDepartment']['publish'] = $publish;
	    $new_data['MasterListOfFormatDepartment']['soft_delete'] = 0;
	    $this->MasterListOfFormat->MasterListOfFormatDepartment->save($new_data);
	 endforeach;
    }

<?php } ?>


<?php if($currentModelName == 'InternalAuditPlan'){ ?>

public function add_ajax() {
	
		if($this->_show_approvals()){
			$this->loadModel('User');
			$this->User->recursive = 0;
			$userids = $this->User->find('list',array('order'=>array('User.name'=>'ASC'),'conditions'=>array('User.publish'=>1,'User.soft_delete'=>0,'User.is_approvar'=>1)));
			$this->set(array('userids'=>$userids,'show_approvals'=>$this->_show_approvals()));
		}
		
		if ($this->request->is('post')) {
		        $this->request->data['InternalAuditPlan']['system_table_id'] = $this->_getSystemtableid();
			 $this->InternalAuditPlan->create();
			
			if ($this->InternalAuditPlan->save($this->request->data['InternalAuditPlan'], false)) {
				$this->loadModel('InternalAuditPlanBranch');
				$this->InternalAuditPlanBranch->create();
				$this->request->data['InternalAuditPlanBranch']['internal_audit_plan_id'] = $this->InternalAuditPlan->id;
				$this->request->data['InternalAuditPlanBranch']['branchid']=$this->request->data['InternalAuditPlan']['branchid'];
				$this->request->data['InternalAuditPlanBranch']['departmentid']=$this->request->data['InternalAuditPlan']['departmentid'];
				$this->request->data['InternalAuditPlanBranch']['created_by']=$this->Session->read('User.id');
				$this->request->data['InternalAuditPlanBranch']['modified_by']=$this->Session->read('User.id');
				$this->InternalAuditPlanBranch->save($this->request->data['InternalAuditPlanBranch'], false);
				$this->loadModel('InternalAuditPlanDepartment');
				foreach($this->request->data['InternalAuditPlanDepartment'] as $val){
					
					$this->InternalAuditPlanDepartment->create();
					$val['internal_audit_plan_id'] = $this->InternalAuditPlan->id;
					$val['branchid']=$this->request->data['InternalAuditPlan']['branchid'];
					$val['departmentid']=$this->request->data['InternalAuditPlan']['departmentid'];
					$val['created_by']=$this->Session->read('User.id');
					$val['modified_by']=$this->Session->read('User.id');
					$this->InternalAuditPlanDepartment->save($val, false); 
				}
				
				
				if($this->_show_approvals()){
					$this->loadModel('Approval');
					$this->Approval->create();
					$this->request->data['Approval']['model_name']='InternalAuditPlan';
					$this->request->data['Approval']['controller_name']=$this->request->params['controller'];
					$this->request->data['Approval']['user_id']=$this->request->data['Approval']['user_id'];
					$this->request->data['Approval']['from']=$this->Session->read('User.id');
					$this->request->data['Approval']['created_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['modified_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['record']=$this->InternalAuditPlan->id;
					$this->Approval->save($this->request->data['Approval']);
				}
				$this->Session->setFlash(__('The internal audit plan has been saved'));
				if($this->_show_evidence() == true)$this->redirect(array('action' => 'view',$this->InternalAuditPlan->id));
				else $this->redirect(array('action' => 'add_ajax'));
			} else {
				$this->Session->setFlash(__('The internal audit plan could not be saved. Please, try again.'));
			}
		}
		$listOfTrainedInternalAuditors = $this->InternalAuditPlan->ListOfTrainedInternalAuditor->find('list',array('conditions'=>array('ListOfTrainedInternalAuditor.publish'=>1,'ListOfTrainedInternalAuditor.soft_delete'=>0)));
		$systemTables = $this->InternalAuditPlan->SystemTable->find('list',array('conditions'=>array('SystemTable.publish'=>1,'SystemTable.soft_delete'=>0)));
		$masterListOfFormats = $this->InternalAuditPlan->MasterListOfFormat->find('list',array('conditions'=>array('MasterListOfFormat.publish'=>1,'MasterListOfFormat.soft_delete'=>0)));
		$createdBies = $this->InternalAuditPlan->CreatedBy->find('list',array('conditions'=>array('CreatedBy.publish'=>1,'CreatedBy.soft_delete'=>0)));
		$modifiedBies = $this->InternalAuditPlan->ModifiedBy->find('list',array('conditions'=>array('ModifiedBy.publish'=>1,'ModifiedBy.soft_delete'=>0)));
				$this->set(compact('listOfTrainedInternalAuditors', 'systemTables', 'masterListOfFormats', 'createdBies', 'modifiedBies'));
	$count = $this->InternalAuditPlan->find('count');
	$published = $this->InternalAuditPlan->find('count',array('conditions'=>array('InternalAuditPlan.publish'=>1)));
	$unpublished = $this->InternalAuditPlan->find('count',array('conditions'=>array('InternalAuditPlan.publish'=>0)));
		
	$this->set(compact('count','published','unpublished'));
	//Add branches
	
	$this->set('branches', $this->InternalAuditPlan->InternalAuditPlanBranch->Branch->find('list'));
	$this->set('employees', $this->InternalAuditPlan->InternalAuditPlanBranch->Employee->find('list'));
	
	$listOfTrainedInternalAuditors= $this->InternalAuditPlan->ListOfTrainedInternalAuditor->find("list", array(
	    "joins" => array(
		array(
		    "table" => "employees",
		    "alias" => "Employees",
		    "type" => "LEFT",
		    "conditions" => array(
			"ListOfTrainedInternalAuditor.employee_id = Employees.id"
		    )
		)
	    ),
	     'fields' => array('ListOfTrainedInternalAuditor.id', 'Employees.name'),
	    'conditions' => array(
		'ListOfTrainedInternalAuditor.publish'=>1,'ListOfTrainedInternalAuditor.soft_delete'=>0
	    )
	));
	$this->set('listOfTrainedInternalAuditors', $listOfTrainedInternalAuditors);
	
	//Add Department
	$i = 0;
	$this->set('branches', $this->InternalAuditPlan->InternalAuditPlanBranch->Branch->find('list'));
	$this->set('departments', $this->InternalAuditPlan->InternalAuditPlanDepartment->Department->find('list'));
	$this->set('employees', $this->InternalAuditPlan->InternalAuditPlanDepartment->Employee->find('list'));
	
	$listOfTrainedInternalAuditors= $this->InternalAuditPlan->ListOfTrainedInternalAuditor->find("list", array(
	    "joins" => array(
		array(
		    "table" => "employees",
		    "alias" => "Employees",
		    "type" => "LEFT",
		    "conditions" => array(
			"ListOfTrainedInternalAuditor.employee_id = Employees.id"
		    )
		)
	    ),
	     'fields' => array('ListOfTrainedInternalAuditor.id', 'Employees.name'),
	    'conditions' => array(
		'ListOfTrainedInternalAuditor.publish'=>1,'ListOfTrainedInternalAuditor.soft_delete'=>0
	    )
	));
	$this->set('listOfTrainedInternalAuditors', $listOfTrainedInternalAuditors);
	$this->set('i', $i);
	$this->render('add_custom');
	}

        
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
	  
		if (!$this->InternalAuditPlan->exists($id)) {
			throw new NotFoundException(__('Invalid internal audit plan'));
		}
		if($this->_show_approvals()){
			$this->loadModel('User');
			$this->User->recursive = 0;
			$userids = $this->User->find('list',array('order'=>array('User.name'=>'ASC'),'conditions'=>array('User.publish'=>1,'User.soft_delete'=>0,'User.is_approvar'=>1)));
			$this->set(array('userids'=>$userids,'show_approvals'=>$this->_show_approvals()));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                        $this->request->data['InternalAuditPlan']['system_table_id'] = $this->_getSystemtableid();
			if ($this->InternalAuditPlan->save($this->request->data, false)) {
			    
				$this->loadModel('InternalAuditPlanBranch');
				$this->InternalAuditPlanBranch->create();
				$this->request->data['InternalAuditPlanBranch']['internal_audit_plan_id'] = $this->InternalAuditPlan->id;
				$this->request->data['InternalAuditPlanBranch']['branchid']=$this->request->data['InternalAuditPlan']['branchid'];
				$this->request->data['InternalAuditPlanBranch']['departmentid']=$this->request->data['InternalAuditPlan']['departmentid'];
				$this->request->data['InternalAuditPlanBranch']['created_by']=$this->Session->read('User.id');
				$this->request->data['InternalAuditPlanBranch']['modified_by']=$this->Session->read('User.id');
				$this->InternalAuditPlanBranch->save($this->request->data['InternalAuditPlanBranch'], false);
			    
			    
				$this->loadModel('InternalAuditPlanDepartment');
				foreach($this->request->data['InternalAuditPlanDepartment'] as $val){
					
					$this->InternalAuditPlanDepartment->create();
					$val['internal_audit_plan_id'] = $this->InternalAuditPlan->id;
					$val['branchid']=$this->request->data['InternalAuditPlan']['branchid'];
					$val['departmentid']=$this->request->data['InternalAuditPlan']['departmentid'];
					$val['created_by']=$this->Session->read('User.id');
					$val['modified_by']=$this->Session->read('User.id');
					$this->InternalAuditPlanDepartment->save($val, false); 
				}
			    
			   
				if($this->_show_approvals()){
					$this->loadModel('Approval');
					$this->Approval->create();
					$this->request->data['Approval']['model_name']='InternalAuditPlan';
					$this->request->data['Approval']['controller_name']=$this->request->params['controller'];
					$this->request->data['Approval']['from']=$this->Session->read('User.id');
					$this->request->data['Approval']['user_id']=$this->request->data['Approval']['user_id'];
					$this->request->data['Approval']['created_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['modified_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['record']=$this->InternalAuditPlan->id;
					$this->Approval->save($this->request->data['Approval']);
				}
				$this->Session->setFlash(__('The internal audit plan has been saved'));
				if($this->_show_evidence() == true)$this->redirect(array('action' => 'view',$id));
				else $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The internal audit plan could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('InternalAuditPlan.' . $this->InternalAuditPlan->primaryKey => $id));
			$this->request->data = $this->InternalAuditPlan->find('first', $options);
		}
		$listOfTrainedInternalAuditors = $this->InternalAuditPlan->ListOfTrainedInternalAuditor->find('list',array('conditions'=>array('ListOfTrainedInternalAuditor.publish'=>1,'ListOfTrainedInternalAuditor.soft_delete'=>0)));
		$systemTables = $this->InternalAuditPlan->SystemTable->find('list',array('conditions'=>array('SystemTable.publish'=>1,'SystemTable.soft_delete'=>0)));
		$masterListOfFormats = $this->InternalAuditPlan->MasterListOfFormat->find('list',array('conditions'=>array('MasterListOfFormat.publish'=>1,'MasterListOfFormat.soft_delete'=>0)));
		$createdBies = $this->InternalAuditPlan->CreatedBy->find('list',array('conditions'=>array('CreatedBy.publish'=>1,'CreatedBy.soft_delete'=>0)));
		$modifiedBies = $this->InternalAuditPlan->ModifiedBy->find('list',array('conditions'=>array('ModifiedBy.publish'=>1,'ModifiedBy.soft_delete'=>0)));
		$this->set(compact('listOfTrainedInternalAuditors', 'systemTables', 'masterListOfFormats', 'createdBies', 'modifiedBies'));
		$count = $this->InternalAuditPlan->find('count');
		$published = $this->InternalAuditPlan->find('count',array('conditions'=>array('InternalAuditPlan.publish'=>1)));
		$unpublished = $this->InternalAuditPlan->find('count',array('conditions'=>array('InternalAuditPlan.publish'=>0)));
		
		$this->set(compact('count','published','unpublished'));
		
		
		//Edit by ruchita
		$this->set('branches', $this->InternalAuditPlan->InternalAuditPlanBranch->Branch->find('list'));
		$this->set('employees', $this->InternalAuditPlan->InternalAuditPlanBranch->Employee->find('list'));
	
		$listOfTrainedInternalAuditors= $this->InternalAuditPlan->ListOfTrainedInternalAuditor->find("list", array(
		    "joins" => array(
			array(
			    "table" => "employees",
			    "alias" => "Employees",
			    "type" => "LEFT",
			    "conditions" => array(
				"ListOfTrainedInternalAuditor.employee_id = Employees.id"
			    )
			)
		    ),
		    'fields' => array('ListOfTrainedInternalAuditor.id', 'Employees.name'),
		    'conditions' => array(
		    'ListOfTrainedInternalAuditor.publish'=>1,'ListOfTrainedInternalAuditor.soft_delete'=>0
		)));
		$this->set('listOfTrainedInternalAuditors', $listOfTrainedInternalAuditors);
		$this->set('departments', $this->InternalAuditPlan->InternalAuditPlanDepartment->Department->find('list'));
		
    
		$internalAuditPlanBranch = $this->InternalAuditPlan->InternalAuditPlanBranch->find('all',array('conditions'=>array('InternalAuditPlanBranch.internal_audit_plan_id'=>$id,'InternalAuditPlanBranch.soft_delete'=>0)));
		$internalAuditPlanDepartment = $this->InternalAuditPlan->InternalAuditPlanDepartment->find('all',array('conditions'=>array('InternalAuditPlanDepartment.internal_audit_plan_id'=>$id,'InternalAuditPlanDepartment.soft_delete'=>0)));
		
		$this->request->data['InternalAuditPlanBranch'] = count($internalAuditPlanBranch)? $internalAuditPlanBranch[0]['InternalAuditPlanBranch']:'';
		$this->request->data['InternalAuditPlanDepartment'] = array();
		foreach($internalAuditPlanDepartment as $val){
		    $this->request->data['InternalAuditPlanDepartment'][] = $val['InternalAuditPlanDepartment'];
		}
		$this->render('edit_custom');
		
	}
public function add_branches(){
	
	$this->set('branches', $this->InternalAuditPlan->InternalAuditPlanBranch->Branch->find('list'));
	$this->set('employees', $this->InternalAuditPlan->InternalAuditPlanBranch->Employee->find('list'));
	
	$listOfTrainedInternalAuditors= $this->InternalAuditPlan->ListOfTrainedInternalAuditor->find("list", array(
        "joins" => array(
            array(
                "table" => "employees",
                "alias" => "Employees",
                "type" => "LEFT",
                "conditions" => array(
                    "ListOfTrainedInternalAuditor.employee_id = Employees.id"
                )
            )
        ),
	 'fields' => array('ListOfTrainedInternalAuditor.id', 'Employees.name'),
        'conditions' => array(
            'ListOfTrainedInternalAuditor.publish'=>1,'ListOfTrainedInternalAuditor.soft_delete'=>0
        )
    ));
	$this->set('listOfTrainedInternalAuditors', $listOfTrainedInternalAuditors);

	$this->render('add_branches');
    }
    
    public function add_departments($i = null){
	$this->set('branches', $this->InternalAuditPlan->InternalAuditPlanBranch->Branch->find('list'));
	$this->set('departments', $this->InternalAuditPlan->InternalAuditPlanDepartment->Department->find('list'));
	$this->set('employees', $this->InternalAuditPlan->InternalAuditPlanDepartment->Employee->find('list'));
	
	$listOfTrainedInternalAuditors= $this->InternalAuditPlan->ListOfTrainedInternalAuditor->find("list", array(
        "joins" => array(
            array(
                "table" => "employees",
                "alias" => "Employees",
                "type" => "LEFT",
                "conditions" => array(
                    "ListOfTrainedInternalAuditor.employee_id = Employees.id"
                )
            )
        ),
	 'fields' => array('ListOfTrainedInternalAuditor.id', 'Employees.name'),
        'conditions' => array(
            'ListOfTrainedInternalAuditor.publish'=>1,'ListOfTrainedInternalAuditor.soft_delete'=>0
        )
    ));
	$this->set('listOfTrainedInternalAuditors', $listOfTrainedInternalAuditors);
	$this->set('i', $i);
	$this->render('add_departments');
    }
        

<?php } ?>

<?php if($currentModelName == 'NotificationUser'){ ?>

public function display_notifications() {
		
		//$conditions = $this->_check_request();
		$conditions = array('NotificationUser.user_id'=>$this->Session->read('User.id'));
		$this->paginate = array('limit'=>1,'order'=>array('NotificationUser.sr_no'=>'DESC'),'conditions'=>array($conditions,'NotificationUser.soft_delete'=>0));
	
		$this->NotificationUser->recursive = 0;
		$this->set('notificationUsers', $this->paginate());
		
		$this->_get_count();
	}
<?php } ?>

<?php if($currentModelName == 'Meeting'){ ?>

public function add_ajax() {
	
		if($this->_show_approvals()){
			$this->loadModel('User');
			$this->User->recursive = 0;
			$userids = $this->User->find('list',array('order'=>array('User.name'=>'ASC'),'conditions'=>array('User.publish'=>1,'User.soft_delete'=>0)));
			$this->set(array('userids'=>$userids,'show_approvals'=>$this->_show_approvals()));
		}
		
		if ($this->request->is('post')) {
                        $this->request->data['Meeting']['system_table_id'] = $this->_getSystemtableid();
			$this->request->data['Meeting']['employee_by'] = $this->request->data['Meeting']['employees'];
			$this->Meeting->create();
			
			//print_r($this->request->data['Meeting']);die;
			if ($this->Meeting->save($this->request->data, false)) {
			    
			        $this->loadModel('MeetingTopic');
				foreach($this->request->data['MeetingTopic'] as $val){
					$this->MeetingTopic->create();
					$val['meeting_id'] = $this->Meeting->id;
					$val['title'] = $val['topic'];
					$val['branchid']=$this->request->data['Meeting']['branchid'];
					$val['departmentid']=$this->request->data['Meeting']['departmentid'];
					$val['created_by']=$this->Session->read('User.id');
					$val['modified_by']=$this->Session->read('User.id');
					$this->MeetingTopic->save($val, false); 
				}
				

				if($this->_show_approvals()){
					$this->loadModel('Approval');
					$this->Approval->create();
					$this->request->data['Approval']['model_name']='Meeting';
					$this->request->data['Approval']['controller_name']=$this->request->params['controller'];
					$this->request->data['Approval']['user_id']=$this->request->data['Approval']['user_id'];
					$this->request->data['Approval']['from']=$this->Session->read('User.id');
					$this->request->data['Approval']['created_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['modified_by']=$this->Session->read('User.id');
					$this->request->data['Approval']['record']=$this->Meeting->id;
					$this->Approval->save($this->request->data['Approval']);
				}
				$this->Session->setFlash(__('The meeting has been saved'));
				if($this->_show_evidence() == true)$this->redirect(array('action' => 'view',$this->Meeting->id));
				else $this->redirect(str_replace('/lists','/add_ajax',$this->referer()));
			} else {
				$this->Session->setFlash(__('The meeting could not be saved. Please, try again.'));
			}
		}
		$systemTables = $this->Meeting->SystemTable->find('list',array('conditions'=>array('SystemTable.publish'=>1,'SystemTable.soft_delete'=>0)));
		$masterListOfFormats = $this->Meeting->MasterListOfFormat->find('list',array('conditions'=>array('MasterListOfFormat.publish'=>1,'MasterListOfFormat.soft_delete'=>0)));
		$createdBies = $this->Meeting->CreatedBy->find('list',array('conditions'=>array('CreatedBy.publish'=>1,'CreatedBy.soft_delete'=>0)));
		$modifiedBies = $this->Meeting->ModifiedBy->find('list',array('conditions'=>array('ModifiedBy.publish'=>1,'ModifiedBy.soft_delete'=>0)));
				$this->set(compact('systemTables', 'masterListOfFormats', 'createdBies', 'modifiedBies'));
	$count = $this->Meeting->find('count');
	$published = $this->Meeting->find('count',array('conditions'=>array('Meeting.publish'=>1)));
	$unpublished = $this->Meeting->find('count',array('conditions'=>array('Meeting.publish'=>0)));
	$this->set('employees', $this->Meeting->MeetingEmployee->Employee->find('list'));
		
	$this->set(compact('count','published','unpublished'));
	$this->render('add_custom');

	}
	
    
    
    
    public function add_meeting_topics($i = null){
	$this->set('i', $i);
	$this->render('add_meeting_topics');
    }

    
    

<?php } ?>

<?php if($currentModelName == 'Timelines'){ ?>
public function data_json(){
    $this->layout = "ajax";
    $timelines = $this->Timeline->find('all');
    $i=0;
    foreach($timelines as $timeline_data):
	// convert data into timeline.js pattern
	$date[$i]['startDate'] = date('Y,m,d',strtotime($timeline_data['Timeline']['start_date']));
	$date[$i]['endDate'] = date('Y,n,d',strtotime($timeline_data['Timeline']['end_date']));
	$date[$i]['headline'] = $timeline_data['Timeline']['title'];
	$date[$i]['text'] = $timeline_data['Timeline']['message'];
	$date[$i]['asset'] = null;
	$i++;
    endforeach;
    $timeline = null;
    $company_name = $this->_get_company();
    $timeline['headline']= $company_name['Company']['name'];
    $timeline['type'] = "default";
    $timeline["text"]='FlinkISO Timeline for variouse ISO & Quality related activities';
    $timeline["startDate"]=date('Y,m,d');
    $timeline['date'] = $date;
    $this->set('timeline',array('timeline'=>$timeline));
 }
 
 public function timeline() {}

<?php } ?>

<?php if($currentModelName == 'Histories') { ?>
public function graph_data($startDate = null, $endDate=null){
		
		$this->layout = "ajax";
		if(!$startDate)$startDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'asc')));
		if(!$endDate)$endDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'desc')));
		$date = date("Y-m-d",strtotime($startDate['History']['created']));
		$end_date = date("Y-m-d",strtotime($endDate['History']['created']));
		
		while (strtotime($date) <= strtotime($end_date)) {
			$count = $this->History->find('count',array('conditions'=>array('or'=>array('History.action'=>'add','History.action'=>'add_ajax'),'History.created >'=>$date.":00:00:000",'History.created < '=>$date.":23:59:000" )));
			$output[] = array('count'=>$count,'date'=>$date);
			$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
			
		}
		$this->set('output',$output);
		return true;
	}
	
	public function graph_data_departments($startDate = null, $endDate=null){
		
		$this->layout = "ajax";
		if(!$startDate)$startDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'asc')));
		if(!$endDate)$endDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'desc')));
		$date = date("Y-m-d",strtotime($startDate['History']['created']));
		$end_date = date("Y-m-d",strtotime($endDate['History']['created']));
		
		$departments = $this->_get_department_list();
		
		foreach($departments as $key => $value):
			$count = $this->History->find('count',array('conditions'=>array('or'=>array('History.action'=>'add','History.action'=>'add_ajax'),'History.departmentid'=>$key)));
		//	echo json_encode($count);
			$output[] = array('count'=>$count,'department'=>$value);
			
		endforeach;
		$this->set('output',$output);
		
	}
	
	
	public function graph_data_branches($startDate = null, $endDate=null){
		
		$this->layout = "ajax";
		if(!$startDate)$startDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'asc')));
		if(!$endDate)$endDate=$this->History->find('first',array('fields'=>array('History.created'),'order'=>array('History.created'=>'desc')));
		$date = date("Y-m-d",strtotime($startDate['History']['created']));
		$end_date = date("Y-m-d",strtotime($endDate['History']['created']));
		
		$branches = $this->_get_branch_list();
		
		foreach($branches as $key => $value):
			$count = $this->History->find('count',array('conditions'=>array('or'=>array('History.action'=>'add','History.action'=>'add_ajax'),'History.branchid'=>$key)));
			$output[] = array('count'=>$count,'branch'=>$value);
			
		endforeach;
		$this->set('output',$output);

	}
	

<?php } ?>
