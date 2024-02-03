<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

class UserAuthentication
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function authenticateUser($username, $password)
    {
        $stmt = $this->dbConnection->prepare("SELECT * FROM your_table_name WHERE users_uid = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['users_pwd'])) {
                $_SESSION['is_admin'] = ($user['is_admin'] == 1);
                return true;
            } else {
                echo 'Invalid password';
            }
        } else {
            echo 'Invalid username';
        }

        return false;
    }
}

class HomeController
{
    private $isAdmin;

    public function __construct($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    public function displayWelcomeMessage()
    {
        echo '<div class="admin-message">Welcome, ' . ($this->isAdmin ? 'Admin' : '') . '!</div>';
    }
}

// Assume $your_db_connection is your database connection
// Create instances of the classes and use them

session_start();
include "connect.php";

$userAuthenticator = new UserAuthentication($your_db_connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($userAuthenticator->authenticateUser($username, $password)) {
        $homeController = new HomeController($_SESSION['is_admin']);
        $homeController->displayWelcomeMessage();

        header('Location: ' . ($_SESSION['is_admin'] ? 'adminhome.php' : 'Home_Signed.php'));
        exit();
    }
}
?>