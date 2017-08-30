<?php

$i = 0;


echo"<table id='board_table'>";
echo"<tr><th width = 30></th> <th width = 450>제목</th> <th width = 100>작성자</th> <th width = 50>파일</th> <th width = 150>작성일</th></tr>";

foreach($boards as $board) {
        $i++;
        $url = "$base_url/board/view/$board[id]";
        echo "<tr><th>$i</th>";
        echo "<td><a style=text-decoration:none href ={$url}>" . $board['subject'] . '</a></td>';
        echo "<td> $board[user_name] </td>";
        echo "<th>";
        echo(!empty($board['file']) ? "<img src='http://i.imgur.com/DPmlW88.png'>" : "");
        echo "</th>";
        echo "<td>$board[date]</td></tr>";
    }
    echo "</table>";
    echo"<a style='margin-left: 650px' href='/board/write'><b>글쓰기</b></a>";

?>
