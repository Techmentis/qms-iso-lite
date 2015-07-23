<?php

App::uses('AppController', 'Controller');

/**
 * DatabackupLogbooks Controller
 *
 * @property DatabackupLogbook $DatabackupLogbook
 */
class DatabackupLogbooksController extends AppController {

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
    public function index($span = null, $report = false, $reportFromDate = null, $reportToDate = null) {

        $this->loadModel('Schedule');
        $schedulesList = $this->Schedule->find('list', array('conditions' => array('Schedule.publish' => 1, 'Schedule.soft_delete' => 0)));

        if ($report) {
            $from = $reportFromDate;
            $to = $reportToDate;
        } else if ($this->request->data) {
            $from = $this->request['data']['DatabackupLogbook']['from_date'];
            $to = $this->request['data']['DatabackupLogbook']['to_date'];
        } else {
            if ($span == 'today' or $span == null)
                $condition = array('DatabackupLogbook.task_date' => date("Y-m-d"));
        }

        if (isset($this->request->data) && $this->request['data']['DatabackupLogbook']['employee_id'] != -1) {
            $userCondition = array('DailyBackupDetail.employee_id' => $this->request['data']['DatabackupLogbook']['employee_id']);
        } else {
            $userCondition = null;
        }

        $taskAssigned = null;
        $taskPerformed = null;

        $this->loadModel('DataBackUp');
        $this->DataBackUp->recursive = 0;

        $this->loadModel('DailyBackupDetail');
        $this->DailyBackupDetail->recursive = 0;
        $schedules = array();
        if ($from) {
            foreach ($schedulesList as $key => $value):
                if ($value == 'dailly' || $value == 'daily' || $value == 'Dailly' || $value == 'Daily') {
                    while ($from <= $to) {
                        $schedules[$value][$from] = $this->DailyBackupDetail->find('all', array(
                            'conditions' => array(
                                'DailyBackupDetail.publish' => 1,
                                'DailyBackupDetail.soft_delete' => 0,
                                'DataBackUp.schedule_id' => $key,
                                'DataBackUp.created < ' => date('Y-m-d 59:59:59', strtotime($from)),
                                $userCondition),
                            'fields' => array(
                                'DailyBackupDetail.id',
                                'DailyBackupDetail.name',
                                'DataBackUp.id',
                                'DataBackUp.name',
                                'Employee.id',
                                'Employee.name',
                                'Device.id',
                                'Device.name')
                        ));
                        $i = 0;
                        foreach ($schedules[$value][$from] as $task):
                            $schedules[$value][$from][$i]['DatabackupLogbook'] = null;
                            $taskStatus = $this->DatabackupLogbook->find('first', array('conditions' => array('DatabackupLogbook.backup_date' => date('Y-m-d', strtotime($from)),'DatabackupLogbook.daily_backup_detail_id' => $task['DailyBackupDetail']['id'])));
                            $schedules[$value][$from][$i]['DatabackupLogbook'] = isset($taskStatus['DatabackupLogbook']) ? $taskStatus['DatabackupLogbook']:'';
                            if (isset($taskStatus['DatabackupLogbook']) && $taskStatus['DatabackupLogbook']['task_performed'])
                                $taskPerformed++;
                            $i++;
                            $taskAssigned++;
                        endforeach;
                        $from = date("Y-m-d", strtotime("+1 day", strtotime($from)));
                    }
                    if ($report) {
                        $from = $reportFromDate;
                    } else {
                        $from = $this->request['data']['DatabackupLogbook']['from_date'];
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
                            $schedules[$value][$yy . '-Week-' . $ww] = $this->DailyBackupDetail->find('all', array('conditions' => array('DailyBackupDetail.publish' => 1,
                                    'DailyBackupDetail.soft_delete' => 0,
                                    'DataBackUp.schedule_id' => $key,
                                    array("OR" => array("AND" => array(
                                                "WEEK(DailyBackupDetail.created) <=" => $ww,
                                                "YEAR(DailyBackupDetail.created) =" => $yy),
                                            array("YEAR(DailyBackupDetail.created) <" => $yy))),
                                    $userCondition),
                                'fields' => array(
                                    'DailyBackupDetail.id',
                                    'DailyBackupDetail.name',
                                    'DataBackUp.id',
                                    'DataBackUp.name',
                                    'Employee.id',
                                    'Employee.name',
                                    'Device.id',
                                    'Device.name',
                                    'DailyBackupDetail.created')));
                            $i = 0;
                            foreach ($schedules[$value][$yy . '-Week-' . $ww] as $task):
                                $schedules[$value][$yy . '-Week-' . $ww][$i]['DatabackupLogbook'] = null;
                                $taskStatus = $this->DatabackupLogbook->find('first', array(
                                    'conditions' => array(
                                        'WEEK(DatabackupLogbook.backup_date)' => $ww,
                                        'YEAR(DatabackupLogbook.backup_date)' => $yy,
                                        'DatabackupLogbook.daily_backup_detail_id' => $task['DailyBackupDetail']['id'])));
                                $schedules[$value][$yy . '-Week-' . $ww][$i]['DatabackupLogbook'] = isset($taskStatus['DatabackupLogbook']) ? $taskStatus['DatabackupLogbook']:'';
                                if (isset($taskStatus['DatabackupLogbook']) && $taskStatus['DatabackupLogbook']['task_performed'])
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
                            $schedules[$value][$yy . '-Month-' . $ww] = $this->DailyBackupDetail->find('all', array(
                                'conditions' => array('DailyBackupDetail.publish' => 1, 'DailyBackupDetail.soft_delete' => 0, 'DataBackUp.schedule_id' => $key,
                                    array("OR" => array("AND" => array("MONTH(DailyBackupDetail.created) <=" => $ww,
                                                "YEAR(DailyBackupDetail.created) =" => $yy), array("YEAR(DailyBackupDetail.created) <" => $yy))), $userCondition,
                                ),
                                'fields' => array('DailyBackupDetail.id', 'DailyBackupDetail.name', 'DataBackUp.id', 'DataBackUp.name',
                                    'Employee.id', 'Employee.name', 'Device.id', 'Device.name', 'DailyBackupDetail.created'
                                )
                            ));
                            $i = 0;
                            foreach ($schedules[$value][$yy . '-Month-' . $ww] as $task):
                                $schedules[$value][$yy . '-Month-' . $ww][$i]['DatabackupLogbook'] = null;
                                $taskStatus = $this->DatabackupLogbook->find('first', array(
                                    'conditions' => array(
                                        'MONTH(DatabackupLogbook.backup_date) <= ' => $ww,
                                        'YEAR(DatabackupLogbook.backup_date) <= ' => $yy,
                                        'DatabackupLogbook.daily_backup_detail_id' => $task['DailyBackupDetail']['id'])));
                                $schedules[$value][$yy . '-Month-' . $ww][$i]['DatabackupLogbook'] = isset($taskStatus['DatabackupLogbook']) ? $taskStatus['DatabackupLogbook']:'';
                                if (isset($taskStatus['DatabackupLogbook']) && $taskStatus['DatabackupLogbook']['task_performed'])
                                    $taskPerformed++;
                                $i++;
                                $taskAssigned++;
                            endforeach;
                        }
                    }
                }else if ($value == 'quarterly' || $value == 'Quarterly') {
                    $dailyBackupDetails = $this->DailyBackupDetail->find('all', array('conditions' => array('DailyBackupDetail.publish' => 1, 'DailyBackupDetail.soft_delete' => 0, 'DataBackUp.schedule_id' => $key,
                            "DATE_FORMAT(DailyBackupDetail.created, '%Y-%m-%d') <=" => $to, $userCondition,
                        ),
                        'fields' => array('DailyBackupDetail.id', 'DailyBackupDetail.name', 'DataBackUp.id', 'DataBackUp.name',
                            'Employee.id', 'Employee.name', 'Device.id', 'Device.name', 'DailyBackupDetail.created'
                        )
                    ));


                    foreach ($dailyBackupDetails as $dailyBackupDetail) {
                        $created = date('Y-m-d', strtotime($dailyBackupDetail['DailyBackupDetail']['created']));
                        $currentDate = date('Y-m-d', strtotime($dailyBackupDetail['DailyBackupDetail']['created']));
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
                            $schedules[$value]['Quarter-' . $qNumber][$i] = $dailyBackupDetail;
                            $schedules[$value]['Quarter-' . $qNumber][$i]['DatabackupLogbook'] = null;
                            $taskStatus = $this->DatabackupLogbook->find('first', array(
                                'conditions' => array(
                                    "DATE_FORMAT(DatabackupLogbook.created, '%Y-%m-%d') >=" => $cDate, "DATE_FORMAT(DatabackupLogbook.created, '%Y-%m-%d') <=" => $nextQuarter,
                                    'DatabackupLogbook.daily_backup_detail_id' => $dailyBackupDetail['DailyBackupDetail']['id'])));
                            $schedules[$value]['Quarter-' . $qNumber][$i]['DatabackupLogbook'] = isset($taskStatus['DatabackupLogbook']) ? $taskStatus['DatabackupLogbook']:'';
                            if (isset($taskStatus['DatabackupLogbook']) && $taskStatus['DatabackupLogbook']['task_performed'])
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
                            $schedules[$value][$yy . '-Year-' . $ww] = $this->DailyBackupDetail->find('all', array(
                                'conditions' => array('DailyBackupDetail.publish' => 1, 'DailyBackupDetail.soft_delete' => 0, 'DataBackUp.schedule_id' => $key,
                                    "YEAR(DailyBackupDetail.created) <=" => $yy, $userCondition,
                                ),
                                'fields' => array('DailyBackupDetail.id', 'DailyBackupDetail.name', 'DataBackUp.id', 'DataBackUp.name',
                                    'Employee.id', 'Employee.name', 'Device.id', 'Device.name', 'DailyBackupDetail.created'
                                )
                            ));
                            $i = 0;
                            foreach ($schedules[$value][$yy . '-Year-' . $ww] as $task):
                                $schedules[$value][$yy . '-Year-' . $ww][$i]['DatabackupLogbook'] = null;
                                $taskStatus = $this->DatabackupLogbook->find('first', array(
                                    'conditions' => array(
                                        'YEAR(DatabackupLogbook.backup_date) <= ' => $yy,
                                        'DatabackupLogbook.daily_backup_detail_id' => $task['DailyBackupDetail']['id'])));
                                $schedules[$value][$yy . '-Year-' . $ww][$i]['DatabackupLogbook'] = isset($taskStatus['DatabackupLogbook']) ? $taskStatus['DatabackupLogbook']:'';
                                if (isset($taskStatus['DatabackupLogbook']) && $taskStatus['DatabackupLogbook']['task_performed'])
                                    $taskPerformed++;
                                $i++;
                                $taskAssigned++;
                            endforeach;
                        }
                    }
                }

            endforeach;
        }

        $from = $this->request['data']['DatabackupLogbook']['from_date'];
         if ($taskPerformed > 0 && $taskAssigned > 0)
            $result = round($taskPerformed * 100 / $taskAssigned);
        else
            $result = 0;
        if ($report == true) {
            return $schedules;
        }
        $this->set(compact('schedules', 'from', 'to', 'users', 'result'));
    }

    public function _index() {


        $conditions = $this->_check_request();
        $this->paginate = array('order' => array('DatabackupLogbook.sr_no' => 'DESC'), 'conditions' => array($conditions));


        $this->DatabackupLogbook->recursive = 0;
        $this->set('databackupLogbooks', $this->paginate());

        $this->_get_count();
    }


}
