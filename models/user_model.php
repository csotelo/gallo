<?php
class User extends AppModel {
    var $_table    = 'users';
    var $_username = FALSE;
    var $_userpass = FALSE;
    
    public function OpenSession ($username, $userpass) {
        $this->username = $username;
        $this->userpass = md5($userpass);
        $data = $this->find('first', array('fields'=>array('id, firstname'),
                                            'where'=>array('username'=>$this->username,
                                                            'userpass'=>$this->userpass)));
        if ($data) {
            if (!session_is_registered('user_id')) {
                session_register('user_id');
            }
            if (session_is_registered('user_firstname')) {
                session_register('user_firstname');
            }
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['user_firstname'] = $data['firstname'];
            $_SESSION['logged'] = '1';
        }
    }
    
    public function CloseSession () {
        session_unregister('user_id');
        session_unregister('user_firstname');
        $_SESSION['logged'] = '0';
    }
}
?>