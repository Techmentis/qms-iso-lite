<?php
App::uses('AppController', 'Controller');
/**
 * UserSessions Controller
 *
 * @property UserSession $UserSession
 */
class UserSessionsController extends AppController {
	public function index() {
		$userId = $this->request->query['user_id'];
		if($userId){
			$conditions = array('UserSession.user_id'=>$userId);

		$this->paginate = array('conditions'=>$conditions,'order'=>array('UserSession.sr_no'=>'DESC'),'limit'=>10);

		$this->UserSession->recursive = 0;
		$this->set('userSessions', $this->paginate());
		$this->set('userId', $userId);
		}
                $users = $this->get_usernames();
		$this->set(compact('users'));
	}

	public function view($id = null) {
	   $userId = $id;
            $this->UserSession->History->recursive = 0;

		$userSession = $this->UserSession->History->find('all',array(
				'conditions'=>array('History.user_session_id'=>$id),
				'order'=>array('History.created'=>'DESC')
				));

		$this->set('userSession', $userSession);
		$this->set('selectedUserId', $selectedUserId);
                $users = $this->get_usernames();
		
		
		$this->set(compact('users'));
	}
}

