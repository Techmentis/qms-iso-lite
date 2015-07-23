<?php

App::uses('AppController', 'Controller');

/**
 * Housekeepings Controller
 *
 * @property Housekeeping $Housekeeping
 */
class HousekeepingsController extends AppController {

    public function _get_system_table_id() {

        $this->loadModel('SystemTable');
        $this->SystemTable->recursive = -1;
        $systemTableId = $this->SystemTable->find('first', array('conditions' => array('SystemTable.system_name' => $this->request->params['controller'])));
        return $systemTableId['SystemTable']['id'];
    }

    /**
     * index method
     *
     * @return void
     */
    public function index($report = false, $reportFromDate = null, $reportToDate = null) {

        if ($report) {
            $fromDate = $reportFromDate;
            $toDate = $reportToDate;
        } else {
            $fromDate = $this->request['data']['Housekeeping']['from_date'];
            $toDate = $this->request['data']['Housekeeping']['to_date'];
        }

        if (isset($this->request->data) && $this->request['data']['Housekeeping']['employee_id'] != -1) {
            $userCondition = array('HousekeepingResponsibility.employee_id' => $this->request['data']['Housekeeping']['employee_id']);
        } else {
            $userCondition = null;
        }
        $taskAssigned = null;
        $taskPerformed = null;

        $this->loadModel('Schedule');
        $schedules = $this->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));

        $this->loadModel('HousekeepingResponsibility');
        $this->HousekeepingResponsibility->recursive = 0;
        $responsibilities = array();
        if ($fromDate) {
            foreach ($schedules as $key => $value):
                if ($value == 'dailly' || $value == 'daily' || $value == 'Dailly' || $value == 'Daily') {
                    while ($fromDate <= $toDate) {
                        $responsibilities[$value][$fromDate] = $this->HousekeepingResponsibility->find('all', array(
                            'conditions' => array(
                                'HousekeepingResponsibility.publish' => 1,
                                'HousekeepingResponsibility.soft_delete' => 0,
                                'HousekeepingResponsibility.schedule_id' => $key,
                                'HousekeepingResponsibility.created < ' => date('Y-m-d 59:59:59', strtotime($fromDate)),
                                $userCondition),
                            'fields' => array(
                                'HousekeepingResponsibility.id',
                                'HousekeepingResponsibility.description',
                                'HousekeepingChecklist.id',
                                'HousekeepingChecklist.title',
                                'Employee.id',
                                'Employee.name')));
                        $i = 0;
                        foreach ($responsibilities[$value][$fromDate] as $responsibility):

                            $responsibilities[$value][$fromDate][$i]['Housekeeping'] = null;

                            $this->loadModel('Housekeeping');
                            $this->Housekeeping->recursive = -1;
                            $taskStatus = $this->Housekeeping->find('first', array(
                                'conditions' => array(
                                    'Housekeeping.housekeeping_responsibility_id' => $responsibility['HousekeepingResponsibility']['id'],
                                    "DATE_FORMAT(Housekeeping.created,'%Y-%m-%d')" => date('Y-m-d', strtotime($fromDate))),
                                'fields' => array(
                                    'Housekeeping.task_performed',
                                    'Housekeeping.comments')));
                            $responsibilities[$value][$fromDate][$i]['Housekeeping'] = isset($taskStatus['Housekeeping']) ? $taskStatus['Housekeeping'] : '' ;
                            if (isset($taskStatus['Housekeeping']) && $taskStatus['Housekeeping']['task_performed'])
                                $taskPerformed++;
                            $i++;
                            $taskAssigned++;
                        endforeach;
                        $fromDate = date("Y-m-d", strtotime("+1 day", strtotime($fromDate)));
                    }

                    if ($report) {
                        $fromDate = $reportFromDate;
                    } else {
                        $fromDate = $this->request['data']['Housekeeping']['from_date'];
                    }
                } else if ($value == 'weekly' || $value == 'Weekly') {

                    $startDateUnix = strtotime($fromDate);
                    $endDateUnix = strtotime($toDate);
                    $currentDateUnix = $startDateUnix;
                    $weekNumbers = array();
                    while ($currentDateUnix < $endDateUnix) {
                        $year = date('Y', $currentDateUnix);
                        $week = date('W', $currentDateUnix);
                        if (isset($lastweek) && isset($lastyear) && $lastweek == 52 && $lastyear == $year) {
                            $year = $year + 1;
                        }
                        $weekNumbers[$year][] = date('W', $currentDateUnix);
                        $currentDateUnix = strtotime('+1 week', $currentDateUnix);
                        $lastweek = $week;
                        $lastyear = $year;
                    }
                    foreach ($weekNumbers as $yy => $yweek) {
                        foreach ($yweek as $ww) {
                            $responsibilities[$value][$yy . '-Week-' . $ww] = $this->HousekeepingResponsibility->find('all', array(
                                'conditions' => array('HousekeepingResponsibility.publish' => 1,
                                    'HousekeepingResponsibility.soft_delete' => 0,
                                    'HousekeepingResponsibility.schedule_id' => $key,
                                    array("OR" => array("AND" => array(
                                                "WEEK(HousekeepingResponsibility.created) <=" => $ww,
                                                "YEAR(HousekeepingResponsibility.created) =" => $yy),
                                            array("YEAR(HousekeepingResponsibility.created) <" => $yy))),
                                    $userCondition),
                                'fields' => array(
                                    'HousekeepingResponsibility.id',
                                    'HousekeepingResponsibility.description',
                                    'HousekeepingChecklist.id',
                                    'HousekeepingChecklist.title',
                                    'Employee.id',
                                    'Employee.name')));
                            $i = 0;
                            foreach ($responsibilities[$value][$yy . '-Week-' . $ww] as $responsibility):
                                $responsibilities[$value][$yy . '-Week-' . $ww][$i]['Housekeeping'] = null;
                                $taskStatus = $this->Housekeeping->find('first', array(
                                    'conditions' => array(
                                        'WEEK(Housekeeping.created)' => $ww,
                                        'YEAR(Housekeeping.created)' => $yy,
                                        'Housekeeping.housekeeping_responsibility_id' => $responsibility['HousekeepingResponsibility']['id'])));
                                $responsibilities[$value][$yy . '-Week-' . $ww][$i]['Housekeeping'] = isset($taskStatus['Housekeeping']) ? $taskStatus['Housekeeping'] : '' ;
                                if (isset($taskStatus['Housekeeping']) && $taskStatus['Housekeeping']['task_performed'])
                                    $taskPerformed++;
                                $i++;
                                $taskAssigned++;
                            endforeach;
                        }
                    }
                } else if ($value == 'monthly' || $value == 'Monthly') {
                    $startDateUnix = strtotime($fromDate);
                    $endDateUnix = strtotime($toDate);
                    $currentDateUnix = $startDateUnix;

                    $monthNumbers = array();
                    while ($currentDateUnix < $endDateUnix) {
                        $year = date('Y', $currentDateUnix);
                        $monthNumbers[$year][] = IntVal(date('m', $currentDateUnix));
                        $currentDateUnix = strtotime('+1 month', $currentDateUnix);
                    }

                    foreach ($monthNumbers as $yy => $ymonth) {
                        foreach ($ymonth as $ww) {
                            $responsibilities[$value][$yy . '-Month-' . $ww] = $this->HousekeepingResponsibility->find('all', array(
                                'conditions' => array(
                                    'HousekeepingResponsibility.publish' => 1,
                                    'HousekeepingResponsibility.soft_delete' => 0,
                                    'HousekeepingResponsibility.schedule_id' => $key,
                                    array("OR" => array("AND" => array(
                                                "MONTH(HousekeepingResponsibility.created) <=" => $ww,
                                                "YEAR(HousekeepingResponsibility.created) =" => $yy),
                                            array("YEAR(HousekeepingResponsibility.created) <" => $yy))), $userCondition),
                                'fields' => array(
                                    'HousekeepingResponsibility.id',
                                    'HousekeepingResponsibility.description',
                                    'HousekeepingChecklist.id',
                                    'HousekeepingChecklist.title',
                                    'Employee.id',
                                    'Employee.name')));
                            $i = 0;
                            foreach ($responsibilities[$value][$yy . '-Month-' . $ww] as $responsibility):
                                $responsibilities[$value][$yy . '-Month-' . $ww][$i]['Housekeeping'] = null;
                                $taskStatus = $this->Housekeeping->find('first', array(
                                    'conditions' => array(
                                        'MONTH(Housekeeping.created) <= ' => $ww,
                                        'YEAR(Housekeeping.created) <= ' => $yy,
                                        'Housekeeping.housekeeping_responsibility_id' => $responsibility['HousekeepingResponsibility']['id'])));
                                $responsibilities[$value][$yy . '-Month-' . $ww][$i]['Housekeeping'] = isset($taskStatus['Housekeeping']) ? $taskStatus['Housekeeping'] : '' ;
                                if (isset($taskStatus['Housekeeping']) && $taskStatus['Housekeeping']['task_performed'])
                                    $taskPerformed++;
                                $i++;
                                $taskAssigned++;
                            endforeach;
                        }
                    }
                } elseif ($value == 'quarterly' || $value == 'Quarterly') {
                    $quarterlyTasks = $this->HousekeepingResponsibility->find('all', array(
                        'conditions' => array(
                            'HousekeepingResponsibility.publish' => 1,
                            'HousekeepingResponsibility.soft_delete' => 0,
                            'HousekeepingResponsibility.schedule_id' => $key,
                            "DATE_FORMAT(HousekeepingResponsibility.created, '%Y-%m-%d') <=" => $toDate,
                            $userCondition),
                        'fields' => array(
                            'HousekeepingResponsibility.id',
                            'HousekeepingResponsibility.description',
                            'HousekeepingResponsibility.created',
                            'HousekeepingChecklist.id',
                            'HousekeepingChecklist.title',
                            'Employee.id',
                            'Employee.name')));
                    foreach ($quarterlyTasks as $task) {
                        $created = date('Y-m-d', strtotime($task['HousekeepingResponsibility']['created']));
                        $currentDate = date('Y-m-d', strtotime($task['HousekeepingResponsibility']['created']));
                        $lastQuarter = $toDate;
                        $nextQuarter = $toDate;

                        $dateArray = array();
                        $k = 0;
                        while ($currentDate <= $lastQuarter) {
                            $nextQuarter = date('Y-m-d', strtotime('+3 month', strtotime($currentDate)));
                            if ($currentDate >= $fromDate) {
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
                            $responsibilities[$value]['Quarter-' . $qNumber][$i] = $task;
                            $responsibilities[$value]['Quarter-' . $qNumber][$i]['Housekeeping'] = null;

                            $this->loadModel('Housekeeping');
                            $this->Housekeeping->recursive = 0;
                            $taskStatus = $this->Housekeeping->find('first', array(
                                'conditions' => array(
                                    "DATE_FORMAT(Housekeeping.created, '%Y-%m-%d') >=" => $cDate,
                                    "DATE_FORMAT(Housekeeping.modified, '%Y-%m-%d') <=" => $nextQuarter,
                                    'Housekeeping.housekeeping_responsibility_id' => $task['HousekeepingResponsibility']['id']
                            )));

                            $responsibilities[$value]['Quarter-' . $qNumber][$i]['Housekeeping'] = isset($taskStatus['Housekeeping']) ? $taskStatus['Housekeeping'] : '' ;
                            if (isset($taskStatus['Housekeeping']) && $taskStatus['Housekeeping']['task_performed'])
                                $taskPerformed++;
                            $i++;
                            $taskAssigned++;
                        }
                    }
                } else if ($value == 'yearly' || $value == 'Yearly') {
                    $startDateUnix = strtotime($fromDate);
                    $endDateUnix = strtotime($toDate);
                    $currentDateUnix = $startDateUnix;

                    $yearNumbers = array();
                    while ($currentDateUnix < $endDateUnix) {
                        $year = date('Y', $currentDateUnix);
                        $yearNumbers[$year][] = IntVal(date('Y', $currentDateUnix));
                        $currentDateUnix = strtotime('+1 year', $currentDateUnix);
                    }

                    foreach ($yearNumbers as $yy => $yyear) {
                        foreach ($yyear as $ww) {
                            $responsibilities[$value][$yy . '-Year-' . $ww] = $this->HousekeepingResponsibility->find('all', array(
                                'conditions' => array(
                                    'HousekeepingResponsibility.publish' => 1,
                                    'HousekeepingResponsibility.soft_delete' => 0,
                                    'HousekeepingResponsibility.schedule_id' => $key,
                                    "YEAR(HousekeepingResponsibility.created) <=" => $yy, $userCondition),
                                'fields' => array(
                                    'HousekeepingResponsibility.id',
                                    'HousekeepingResponsibility.description',
                                    'HousekeepingChecklist.id',
                                    'HousekeepingChecklist.title',
                                    'Employee.id',
                                    'Employee.name')));
                            $i = 0;
                            foreach ($responsibilities[$value][$yy . '-Year-' . $ww] as $task):
                                $responsibilities[$value][$yy . '-Year-' . $ww][$i]['Housekeeping'] = null;
                                $taskStatus = $this->Housekeeping->find('first', array(
                                    'conditions' => array(
                                        'YEAR(Housekeeping.created) <= ' => $yy,
                                        'Housekeeping.housekeeping_responsibility_id' => $task['HousekeepingResponsibility']['id'])));
                                $responsibilities[$value][$yy . '-Year-' . $ww][$i]['Housekeeping'] = isset($taskStatus['Housekeeping']) ? $taskStatus['Housekeeping'] : '' ;
                                if (isset($taskStatus['Housekeeping']) && $taskStatus['Housekeeping']['task_performed'])
                                    $taskPerformed++;
                                $i++;
                                $taskAssigned++;
                            endforeach;
                        }
                    }
                }
            endforeach;
        }
        if ($taskPerformed > 0 && $taskAssigned > 0)
            $result = round($taskPerformed * 100 / $taskAssigned);
        else
            $result = 0;

        if ($report == true) {
            return $responsibilities;
        }
        $this->set(compact('responsibilities', 'fromDate', 'toDate', 'result'));
   }

}
