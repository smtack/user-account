<?php
class User {
  private $db;

  public $name;
  public $username;
  public $email;
  public $password;

  public function __construct($db) {
    $this->db = $db;
  }

  function signUp() {
    $sql = "INSERT INTO users (name, username, email, password) VALUES (:name, :username, :email, :password)";
    $stmt = $this->db->prepare($sql);

    $this->name = htmlentities($this->name);
    $this->username = htmlentities($this->username);
    $this->email = htmlentities($this->email);
    $this->password = htmlentities($this->password);

    $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

    if($stmt->execute([
      ':name' => $this->name,
      ':username' => $this->username,
      ':email' => $this->email,
      ':password' => $password_hash
    ])) {
      return true;
    } else {
      return false;
    }
  }

  function logIn() {
    $sql = "SELECT * FROM users WHERE username = :username LIMIT 0,1";
    $stmt = $this->db->prepare($sql);

    $this->username = htmlentities($this->username);

    $stmt->execute([':username' => $this->username]);

    $rows = $stmt->rowCount();

    if($rows > 0) {
      $row = $stmt->fetch();

      $this->id = $row['id'];
      $this->name = $row['name'];
      $this->username = $row['username'];
      $this->email = $row['email'];
      $this->password = $row['password'];

      return true;
    }

    return false;
  }

  function logOut() {
    session_destroy();

    return false;
  }

  function getUser() {
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $this->db->prepare($sql);

    if($stmt->execute([':username' => $_SESSION['username']])) {
      return $stmt;
    } else {
      return false;
    }
  }

  function updateUser() {
    $sql = "UPDATE users SET name = :name, username = :username, email = :email WHERE id = :id";
    $stmt = $this->db->prepare($sql);

    if($stmt->execute([
      ':id' => htmlentities($_GET['id']),
      ':name' => htmlentities($this->name),
      ':username' => htmlentities($this->username),
      ':email' => htmlentities($this->email)
    ])) {
      return true;
    } else {
      return false;
    }
  }

  function changePassword() {
    $sql = "UPDATE users SET password = :password WHERE id = :id";
    $stmt = $this->db->prepare($sql);

    $this->new_password = htmlentities($this->new_password);

    $password_hash = password_hash($this->new_password, PASSWORD_BCRYPT);

    if($stmt->execute([
      ':id' => htmlentities($_GET['id']),
      ':password' => $password_hash
    ])) {
      return true;
    } else {
      return false;
    }
  }

  function deleteUser() {
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $this->db->prepare($sql);

    if($stmt->execute([':id' => htmlentities($_GET['id'])])) {
      return true;
    } else {
      return false;
    }
  }
}