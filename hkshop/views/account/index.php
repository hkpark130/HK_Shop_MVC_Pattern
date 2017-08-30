<?php
  $this->setPageTitle('title','계정정보')
 ?>
 <div class="account">
   <h2>
     계정정보
   </h2>
   <p>
        <?php
        echo"<table id='board_table'>";
        echo"<tr>
            <th width='150px'>사용자 ID: </th>
            <td width='300px'>{$this->escape($user['user_name'])}</td>
            
            <tr>
            <th >사용자 이름: </th>
            <td>{$this->escape($user['name'])}</td>
            </tr>
            
            <tr>
            <th >전화번호: </th>
            <td>{$this->escape($user['hp'])}</td>
            </tr>
            
            <tr>
            <th >가입일자: </th>
            <td>{$this->escape($user['time_stamp'])}</td>
            </tr>
            
            </table>";
        ?>
   </p>

 </div>
<h2>
구매내역
<h2>
<?php
    echo"<table id='board_table'>";
        echo"<tr>
                <th width = 100>구매일자</th>
                <th width = 50></th> 
                <th width = 250>상품명</th> 
                <th width = 100>품종</th> 
                <th width = 100>구매자</th> 
                <th width = 50>갯수</th> 
                <th width = 100>가격</th>
             </tr>";

        foreach($historys as $history) {

        echo "<tr><td>{$history['date']}</td>";
            echo "<td><img id='imgSmall' src='/image/{$history['item_img']}'></img></td>";
            echo "<td> {$history['item_name']} </td>";
            echo "<td align='center'>{$history['category']}</td>";
            echo "<td align='center'>{$history['user_name']}</td>";
            echo "<td align='center'>{$history['ea']}</td>";
            echo "<td align='center'>{$history['cost']}</td></tr>";
        }
        echo "</table>";
?>

    <ul>
        <li>
            <a href="<?php print $base_url; ?>/account/signout">로그아웃</a>
        </li>
    </ul>





