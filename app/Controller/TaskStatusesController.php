<?php

App::uses('AppController', 'Controller');

/**
 * TaskStatuses Controller
 *
 * @property TaskStatus $TaskStatus
 */
class TaskStatusesController extends AppController {

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $systemTableId['SystemTable']['id'];
    }

    public function index($span = null, $report = false, $reportFromDate = null, $reportToDate = null) {

        if ($report) {
            $from = $reportFromDate;
            $to = $reportToDate;
        } else if ($this->request->data) {
            $from = $this->request['data']['TaskStatus']['from_date'];
            $to = $this->request['data']['TaskStatus']['to_date'];
        }

        if (isset($this->request->data) && $this->request['data']['TaskStatus']['user_id'] != -1) {
            $userCondition = array('Task.user_id' => $this->request['data']['TaskStatus']['user_id']);
        } else {
            $userCondition = null;
        }
        $taskAssigned = 0;
        $taskPerformed = 0;

        $this->loadModel('Schedule');
        $schedulesList = $this->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));

        $this->loadModel('Task');
        $this->Task->recursive = 0;
        $schedules = array();
        if ($from) {
            foreach ($schedulesList as $key => $value):
                if ($value == 'dailly' || $value == 'daily' || $value == 'Dailly' || $value == 'Daily') {
                    while ($from <= $to) {
                        $schedules[$value][$from] = $this->Task->find('all', array(
                            'conditions' => array('Task.publish' => 1, 'Task.soft_delete' => 0, 'Task.schedule_id' => $key,
                                'Task.created < ' => date('Y-m-d 59:59:59', strtotime($from)),
                                $userCondition),
                            'order' => array('MasterListOfFormat.title' => 'Desc'),
                            'recursive' => 0,
                            'fields' => array('Task.id','Task.name', 'MasterListOfFormat.title', 'User.name')));

                        $i = 0;
                        foreach ($schedules[$value][$from] as $task):
                            $taskStatus = $this->TaskStatus->find('first', array(
                                'conditions' => array(
                                    'TaskStatus.task_date' => $from,
                                    'TaskStatus.task_id' => $task['Task']['id'])));
                            $schedules[$value][$from][$i]['TaskStatus'] = isset($taskStatus['TaskStatus']) ? $taskStatus['TaskStatus']: '';
                            if (isset($taskStatus['TaskStatus']) && $taskStatus['TaskStatus']['task_performed'])
                                $taskPerformed++;
                            $i++;
                            $taskAssigned++;
                        endforeach;
                        $from = date("Y-m-d", strtotime("+1 day", strtotime($from)));
                    }

                    if ($report) {
                        $from = $reportFromDate;
                    } else {
                        $from = $this->request['data']['TaskStatus']['from_date'];
                    }
                } else if ($value == 'weekly' || $value == 'Weekly') {
                    $startDateUnix = strtotime($from);
                    $endDateUnix = strtotime($to);
                    $currentDateUnix = $startDateUnix;
                    $weekNumbers = array();
                    while ($currentDateUnix < $endDateUnix) {
                        $year = date('Y', $currentDateUnix);
                        $weekNumbers[$year][] = date('W', $currentDateUnix);
                        $currentDateUnix = strtotime('+1 week', $currentDateUnix);
                    }
                    foreach ($weekNumbers as $yy => $yweek) {
                        foreach ($yweek as $ww) {
                            $schedules[$value][$yy . '-Week-' . $ww] = $this->Task->find('all', array(
                                'conditions' => array('Task.publish' => 1,
                                    'Task.soft_delete' => 0,
                                    'Task.schedule_id' => $key,
                                    array("OR" => array("AND" => array(
                                                "WEEK(Task.created) <=" => $ww,
                                                "YEAR(Task.created) =" => $yy),
                                            array("YEAR(Task.created) <" => $yy))),
                                    $userCondition),
                                'fields' => array(
                                    'Task.id',
                                    'Task.name',
                                    'MasterListOfFormat.title',
                                    'User.name',
                            )));
                            $i = 0;
                            foreach ($schedules[$value][$yy . '-Week-' . $ww] as $task):
                                $schedules[$value][$yy . '-Week-' . $ww][$i]['TaskStatus'] = null;
                                $taskStatus = $this->TaskStatus->find('first', array(
                                    'conditions' => array(
                                        'WEEK(TaskStatus.task_date)' => $ww,
                                        'YEAR(TaskStatus.task_date)' => $yy,
                                        'TaskStatus.task_id' => $task['Task']['id'])));
                                $schedules[$value][$yy . '-Week-' . $ww][$i]['TaskStatus'] = isset($taskStatus['TaskStatus']) ? $taskStatus['TaskStatus']: '';
                                if (isset($taskStatus['TaskStatus']) && $taskStatus['TaskStatus']['task_performed'])
                                    $taskPerformed++;
                                $i++;
                                $taskAssigned++;
                            endforeach;
                        }
                    }
                }else if ($value == 'monthly' || $value == 'Monthly') {
                    $startDateUnix = strtotime($from);
                    $endDateUnix = strtotime($to);
                    $currentDateUnix = $startDateUnix;
                    $monthNumbers = array();
                    while ($currentDateUnix < $endDateUnix) {
                        $year = date('Y', $currentDateUnix);
                        $monthNumbers[$year][] = IntVal(date('m', $currentDateUnix));
                        $currentDateUnix = strtotime('+1 month', $currentDateUnix);
                    }

                    foreach ($monthNumbers as $yy => $ymonth) {
                        foreach ($ymonth as $ww) {
                            $schedules[$value][$yy . '-Month-' . $ww] = $this->Task->find('all', array(
                                'conditions' => array('Task.publish' => 1, 'Task.soft_delete' => 0, 'Task.schedule_id' => $key,
                                    array("OR" => array("AND" => array("MONTH(Task.created) <=" => $ww,
                                                "YEAR(Task.created) =" => $yy), array("YEAR(Task.created) <" => $yy))), $userCondition,
                                ),
                                'fields' => array(
                                    'Task.id',
                                    'Task.name',
                                    'MasterListOfFormat.title',
                                    'User.name',
                                )
                            ));
                            $i = 0;
                            foreach ($schedules[$value][$yy . '-Month-' . $ww] as $task):
                                $schedules[$value][$yy . '-Month-' . $ww][$i]['TaskStatus'] = null;
                                $taskStatus = $this->TaskStatus->find('first', array(
                                    'conditions' => array(
                                        'MONTH(TaskStatus.task_date) <= ' => $ww,
                                        'YEAR(TaskStatus.task_date) <= ' => $yy,
                                        'TaskStatus.task_id' => $task['Task']['id'])));
                                $schedules[$value][$yy . '-Month-' . $ww][$i]['TaskStatus'] = isset($taskStatus['TaskStatus']) ? $taskStatus['TaskStatus']: '';
                                if (isset($taskStatus['TaskStatus']) && $taskStatus['TaskStatus']['task_performed'])
                                    $taskPerformed++;
                                $i++;
                                $taskAssigned++;
                            endforeach;
                        }
                    }
                }else if ($value == 'quarterly' || $value == 'Quarterly') {
                    $taskDetails = $this->Task->find('all', array(
                        'conditions' => array('Task.publish' => 1, 'Task.soft_delete' => 0, 'Task.schedule_id' => $key,
                            "DATE_FORMAT(Task.created, '%Y-%m-%d') <=" => $to, $userCondition,
                        ),
                        'fields' => array(
                            'Task.id',
                            'Task.name',
                            'Task.created',
                            'MasterListOfFormat.title',
                            'User.name',
                        )
                    ));

                    foreach ($taskDetails as $taskDetail) {
                        $created = date('Y-m-d', strtotime($taskDetail['Task']['created']));
                        $currentDate = date('Y-m-d', strtotime($taskDetail['Task']['created']));
                        $lastQuarter = $to;
                        $nextQuarter = $to;

                        $dateArray = array();
                        $k = 0;
                        while ($currentDate <= $lastQuarter) {
                            $nextQuarter = date('Y-m-d', strtotime('+3 month', strtotime($currentDate)));
                            if ($currentDate >= $from) {
                                $dateArray[$k]['currentDate'] = $currentDate;
                                $dateArray[$k]['nextQuarter'] = $nextQuarter;
                                $k++;
                            }
                            $currentDate = $nextQuarter;
                        }
                        $i = 0;
                        foreach ($dateArray as $ww => $quarter) {
                            $cDate = $quarter['currentDate'];
                            $nextQuarter = $quarter['nextQuarter'];
                            $qNumber = $ww + 1;
                            $schedules[$value]['Quarter-' . $qNumber][$i] = $taskDetail;
                            $schedules[$value]['Quarter-' . $qNumber][$i]['TaskStatus'] = null;
                            $taskStatus = $this->TaskStatus->find('first', array(
                                'conditions' => array(
                                    "DATE_FORMAT(TaskStatus.task_date, '%Y-%m-%d') >=" => $cDate, "DATE_FORMAT(TaskStatus.task_date, '%Y-%m-%d') <=" => $nextQuarter,
                                    'TaskStatus.task_id' => $taskDetail['Task']['id'])));

                            $schedules[$value]['Quarter-' . $qNumber][$i]['TaskStatus'] = isset($taskStatus['TaskStatus']) ? $taskStatus['TaskStatus']: '';
                            if (isset($taskStatus['TaskStatus']) && $taskStatus['TaskStatus']['task_performed'])
                                $taskPerformed++;
                            $i++;
                            $taskAssigned++;
                        }
                    }
                }else if ($value == 'yearly' || $value == 'Yearly') {
                    $startDateUnix = strtotime($from);
                    $endDateUnix = strtotime($to);
                    $currentDateUnix = $startDateUnix;
                    $yearNumbers = array();
                    while ($currentDateUnix < $endDateUnix) {
                        $year = date('Y', $currentDateUnix);
                        $yearNumbers[$year][] = IntVal(date('Y', $currentDateUnix));
                        $currentDateUnix = strtotime('+1 year', $currentDateUnix);
                    }

                    foreach ($yearNumbers as $yy => $yyear) {
                        foreach ($yyear as $ww) {
                            $schedules[$value][$yy . '-Year-' . $ww] = $this->Task->find('all', array(
                                'conditions' => array('Task.publish' => 1, 'Task.soft_delete' => 0, 'Task.schedule_id' => $key,
                                    "YEAR(Task.created) <=" => $yy, $userCondition,
                                ),
                                'fields' => array(
                                    'Task.id',
                                    'Task.name',
                                    'Task.created',
                                    'MasterListOfFormat.title',
                                    'User.name',
                                )
                            ));
                            $i = 0;
                            foreach ($schedules[$value][$yy . '-Year-' . $ww] as $task):
                                $schedules[$value][$yy . '-Year-' . $ww][$i]['TaskStatus'] = null;
                                $taskStatus = $this->TaskStatus->find('first', array(
                                    'conditions' => array(
                                        'YEAR(TaskStatus.task_date) <= ' => $yy,
                                        'TaskStatus.task_id' => $task['Task']['id'])));
                                $schedules[$value][$yy . '-Year-' . $ww][$i]['TaskStatus'] = isset($taskStatus['TaskStatus']) ? $taskStatus['TaskStatus']: '';
                                if (isset($taskStatus['TaskStatus']) && $taskStatus['TaskStatus']['task_performed'])
                                    $taskPerformed++;
                                $i++;
                                $taskAssigned++;
                            endforeach;
                        }
                    }
                }
            endforeach;
        }
        if ($report == true) {
            return $schedules;
        }
        $users = $this->requestAction('App/get_usernames');
	if ($taskPerformed > 0 && $taskAssigned > 0)
            $result = round($taskPerformed * 100 / $taskAssigned);
        else
            $result = 0;
        
        $from = $this->request['data']['TaskStatus']['from_date'];
	
        
      
        $this->set(compact('schedules', 'from', 'to', 'users', 'result'));
    }
}
