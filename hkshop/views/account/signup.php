  <!-- 40 페이지 -->
<?php $this->setPageTitle('title', '계정 생성') ?>
<h2>사용자 계정을 생성</h2>
<form action="<?php print $base_url; ?>/account/register" method="post">
  <input type="hidden" name="_token" value="<?php print $this->escape($_token); ?>"/>
  <!-- View클래스의 escape() -->

  <?php if(isset($errors) && count($errors) > 0): ?>
  <?php print $this->render('errors', array('errors' => $errors)); ?>
  <?php endif; ?>

  <?php print $this->render('account/regist', array('user_name' => $user_name, 'password' => $password, )); ?>
  <p><input style="margin-left: 72px" type="submit" value="등록" /></p>
</form>
