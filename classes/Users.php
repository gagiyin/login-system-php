<?php
class Users {

    private $conn;

    private $user_table = "users";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function registerUser($email, $familyname, $firstname, $password) {
        $query = "INSERT INTO ". $this->user_table. " (familyname, firstname, email, password) VALUES (:familyname, :firstname, :email, :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':familyname', $familyname);
        $stmt->bindParam(':firstname', $firstname);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();
        $_SESSION['notice'] = "Sikeres regisztráció!";
    }

    public function loginUser($email, $password) {
        $query = "SELECT * FROM ". $this->user_table. " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['email'];
            $_SESSION['logged-in'] = true;
            $_SESSION['notice'] = "Sikeres bejelentkezés!";
            if (!isset($_SESSION['redirectToWhenLogged'])) {
                redirect('index.php');
            } else {
                $_SESSION['alertLog'] = "Sikeres bejelentkezés!";
            }
            return $user;
        } else {
            $_SESSION['notice'] = "Hibás email cím/jelszó!";
            return false;
        }
    }
    public function getUserDataByEmail($email) {
        $query = "SELECT * FROM ". $this->user_table. " WHERE email = :email;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    public function saveUserSettings($familyname, $firstname, $email, $country, $state, $zipcode, $street) {
        $query = "UPDATE ". $this->user_table. " SET familyname = :familyname, 
        firstname = :firstname, email = :email, country = :country, state = :state, zipcode = :zipcode,
        street = :street WHERE email = :userEmail;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam("userEmail", $_SESSION["user"]);
        $stmt->bindParam(":familyname", $familyname);
        $stmt->bindParam(":firstname", $firstname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":country", $country);
        $stmt->bindParam(":state", $state);
        $stmt->bindParam(":zipcode", $zipcode);
        $stmt->bindParam(":street", $street);
        $stmt->execute();
        $_SESSION['user'] = $email; 
    }

}
?>