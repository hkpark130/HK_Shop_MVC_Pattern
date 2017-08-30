<table>
    <tr>
        <td>
            <?php

            foreach($items as $item){
                $real_image_url = "/image/"."{$item['item_title_image']}";
                echo "
                  <div id='item_div'>
                      <div style='margin-top:10px'>상품명:";
                if( mb_strlen($item['item_name'], 'utf-8')>13  ){
                    $item['item_name'] = mb_substr($item['item_name'],0,9, 'UTF-8')."...";
                }
                echo" {$item['item_name']} </div>
                      <div style='border: 1px solid black;width:150px;'>가격: {$item['item_price']}</div>
                      <div style='margin-top:10px'><a href='$base_url/show/{$item['id']}'><img src=$real_image_url width=250px heught=250px/></a></div>
                  </div>
                ";
            }
            ?>

        </td>
    </tr>
</table>



<?php
echo"<div id='page_table'>";

if($pages->nowPage > $pages::PAGES) {
    $go = $pages->lastPage - $pages::PAGES;
    echo " <a href='/{$keyword}/search/{$go}'> ◀ </a> \t";
}

for($i = 1 ; ($i+$pages->firstPage -1) <= $pages->lastPage ; $i++) {
    $page = $pages->firstPage + $i -1;

    echo " <a href='/{$keyword}/search/{$page}'> {$page} </a> &nbsp;";
}

if($pages->lastPage < $pages->finalPage) {
    $go = $pages->firstPage + $pages::PAGES;
    echo " <a href='/{$keyword}/search/{$go}'> ▶ </a>";
}
echo"</div>";

?>