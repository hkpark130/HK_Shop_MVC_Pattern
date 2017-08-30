
<?php $this->setPageTitle('title', '매니저'); ?>

<form action="<?php print $base_url; ?>/manager/post" method="post" enctype = 'multipart/form-data'>
    <!-- AccountController의 authenticateAction 메소드 -->
    <input type="hidden" name="_token" value="<?php print $this->escape($_token); ?>" />

    <?php if(isset($errors) && count($errors) > 0): ?>
        <?php print $this->render('errors', array('errors' => $errors)); ?>
    <?php endif; ?>


    <?php print $this->render('shop/product_insert'); ?>

    <p>
        <input type="submit" value="상품등록" style="margin-left: 72px"/>
    </p>
</form>
