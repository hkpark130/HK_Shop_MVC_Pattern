
<form method='post' action="<?php print "{$base_url}/buy/{$item['id']}" ?>">
<input type="hidden" name="_token" value="<?php print $this->escape($_token); ?>"/>

<?php
        echo "
            <input type='hidden' name='id' value='{$item['id']}'/>
            
            <table style='width:750px;'>
              <tr>
                  <th width = 100px >상품명</th>
                  <td width = 650px colspan='3' >$item[item_name]</td>
              </tr>
              <tr>
                  <th>가격</th>
                  <td width = 400px>$item[item_price]</td>
                  <td style='text-align:center'><input type='number' required min='1' max='5' name='ea'/></td>
                  <td style='text-align:center'><input  type='submit' style='width:90px;' value='구입'>
                  <input  type='button' style='width:90px;' value='장바구니'></td>
              </tr>
              <tr>
                  <th width = 100px>내용</th>
                  <td colspan='3'>$item[item_contents]</td>
              </tr>
              <tr>
                  <th width = 100px ></th>
                  <td colspan='3' style='text-align:center'>";
            foreach ($item_sub_img as $key=>$value){

                echo "<img style='max-width: 650px' src=/image/{$value['item_sub_images']}></img><br>";

            }
echo"</td>
              </tr>

            </table></form>";
?>