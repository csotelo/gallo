<?php
class Users extends AppView {
	var $uses = array ('User');

	public function login () {
		$this->User->OpenSession ($_POST['username'], $_POST['userpass']);
		$this->redirect ();
	}

	public function logout () {
		$this->User->CloseSession ();
		$this->redirect ();
	}

	public function view ($id = null) {
		$this->set('user', $this->User->find('first', array('where'=>array('id'=>$id))));
	}

	public function edit ($id = null) {
		$this->security();
		if (isset ($_POST['submit'])){
			$data = array ();
			$data['firstname'] = $_POST['firstname'];
			$data['lastname']  = $_POST['lastname'];
			$data['email']     = $_POST['email'];
			$this->User->update ($_POST['id'], $data);
			$this->redirect('localizations');
		}
		$this->set('user', $this->User->find('first', array('where'=>array('id'=>$id))));
	}

	public function pswdupdate ($id = null) {
		$this->security();
		if (isset ($_POST['submit'])){
			$data = array ();
			if ($_POST['password'] == $_POST['passconf']) {
				$data['userpass'] = md5($_POST['password']);
				$this->User->update ($_POST['id'], $data);
			}
			$this->redirect('page');
		}
		$this->set('user', $this->User->find('first', array('where'=>array('id'=>$id))));
	}
}
?>