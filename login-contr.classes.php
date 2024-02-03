<?php
include_once "connect.php";

class LoginContr extends Dbh {
    private $uid;
    private $pwd;
    private $conn;

    public function __construct($uid, $pwd) {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->conn = $this->connect(); // Call the connect method from the Dbh class
    }

    public function loginUser() {
        $uid = $this->uid;
        $pwd = $this->pwd;
    
        $userType = $this->performLogin($uid, $pwd);
    
        if ($userType) {
            if ($userType == 'admin') {
                header("location: adminhome.php?loginsuccess=true");
            } elseif ($userType == 'user') {
                header("location: Home_Signed.php?loginsuccess=true");
            }
            exit();
        } else {
            echo "Invalid username or password";
        }
    }

    private function performLogin($uid, $pwd) {
        $conn = $this->conn; // Use the connection object from the class

        $stmt = $conn->prepare("SELECT users_uid, users_pwd, is_admin FROM your_table WHERE users_uid = ?");
        $stmt->bind_param("s", $uid);
        $stmt->execute();
        $stmt->bind_result($dbUid, $dbPwd, $isAdmin);
        $stmt->fetch();
        $stmt->close();
    
        if (password_verify($pwd, $dbPwd)) {
            session_start();
            $_SESSION["Login"] = true;
            $_SESSION["id"] = $dbUid;
    
            if ($isAdmin == 1) {
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
