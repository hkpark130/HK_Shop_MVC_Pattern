

    <!-- 40 페이지 -->
    <?php $this->setPageTitle('title', '게시판 생성') ?>

    <form action="<?php print $base_url; ?>/board/insert" method="post"  enctype = 'multipart/form-data'>
    <input type="hidden" name="_token" value="<?php print $this->escape($_token); ?>"/>
    <!-- View클래스의 escape() -->

    <?php if(isset($errors) && count($errors) > 0): ?>
    <?php print $this->render('errors', array('errors' => $errors)); ?>
    <?php endif; ?>

    <?php print $this->render('board/insert'); ?>
    <p><input style="margin-left: 72px" type="submit" value="등록" /></p>
    </form>
