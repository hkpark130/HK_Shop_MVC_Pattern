<?php
class BoardController extends Controller
{
    protected $_authentication = array('insert','index','delete','view','write','download'); //login필요한 action정의
    const INSERT = '/board/insert';
    const VIEW = '/board/view';

    public function insertAction(){


      if(!$this->_request->isPost()){
        $this->httpNotFound(); //FileNotFoundException 예외객체를 생성
      }

      $token = $this->_request->getPost('_token');
      if(!$this->checkToken(self::INSERT, $token)){
        return $this->redirect('/');
      }

        $user = $this->_session->get('user');

        $user_name = $user['user_name'];
        $subject = $this->_request->getPost('subject');
        $contents = $this->_request->getPost('contents');
        $file = $this->_request->getFile('upfile');

        if( !empty($file['name']) ){

            $upfile = $file['name'];

            $save_file = "file/".$upfile;//파일 경로
            $file_tmp_file = $file['tmp_name'];//파일 임시 저장소

            if( !move_uploaded_file($file_tmp_file,$save_file) ){

            }
        }else{
            $upfile = "";
        }

        $this->_connect_model->get('Board')->insert($user_name,$subject,$contents,$upfile);

        //사용자 톱 페이지로 리다이렉트
        return $this->redirect('/board');

    }

    public function writeAction(){

        $index_view = $this->render(array(
            '_token' => $this->getToken(self::INSERT),
        ));

        return $index_view;
    }

    public function indexAction(){

        $boards = $this->_connect_model->get('board')->getBoardData();

        $index_view = $this->render(array(
            'boards' => $boards,

        ));

        return $index_view;
    }

    public function viewAction($id){


        $board = $this->_connect_model->get('Board')->getBoardRecord($id['id']);

        if(!$board){
            $this->httpNotFound();
        }

        $board_view = $this->render(array(

            'board' => $board,
            '_token' => $this->getToken(self::VIEW),
        ));
        return $board_view;

    }

    public function downloadAction($file){
        $board = $this->_connect_model->get('Board')->getBoardRecord($file['file']);
        $filename = $board['file'];
        $file_dir = "./file/".$filename;
        $filepath = $file_dir;
        $path_parts = pathinfo($filepath);
        $filename = $path_parts['basename'];
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Transfer-Encoding: binary");
        ob_clean();
        flush();
        readfile($filepath);
    }


}

?>
