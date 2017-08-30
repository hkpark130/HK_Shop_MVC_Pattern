<?php
class AccountController extends Controller{
  protected $_authentication = array('index','signout'); //login에 필요한 action정의
  const SIGNUP = 'account/signup';
  const SIGNIN = 'account/signin';

  public function signupAction(){

    if($this->_session->isAuthenticated()){
      $this->redirect('/account');
    }
    $signup_view = $this->render(array(
      'user_name'=>'',
      'password'=>'',
      '_token' => $this->getToken(self::SIGNUP),
      //Controller클래스의 CSRF(Cross-site request forgery,사이트간 요청위조) 대책용 Token을생성
      //http://namu.wiki/w/CSRF
    ));

    return $signup_view;
  }

  public function registerAction(){//signup.php내의 form태그 action에서의 설정
    //1>POST 전송박식으로 전달 받은 데이터에 대한 체크
    if(!$this->_request->isPost()){
      $this->httpNotFound(); //FileNotFoundException 예외객체를 생성
    }
    if($this->_session->isAuthenticated()){
      $this->redirect('/account');
    }
    //2>CSRF대책의 Token 체크
    $token = $this->_request->getPost('_token');
    if(!$this->checkToken(self::SIGNUP, $token)){
      return $this->redirect('/'.self::SIGNUP);
    }
    //3>POST 전송방식으로 전달 받은 데이터를 변수에 저장
    $user_name = $this->_request->getPost('user_name');
    $password = $this->_request->getPost('password');
    $password_confirm = $this->_request->getPost('password_confirm');
    $name = $this->_request->getPost('name');
    $hp = $this->_request->getPost('hp1')."-".$this->_request->getPost('hp2')."-".$this->_request->getPost('hp3');


    $errors = array();
    //4>사용자 ID체크
    //http://php.net/manual/kr/function.strlen.php
    //http://php.net/manual/kr/function.preg-match.php
    if(!$this->_connect_model->get('User')->isOverlapUserName($user_name)){
        //ConnectionModel 의 get()으로 UserModel 클래스 객체생성후 isOverlapUserName 호출
        $errors[]='입력한 사용자 ID는 다른 사용자가 사용하고 있습니다.';
    }
    //5>사용자 패스워드 체크
    if($password != $password_confirm){
      $errors[] = '패스워드가 다릅니다.';
    }
    //6>계정 정보 등록
    if(count($errors)===0){ //에러가 없는 경우 처리
      //UserModel클래스의  insert()로 사용자 계정 등록
      $this->_connect_model->get('User')->insert($user_name,$password,$name,$hp);
      //세션ID재생성
      $this->_session->setAuthenticateStaus(true);
      //새로 추가된 레코드를 얻어냄
      $user = $this->_connect_model->get('User')->getUserRecord($user_name);
      //얻어온 레코드를 세션에 저장
      $this->_session->set('user',$user);
      //사용자 톱 페이지로 리다이렉트
      return $this->redirect('/');
    }
    //에러가 있는 경우 에러 정보와 함께 페이지 렌더링
    return $this->render(array(
      'user_name' => $user_name,
      'password' => $password,
      'errors' => $errors,
      '_token' => $this->getToken(self::SIGNUP),
    ),'signup');
  }

  public function indexAction(){ // /views/account/index.php

    $user = $this->_session->get('user');
    $historys = $this->_connect_model->get('shop')->getHistoryData($user['user_name']);

    $index_view = $this->render(array(
      'user' => $user,
      'historys' => $historys,
    ));
    return $index_view;

  }

  public function signinAction(){ // /views/account/signin.php

    if($this->_session->isAuthenticated()){
      return $this->redirect('/account');
    }

    $signin_view = $this->render(array(
      'user_name' => '',
      'password' => '',
      '_token' => $this->getToken(self::SIGNIN),
    ));
    return $signin_view;
    //session ID를 재생성 -> $_SESSION['_authenticated']=true -> $_SESSION에 계정 정보 저장

  }
  public function authenticateAction(){
    if(!$this->_request->isPost()){
      $this->httpNotFound();
    }
    if($this->_session->isAuthenticated()){
      return $this->redirect('/account');
    }
    $token = $this->_request->getPost('_token');
    if(!$this->checkToken(self::SIGNIN,$token)){
      return $this->redirect('/'.self::SIGNIN);
    }
    $user_name = $this->_request->getPost('user_name');
    $password = $this->_request->getPost('password');

    $errors = array();
    if(!strlen($user_name)){
      $errors[]='사용자 ID를 입력 해주세요';
    }
    if(!strlen($password)){
      $errors[] ='패스워드를 입력해주세요';
    }
    if(count($errors)===0){
      $user = $this->_connect_model->get('User')->getUserRecord($user_name);

      //http://php.net/manual/en/function.password-hash.php
      //http://php.net/manual/en/function.password-verify.php
      if(!$user || (!password_verify($password, $user['password']))){
        $errors[]='인증 에러임';
      }else{
        $this->_session->setAuthenticateStaus(true);
        $this->_session->set('user',$user);

        return $this->redirect('/');
      }
    }
    return $this->render(array(
      'user_name' => $user_name,
      'password' => $password,
      'errors' => $errors,
      '_token' => $this->getToken(self::SIGNIN),
    ),'signin');
}
    public function signoutAction(){
      $this->_session->clear();
      $this->_session->setAuthenticateStaus(false);
      return $this->redirect('/'.self::SIGNIN);
    }


}
 ?>
