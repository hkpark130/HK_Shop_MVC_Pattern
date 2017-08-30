<?php
  class ShopModel extends ExecuteModel {

    public function insert($item_name,$item_price,$category,$item_title_image,$contents) {

        $sql = "INSERT INTO mvc_item(item_name,item_price,category,item_title_image,item_contents)
          VALUES(:item_name, :item_price, :category, :item_title_image, :item_contents)";

        $stmt = $this->execute($sql, array(
            ':item_name' => $item_name,
            ':item_price' => $item_price,
            ':category' => $category,
            ':item_title_image' => $item_title_image,
            ':item_contents' => $contents,
        ));

        // execute(); 추상 클래스 ExecuteModel의 메소드
    }

      public function insertHistory($item_name, $user_name, $item_img, $category, $ea, $cost) {

          $sql = "INSERT INTO mvc_history(item_name,user_name,item_img,category,ea,cost,date)
          VALUES(:item_name, :user_name, :item_img, :category, :ea, :cost, now())";


          $stmt = $this->execute($sql, array(
              ':item_name' => $item_name,
              ':user_name' => $user_name,
              ':item_img' => $item_img,
              ':category' => $category,
              ':ea' => $ea,
              ':cost' => $cost,
          ));

          // execute(); 추상 클래스 ExecuteModel의 메소드
      }



      public function subImgInsert($id,$count,$item_sub_images) {
        for($i = 0 ; $i<$count ; $i++){
            $sql = "INSERT INTO item_image_table(id,count,item_sub_images)
          VALUES(:id, :count, :item_sub_images)";

            $stmt = $this->execute($sql, array(
                ':id' => $id,
                ':count' => $count,
                ':item_sub_images' => $item_sub_images[$i],
            ));
        }

      }


      public function getItemRecord($id) {
          $sql = "SELECT *
                  FROM mvc_item
                  WHERE item_title_image = :id";

          $itemData = $this->getRecord(
              $sql,
              array(':id' => $id));


          return $itemData;
      }

      public function getItemIdRecord($id) {
          $sql = "SELECT *
                  FROM mvc_item
                  WHERE id = :id";

          $itemData = $this->getRecord(
              $sql,
              array(':id' => $id));

          return $itemData;
      }

      public function getImgData($id) {
          $sql = "SELECT *
                  FROM item_image_table
                  WHERE id = :id";

          $imgData = $this->getAllRecord(
              $sql,
              array(':id' => $id));

          return $imgData;
      }

      public function getHistoryData($user_name) {
          $sql = "SELECT *
                  FROM mvc_history
                  WHERE user_name = :user_name";

          $imgData = $this->getAllRecord(
              $sql,
              array(':user_name' => $user_name));

          return $imgData;
      }

      public function getOffsetSearchItemData($id,$limit,$keyword){            //페이징
          $id = ($id - 1) * $limit;
          $sql = "SELECT *
                  FROM mvc_item
                  WHERE category = :category
                  limit {$limit} offset {$id};\"";

          $itemData = $this->getAllRecord(
              $sql,
              array(':category' => $keyword));

          if(!$itemData){
              $sql = "SELECT *
                FROM mvc_item WHERE item_name like \"%$keyword%\"
                 limit {$limit} offset {$id};";

              $itemData = $this->getAllRecord(
                  $sql
              );
          }


          return $itemData;
      }

      public function getOffsetItemData($id,$limit){            //페이징
          $id = ($id - 1) * $limit;
          $sql = "SELECT *
                FROM mvc_item
                 limit {$limit} offset {$id};";

          $boards = $this->getAllRecord($sql
          );
          return $boards;
      }

    public function getItemData(){
        $sql = "SELECT *
                FROM mvc_item";
        $boards = $this->getAllRecord($sql);
        return $boards;
    }

      public function SearchItemData($category) {
          $sql = "SELECT *
                  FROM mvc_item
                  WHERE category = :category";

          $itemData = $this->getAllRecord(
              $sql,
              array(':category' => $category));

          if(!$itemData){
              $sql = "SELECT *
                      FROM mvc_item
                      WHERE item_name like \"%$category%\"";

              $itemData = $this->getAllRecord(
                  $sql
                  );
          }

          return $itemData;
      }


  }
?>
