<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <link rel="stylesheet"
          type="text/css"
          href="/css/style.css" />


</head>
<?php
?>
<body>
<div style="position:relative;min-height: 94%;">
    <table align="center" style="width: 1200px">
        <tr>
            <td width="200px" rowspan="2">
                <a href="<?php print $base_url; ?>/"><img src="http://i.imgur.com/C0BrPFi.jpg"/></a>
            </td>
            <td width="750px" rowspan="2">
            </td>
            <td width="280px" height="40px" align="center">
                <span style=" font-size: small; font-family: 돋움 ">
                    <?php if(!isset($_SESSION['user']['id']) ) : ?>
                        <a href="<?php print $base_url; ?>/account/signin">log-in</a> &nbsp;&nbsp;
                        <a href="<?php print $base_url; ?>/account/signup"> join </a>&nbsp;&nbsp;
                    <?php endif; ?>

                    <?php //if(!is_null($shop_user) ) : ?>
                    <a href="<?php print $base_url; ?>/board"> board </a> &nbsp;&nbsp;
                    <a href="<?php print $base_url; ?>/manager"> manager </a> &nbsp;&nbsp;
                    <a href="<?php print $base_url; ?>/account"> my-page </a> </span>
                    <?php //endif; ?>

            </td>
        </tr>
        <tr>
            <td width="250px" height="40px" align="center">

                    <form action="/search" method="post">
                        <input id="keyword" name="keyword" type="search"/>
                        <input type="image" src="http://i.imgur.com/hpNzrWv.gif" />
                    </form>

            </td>
        </tr>
        <tr>
            <td height="70px"></td>
        </tr>
        <tr>
            <td height="300px" valign="top">
                <li id="li_category">
                    <ul>
                        <a href="/clothes/search/1">clothes</a>
                    </ul>
                    <ul>
                        <a href="/pants/search/1">pants</a>
                    </ul>
                    <ul>
                        <a href="/shoes/search/1">shoes</a>
                    </ul>
                    <ul>
                        <a href="/etc/search/1">etc</a>
                    </ul>
                </li>
            </td>
            <td valign="top">
                <?php print $_content; ?>
            </td>

        </tr>
    </table>
</div>

</body>
</html>
