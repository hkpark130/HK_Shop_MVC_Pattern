<?php
    echo "
        <table id = 'insert_table' style='width:750px;height:50px;border:0px;'>
    <tr>
        <th>상품명</th>
        <td id='tag'>
        <input type='text' name='item_name' style='width:550px;' maxlength='30' required></td>
    </tr>

    <tr>
        <th>상품가격</th>
        <td id='tag'>
        <input type='text' name='item_price' style='width:100px;' maxlength='30' required>원</td>
    </tr>

    <tr>
        <th >품종</th>
        <td id='tag'>
          <select name=\"category\">
          <option value='clothes'>clothes</option>
          <option value='pants'>pants</option>
          <option value='shoes'>shoes</option>
          <option value='etc'>etc</option>
          </select></td>
    </tr>

    <tr>
        <th >대표 이미지</th>
        <td id='tag'>
        <input type='file' name='item_img' style='width:550px;' required></td>
    </tr>

    <tr>
        <th>내용 이미지</th>
        <td id='tag'>
        <input type='file' name='upfile[]' multiple=\"multiple\"/></td>
    </tr>

    <tr>
        <th>상품설명</th>
        <td id='tag'>
       <textarea name='item_contents' style='width:550px;height:200px;' required></textarea></td>
    </tr>

</table>
    ";
?>