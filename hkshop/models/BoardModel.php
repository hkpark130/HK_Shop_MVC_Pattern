<?php

class BoardModel extends ExecuteModel {
    // **insert()***
    //http://php.net/manual/kr/function.password-hash.php
    //패스워드의 해쉬 처리 : 암호화
    //http://php.net/manual/kr/datetime.format.php
    //DateTime::format
    public function insert($user_name,$subject,$contents,$file = null) {

        $now = new DateTime();
        $sql = "INSERT INTO mvc_board(user_name,subject,contents,file,date)
    VALUES(:user_name, :subject, :contents, :file, :time_stamp)";

        $stmt = $this->execute($sql, array(
            ':user_name' => $user_name,
            ':subject' => $subject,
            ':contents' => $contents,
            ':file' => $file,
            ':time_stamp' => $now->format('Y-m-d H:i:s'),
        ));

        // execute(); 추상 클래스 ExecuteModel의 메소드
    }

    // ***getUserRecord() ***
    public function getBoardRecord($id) {
        $sql = "SELECT *
          FROM mvc_board
          WHERE id = :id";

        $boardData = $this->getRecord(
            $sql,
            array(':id' => $id));

        // getRecord(); 추상 클래스 ExecuteModel의 메소드

        return $boardData;
    }

    public function getBoardData(){
        $sql = "SELECT *
              FROM mvc_board 
              ORDER BY date DESC";
        $boards = $this->getAllRecord($sql);
        return $boards;
    }

}

?>
