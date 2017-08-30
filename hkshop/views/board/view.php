<?php
    $file = ( empty($board['file']) )? "":$board['file'];
    echo"<table id='board_table' ><tr><th width = 600>".$board['subject']."</th>".
        "<input type=\"hidden\" name=\"_token\" value=\"{$this->escape($_token)}\" />".
         "<th width = 150><a href="."/board/download/{$board['id']}".">".$file.
        "</a></th></tr>";

    echo "<tr><td width = '750' height = '500' colspan='2' style='vertical-align: top;' >".$board['contents'].'</td></tr>';
    echo"</table>";

?>
