<?php

App::uses('AppController', 'Controller');

/**
 * CustomTemplates Controller
 *
 * @property CustomTemplate $CustomTemplate
 */
class CustomTemplatesController extends AppController {

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $sys_id = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $sys_id['SystemTable']['id'];
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('CustomTemplate.sr_no' => 'DESC'), 'conditions' => array($conditions));

        $this->CustomTemplate->recursive = 0;
        $this->set('customTemplates', $this->paginate());

        $this->_get_count();
    }

    /**
     * adcanced_search method
     * Advanced search by - TGS
     * @return void
     */
    public function advanced_search() {

        $conditions = array();
        if ($this->request->data['Search']['keywords']) {
            $search_array = array();
            $search_keys = explode(" ", $this->request->data['Search']['keywords']);

            foreach ($search_keys as $search_key):
                foreach ($this->request->data['Search']['search_fields'] as $search):
                    if ($this->request->data['Search']['strict_search'] == 0)
                        $search_array[] = array('CustomTemplate.' . $search => $search_key);
                    else
                        $search_array[] = array('CustomTemplate.' . $search . ' like ' => '%' . $search_key . '%');

                endforeach;
            endforeach;
            if ($this->request->data['Search']['strict_search'] == 0)
                $conditions[] = array('and' => $search_array);
            else
                $conditions[] = array('or' => $search_array);
        }

        if ($this->request->data['Search']['branch_list']) {
            foreach ($this->request->data['Search']['branch_list'] as $branches):
                $branch_conditions[] = array('CustomTemplate.branch_id' => $branches);
            endforeach;
            $conditions[] = array('or' => $branch_conditions);
        }

        if (!$this->request->data['Search']['to-date'])
            $this->request->data['Search']['to-date'] = date('Y-m-d');
        if ($this->request->data['Search']['from-date']) {
            $conditions[] = array('CustomTemplate.created >' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['from-date'])), 'CustomTemplate.created <' => date('Y-m-d h:i:s', strtotime($this->request->data['Search']['to-date'])));
        }
        unset($this->request->data['Search']);


        if ($this->Session->read('User.is_mr') == 0 && $branchIDYes == true)
            $onlyBranch = array('CustomTemplate.branch_id' => $this->Session->read('User.branch_id'));
        if ($this->Session->read('User.is_view_all') == 0)
            $onlyOwn = array('CustomTemplate.created_by' => $this->Session->read('User.id'));
        $conditions[] = array($onlyBranch, $onlyOwn);

        $this->CustomTemplate->recursive = 0;
        $this->paginate = array('order' => array('CustomTemplate.sr_no' => 'DESC'), 'conditions' => $conditions, 'CustomTemplate.soft_delete' => 0);
        $this->set('customTemplates', $this->paginate());

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
        if (!$this->CustomTemplate->exists($id)) {
            throw new NotFoundException(__('Invalid custom template'));
        }
        $options = array('conditions' => array('CustomTemplate.' . $this->CustomTemplate->primaryKey => $id));
        $this->set('customTemplate', $this->CustomTemplate->find('first', $options));
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
    public function add_ajax($id = null, $text = null) {
        if (!$id) {

            if ($this->_show_approvals()) {
                $this->loadModel('User');
                $this->User->recursive = 0;
                $userids = $this->User->find('list', array('order' => array('User.name' => 'ASC'), 'conditions' => array('User.publish' => 1, 'User.soft_delete' => 0)));
                $this->set(array('userids' => $userids, 'show_approvals' => $this->_show_approvals()));
            }

            $this->loadModel('MasterListOfFormat');
            $sys_table = $this->MasterListOfFormat->find('first', array('conditions' => array('MasterListOfFormat.id' => $this->request->data['CustomTemplate']['master_list_of_format_id'])));
            $sys_table = $sys_table['SystemTable'];

            $remove_url = str_replace('add_ajax', '', Router::url());

            $header = $this->request->data['CustomTemplate']['header'];
            $header = str_replace($remove_url, "", $header);
            $header = str_replace('<a class="badge label-info add-margin" href="http://localhost', '', $header);
            $header = str_replace('<a class="badge label-info add-margin" href="', '', $header);
            $header = str_replace('&lt;', '<', $header);
            $header = str_replace('&gt;', '>', $header);
            $header = str_replace('%3C', '<', $header);
            $header = str_replace('%3E">', '>', $header);
            $header = str_replace('%3E', '>', $header);
            $header = str_replace('>">', '>', $header);



            $template = $this->request->data['CustomTemplate']['template_body'];
            $template = str_replace($remove_url, "", $template);
            $template = str_replace('<a class="badge label-info add-margin" href="http://localhost', '', $template);
            $template = str_replace('&lt;', ' <', $template);
            $template = str_replace('&gt;', '> ', $template);
            $template = str_replace('</a></td>', '', $template);
            $template = str_replace('%3C', ' <', $template);
            $template = str_replace('%3E">', '> ', $template);
            $template = str_replace('%3E', '> ', $template);
            $template = str_replace('>"> ', '> ', $template);
            $template = str_replace('</FlinkISO>', ' </FlinkISO> </td>', $template);

            //get only first row
            $first_row = explode('</tr>', $template);
            $second_row = $first_row[1];
            $first_row = $first_row[0] . "</tr>";
            $second_row = $second_row . "</tr>";

            $footer = $this->request->data['CustomTemplate']['footer'];
            $footer = str_replace($remove_url, "", $footer);
            $footer = str_replace('<a class="badge label-info add-margin" href="http://localhost', '', $template);
            $footer = str_replace('&lt;', ' <', $footer);
            $footer = str_replace('&gt;', '> ', $footer);
            $footer = str_replace('</a></td>', ' ', $footer);
            $footer = str_replace('%3C', ' <', $footer);
            $footer = str_replace('%3E">', '> ', $footer);
            $footer = str_replace('%3E', '> ', $footer);
            $footer = str_replace('>">', '> ', $footer);
            $footer = str_replace('</FlinkISO>', ' </FlinkISO> </td>', $footer);


            $this->request->data['CustomTemplate']['details'] = $header . $template . $footer;

            if ($this->request->is('post')) {
                $get_system_table_id = $this->CustomTemplate->MasterListOfFormat->find('first', array('conditions' => array('MasterListOfFormat.id' => $this->request->data['CustomTemplate']['master_list_of_format_id'])));

                $this->request->data['CustomTemplate']['system_table_id'] = $get_system_table_id['SystemTable']['id'];
                $this->CustomTemplate->create();
                if ($this->CustomTemplate->save($this->request->data)) {

                    if ($this->_show_approvals()) {
                        $this->loadModel('Approval');
                        $this->Approval->create();
                        $this->request->data['Approval']['model_name'] = 'CustomTemplate';
                        $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                        $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                        $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                        $this->request->data['Approval']['created_by'] = $this->Session->read('User.id');
                        $this->request->data['Approval']['modified_by'] = $this->Session->read('User.id');
                        $this->request->data['Approval']['record'] = $this->CustomTemplate->id;
                        $this->Approval->save($this->request->data['Approval']);
                    }
                    $this->Session->setFlash(__('The custom template has been saved'));
                    if ($this->_show_evidence() == true)
                        $this->redirect(array('action' => 'view', $this->CustomTemplate->id));
                    else
                        $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The custom template could not be saved. Please, try again.'));
                }
            }
            $systemTables = $this->CustomTemplate->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
            $masterListOfFormats = $this->CustomTemplate->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
            $schedules = $this->CustomTemplate->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));

            $this->set(compact('systemTables', 'masterListOfFormats', 'schedules'));
            $count = $this->CustomTemplate->find('count');
            $published = $this->CustomTemplate->find('count', array('conditions' => array('CustomTemplate.publish' => 1)));
            $unpublished = $this->CustomTemplate->find('count', array('conditions' => array('CustomTemplate.publish' => 0)));


            $this->set(compact('count', 'published', 'unpublished'));
        } else {

        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {

        if (!$this->CustomTemplate->exists($id)) {
            throw new NotFoundException(__('Invalid custom template'));
        }
        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }


        if ($this->request->is('post') || $this->request->is('put')) {

            $this->CustomTemplate->read(null, $id);
            $get_system_table_id = $this->CustomTemplate->MasterListOfFormat->find('first', array('conditions' => array('MasterListOfFormat.id' => $this->request->data['CustomTemplate']['master_list_of_format_id'])));

            $this->request->data['CustomTemplate']['system_table_id'] = $get_system_table_id['SystemTable']['id'];
            if ($this->CustomTemplate->save($this->request->data, false)) {
                if ($this->_show_approvals()) {
                    $this->loadModel('Approval');
                    $this->Approval->create();
                    $this->request->data['Approval']['model_name'] = 'CustomTemplate';
                    $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                    $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                    $this->request->data['Approval']['created_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['modified_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['record'] = $this->CustomTemplate->id;
                    $this->Approval->save($this->request->data['Approval']);
                }
                $this->Session->setFlash(__('The custom template has been saved'));
                if ($this->_show_evidence() == true)
                    $this->redirect(array('action' => 'view', $id));
                else
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The custom template could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CustomTemplate.' . $this->CustomTemplate->primaryKey => $id));
            $this->request->data = $this->CustomTemplate->find('first', $options);
        }
        $systemTables = $this->CustomTemplate->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->CustomTemplate->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $schedules = $this->CustomTemplate->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));

        $this->set(compact('systemTables', 'masterListOfFormats', 'schedules'));
        $this->set(compact('systemTables', 'masterListOfFormats', 'createdBies', 'modifiedBies'));
        $count = $this->CustomTemplate->find('count');
        $published = $this->CustomTemplate->find('count', array('conditions' => array('CustomTemplate.publish' => 1)));
        $unpublished = $this->CustomTemplate->find('count', array('conditions' => array('CustomTemplate.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished'));

        $this->get_fields($this->data['CustomTemplate']['master_list_of_format_id'], 'noAjax');
    }

    /**
     * approve method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function approve($id = null, $approval_id = null) {
        if (!$this->CustomTemplate->exists($id)) {
            throw new NotFoundException(__('Invalid custom template'));
        }

        $this->loadModel('Approval');
        if (!$this->Approval->exists($approval_id)) {
            throw new NotFoundException(__('Invalid approval id'));
        }

        $approval = $this->Approval->read(null, $approval_id);
        $this->set('same', $approval['Approval']['user_id']);

        if ($this->_show_approvals()) {
            $this->set(array('showApprovals' => $this->_show_approvals()));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->CustomTemplate->save($this->request->data)) {
                if ($this->request->data['CustomTemplate']['publish'] == 0 && $this->_show_approvals()) {
                    $this->loadModel('Approval');
                    $this->Approval->create();
                    $this->request->data['Approval']['model_name'] = 'CustomTemplate';
                    $this->request->data['Approval']['controller_name'] = $this->request->params['controller'];
                    $this->request->data['Approval']['from'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['user_id'] = $this->request->data['Approval']['user_id'];
                    $this->request->data['Approval']['created_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['modified_by'] = $this->Session->read('User.id');
                    $this->request->data['Approval']['record'] = $this->CustomTemplate->id;
                    $this->Approval->save($this->request->data['Approval']);

                    $this->Session->setFlash(__('The custom template has been saved'));
                } else {
                    $this->Approval->read(null, $approval_id);
                    $data['Approval']['status'] = 'Approved';
                    $data['Approval']['modified_by'] = $this->Session->read('User.id');
                    $this->Approval->save($data);
                    $this->Session->setFlash(__('The branch has been published'));
                }
                $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            } else {
                $this->Session->setFlash(__('The custom template could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('CustomTemplate.' . $this->CustomTemplate->primaryKey => $id));
            $this->request->data = $this->CustomTemplate->find('first', $options);
        }
        $systemTables = $this->CustomTemplate->SystemTable->find('list', array('conditions' => array('SystemTable.publish' => 1, 'SystemTable.soft_delete' => 0)));
        $masterListOfFormats = $this->CustomTemplate->MasterListOfFormat->find('list', array('conditions' => array('MasterListOfFormat.publish' => 1, 'MasterListOfFormat.soft_delete' => 0)));
        $createdBies = $this->CustomTemplate->CreatedBy->find('list', array('conditions' => array('CreatedBy.publish' => 1, 'CreatedBy.soft_delete' => 0)));
        $modifiedBies = $this->CustomTemplate->ModifiedBy->find('list', array('conditions' => array('ModifiedBy.publish' => 1, 'ModifiedBy.soft_delete' => 0)));
        $this->set(compact('systemTables', 'masterListOfFormats', 'createdBies', 'modifiedBies'));
        $count = $this->CustomTemplate->find('count');
        $published = $this->CustomTemplate->find('count', array('conditions' => array('CustomTemplate.publish' => 1)));
        $unpublished = $this->CustomTemplate->find('count', array('conditions' => array('CustomTemplate.publish' => 0)));

        $this->set(compact('count', 'published', 'unpublished'));
    }

    public function get_fields($id = null, $noAjax = null) {
        if ($noAjax != 'noAjax')
            $this->layout = 'ajax';
        $form_details = $this->CustomTemplate->MasterListOfFormat->find('first', array('conditions' => array('MasterListOfFormat.id' => $id)));

        $sys_table_name = $form_details['SystemTable']['system_name'];
        $sys_table_name = Inflector::Classify($sys_table_name);

        $this->loadModel($sys_table_name);
        $form_schema = $this->$sys_table_name->schema();
        unset($form_schema['id']);
        unset($form_schema['sr_no']);
        unset($form_schema['publish']);
        unset($form_schema['soft_delete']);
        unset($form_schema['branchid']);
        unset($form_schema['departmentid']);
        unset($form_schema['modified_by']);
        unset($form_schema['created_by']);
        unset($form_schema['created']);
        unset($form_schema['modified']);
        unset($form_schema['modified_by']);
        unset($form_schema['system_table_id']);
        unset($form_schema['master_list_of_format_id']);

        $associated_forms = $this->$sys_table_name->belongsTo;


        unset($associated_forms['BranchIds']);
        unset($associated_forms['DepartmentIds']);
        unset($associated_forms['SystemTable']);


        foreach ($associated_forms as $associated_form => $values):

            $this->loadModel($associated_form);
            $associated_form_schemas[$associated_form] = $this->$associated_form->schema();
            unset($associated_form_schemas[$associated_form]['id']);
            unset($associated_form_schemas[$associated_form]['sr_no']);
            unset($associated_form_schemas[$associated_form]['publish']);
            unset($associated_form_schemas[$associated_form]['soft_delete']);
            unset($associated_form_schemas[$associated_form]['branchid']);
            unset($associated_form_schemas[$associated_form]['departmentid']);
            unset($associated_form_schemas[$associated_form]['modified_by']);
            unset($associated_form_schemas[$associated_form]['created_by']);
            unset($associated_form_schemas[$associated_form]['created']);
            unset($associated_form_schemas[$associated_form]['modified']);
            unset($associated_form_schemas[$associated_form]['modified_by']);
            unset($associated_form_schemas[$associated_form]['system_table_id']);
            unset($associated_form_schemas[$associated_form]['master_list_of_format_id']);
        endforeach;


        $hasMany_forms = $this->$sys_table_name->hasMany;


        unset($hasMany_forms['BranchIds']);
        unset($hasMany_forms['DepartmentIds']);
        unset($hasMany_forms['SystemTable']);


        foreach ($hasMany_forms as $hasMany_form => $values):

            $this->loadModel($hasMany_form);
            $hasMany_form_schemas[$hasMany_form] = $this->$hasMany_form->schema();
            unset($hasMany_form_schemas[$hasMany_form]['id']);
            unset($hasMany_form_schemas[$hasMany_form]['sr_no']);
            unset($hasMany_form_schemas[$hasMany_form]['publish']);
            unset($hasMany_form_schemas[$hasMany_form]['soft_delete']);
            unset($hasMany_form_schemas[$hasMany_form]['branchid']);
            unset($hasMany_form_schemas[$hasMany_form]['departmentid']);
            unset($hasMany_form_schemas[$hasMany_form]['modified_by']);
            unset($hasMany_form_schemas[$hasMany_form]['created_by']);
            unset($hasMany_form_schemas[$hasMany_form]['created']);
            unset($hasMany_form_schemas[$hasMany_form]['modified']);
            unset($hasMany_form_schemas[$hasMany_form]['modified_by']);
            unset($hasMany_form_schemas[$hasMany_form]['system_table_id']);
            unset($hasMany_form_schemas[$hasMany_form]['master_list_of_format_id']);
        endforeach;

        $this->set(compact('form_details', 'form_schema', 'associated_forms', 'associated_form_schemas', 'sys_table_name', 'hasMany_froms', 'hasMany_form_schemas'));
    }

}
