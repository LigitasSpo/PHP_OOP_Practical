<?php 

class Login{


    protected $localhost = 'localhost';
    protected $user = 'root';
    protected $pass = '';
    protected $db = 'conn';
    protected $conn;

    public $errors = array();

    function __construct(){
        $this->conn = mysqli_connect($this->localhost,$this->user, $this->pass, $this->db);
    }

    public function insertIntoTb($username, $password) {

        $username = $this->checkInput($username);
        $pass = $this->checkInput($password);

        //call for errors checking in inputs
        if($this->checkErrors($username, $pass)){
            //checks if username already in db
            if( $this->checkUsername($username)) {
                //adds to db
                if ($this->insertingIntoDb($username, $pass)) $this->errors = ['Success Massage Displayed'];
            }
        }
    }

    protected function checkInput($var) {
        $var = htmlspecialchars($var);
        $var = trim($var);
        $var = stripslashes($var);
        return $var;
    }

    //checking inpu fields
    protected function checkErrors($username, $passoword) {
        if(strlen($username) < 4 || strlen($username) > 20 ) {
            array_push($this->errors, 'Username must have more than 4 charaters and lover than 20 characters');
            return false;
        }
        if(strlen($passoword) < 4 || strlen($passoword) > 20) {
            array_push($this->errors, 'Password must have more than 4 charaters and lover than 20 characters');
            return false;
        }

        return true;
    } 

    //checking if username is in db
    protected function checkUsername($username) {
        $query = "SELECT `login` from `users` where login='". $username ."'";

        mysqli_query($this->conn, $query);

        if(mysqli_affected_rows($this->conn) > 0) {

            array_push($this->errors, "Username already in our database");
            return false;

        } else {

            return true;
        }
    }
        //inserting into db
        protected function insertingIntoDb($username, $passoword) {
            $query = "INSERT INTO `users` (`login`, `password`) VALUES ('". $username. "', '".$passoword ."')";
            mysqli_query($this->conn, $query);
    
            if(mysqli_affected_rows($this->conn) > 0) {
                return true;
        }   else {
                return false;
        }
    }
}

?>

<h1> Register user </h1>
<form method="POST" action="">
<p>Login name</p>
<input type="text" name="username">
<p>Password</p>
<input type="password" name="password">
<br>
<input type="submit" name="send" value="register">

</form>

<?php 

if(isset($_POST['send'])) {
    $object = new Login();
    $object->insertIntoTb($_POST['username'],$_POST['password']);

    foreach($object->errors as $error){
        echo $error. '<br>';
    }
}


?>
