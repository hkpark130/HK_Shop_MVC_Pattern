<?php
class UserModel extends ExecuteModel {
  // **insert()***
  //http://php.net/manual/kr/function.password-hash.php
  //패스워드의 해쉬 처리 : 암호화
  //http://php.net/manual/kr/datetime.format.php
  //DateTime::format
  public function insert($user_name, $password,$name,$hp) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $now = new DateTime();
    $sql = "INSERT INTO user(user_name, password, time_stamp,name,hp,permition)
    VALUES(:user_name, :password, :time_stamp, :name, :hp,0)";

    $stmt = $this->execute($sql, array(
      ':user_name' => $user_name,
      ':password' => $password,
      ':time_stamp' => $now->format('Y-m-d H:i:s'),
      ':name' => $name,
      ':hp' => $hp,
    ));

    // execute(); 추상 클래스 ExecuteModel의 메소드
  }

  // ***getUserRecord() ***
  public function getUserRecord($user_name) {
    $sql = "SELECT *
          FROM user
          WHERE user_name = :user_name";

          $userData = $this->getRecord(
                      $sql,
                      array(':user_name' => $user_name));

   // getRecord(); 추상 클래스 ExecuteModel의 메소드

    return $userData;
  }

  // ***isOverlapUserName() ***
  public function isOverlapUserName($user_name) {
    $sql = "SELECT COUNT(id) as count
            FROM user
            WHERE user_name = :user_name";

    $row = $this->getRecord(
            $sql,
            array(':user_name' => $user_name));

    if( empty($row['count']) ) { // $user_name의 유저가 미동륵이면
    return true;
  }
      return false;
    }

  // *** getFollowingUser() ***
  public function getFollowingUser($user_id){
    $sql = "SELECT u.*
          FROM user u
          LEFT JOIN followingUser f ON f.following_id = u.id
          WHERE f.user_id = :user_id";

  $follows = $this->getAllRecord(
              $sql,
              array(':user_id' => $user_id));
              return $follows;
    }
  }
?>
