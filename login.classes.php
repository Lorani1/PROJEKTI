<?php

class Login extends Dbh {

    public function loginUser($uid, $pwd) {
        $stmt = $this->connect()->prepare('SELECT users_uid, users_pwd, is_admin FROM users WHERE users_uid = ?');
        $stmt->execute([$uid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($pwd, $result['users_pwd'])) {
            session_start();
            $_SESSION["Login"] = true;
            $_SESSION["id"] = $result['users_uid'];

            if ($result['is_admin'] == 1) {
                return 'admin';
            } else {
                return 'user';
            }
        } else {
            return false;
        }
    }
}
?>
