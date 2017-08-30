<?php
require './Page.php';

class ShopController extends Controller{
  protected $_authentication = array('post','manager','buy'); //login필요한 action정의

  const PRODUCT = 'manager/post';

  const BUY = 'buy';


    public function indexAction($page){
        $items = $this->_connect_model->get('shop')->getItemData();
        $nowPage = 1;
        if( isset($page['page']) ) {
            $nowPage = $page['page'];
            $pages = new Page($page['page'], $items);
        }else{
            $pages = new Page(1, $items);
        }

        $items = $this->_connect_model->get('shop')->getOffsetItemData(
            $nowPage,
            $pages::SHOWRECORD);

        $index_view = $this->render(array(
            'pages' => $pages,
            'items' => $items,
        ));

        return $index_view;
    }

    public function searchAction($par){
        $keyword =  ( is_null( $this->_request->getPost('keyword') ) )? null:$this->_request->getPost('keyword');
        $category = ( isset( $par['keyword'] ) )? $par['keyword']:null;
        $is_category = false;

        switch ($category){
            case 'clothes' :
                $items = $this->_connect_model->get('Shop')->SearchItemData($category);
                $is_category = true;
                break;
            case "pants" :
                $items = $this->_connect_model->get('Shop')->SearchItemData($category);
                $is_category = true;
                break;
            case "shoes" :
                $items = $this->_connect_model->get('Shop')->SearchItemData($category);
                $is_category = true;
                break;
            case "etc" :
                $items = $this->_connect_model->get('Shop')->SearchItemData($category);
                $is_category = true;
                break;
            default :
                if( $keyword != '' ){       //키워드가 포스트로 존재 (검색 첫 화면)
                    $items = $this->_connect_model->get('Shop')->SearchItemData($keyword);
                }else{
                    if( isset($par['keyword']) ){   //키워드가 url로 존재 (페이징)
                        $keyword = $par['keyword'];
                        $items = $this->_connect_model->get('Shop')->SearchItemData($keyword);
                        var_dump($par);
                    }else{
                        return $this->redirect('/');
                    }
                }
        }

        $nowPage = 1;
        if( isset($par['page']) ) {
            $nowPage = $par['page'];
            $pages = new Page($par['page'], $items);
        }else{
            $pages = new Page(1, $items);
        }


        if($is_category){
            $keyword = $category;
            $items = $this->_connect_model->get('shop')->getOffsetSearchItemData(
                $nowPage,
                $pages::SHOWRECORD,
                $category);
        }
        else{
            $items = $this->_connect_model->get('shop')->getOffsetSearchItemData(
                $nowPage,
                $pages::SHOWRECORD,
                $keyword);
        }

        $index_view = $this->render(array(
            'items'=> $items,
            'pages'=> $pages,
            'keyword'=> $keyword,
        ));

        return $index_view;

    }

    public function postAction(){

        if(!$this->_request->isPost()){
            $this->httpNotFound();
        }

        $token = $this->_request->getPost('_token');
        if(!$this->checkToken(self::PRODUCT,$token)) {
            return $this->redirect('/');
        }

        $name = $this->_request->getPost('item_name');
        $price = $this->_request->getPost('item_price');
        $category = $this->_request->getPost('category');
        $item_img = $this->_request->getFile('item_img');
        $upfile = ( is_null( $this->_request->getFile('upfile') ) )? null:$this->_request->getFile('upfile');
        $contents = $this->_request->getPost('item_contents');

        $img = date("YmdHis").$item_img['name'];

        $tmp_file = array();        //파일 임시 저장소
        $save_filename = array();   //이미지들 실제 저장경로
        $upload_filename = array(); //이미지들 이름 .확장자명 포함됨!

        $save_img = "./image/".$img;   //대표 이미지
        $img_tmp_file = $item_img['tmp_name'];//대표 이미지 임시 저장소

        $save_img = mb_convert_encoding($save_img, "EUC-KR");

        if( !move_uploaded_file($img_tmp_file,$save_img) ){

        }

        foreach($upfile['name'] as $key=>$value){     //다중이미지 업로드

            $upload_filename[] = date("YmdHis").$value;
            $save_filename[] = "./image/".date("YmdHis").$value;
        }
        foreach($upfile['tmp_name'] as $key=>$value){
            $tmp_file[] = $value;
        }

        for($i=0;$i<count($tmp_file);$i++){
            $save_filename[$i] = mb_convert_encoding($save_filename[$i], "EUC-KR");
            if(!move_uploaded_file($tmp_file[$i],$save_filename[$i])){
                echo "$save_filename[$i]";

            }
        }

        $count = 0;
        $up_imgs = array();
        for( ; !empty($upload_filename[$count]) ;$count++){             //다중 이미지 수 세기

            $up_imgs[] = $upload_filename[$count];
        }

        $this->_connect_model->get('shop')->insert($name,$price,$category,$img,$contents);

        $item_sub_id = $this->_connect_model->get('shop')->getItemRecord($img);   //id값 어떻게 전달하지..

        $this->_connect_model->get('shop')->subImgInsert($item_sub_id['id'],$count,$up_imgs);

        return $this->redirect('/');

    }


public function managerAction()       //토큰값 확인하고 구현할 것
{

    $user = $this->_session->get('user');

    if(!$user['permition']){
        return $this->redirect('/');
    }else {

        $manager_view = $this->render(array(
            '_token' => $this->getToken(self::PRODUCT),
        ));

        return $manager_view;
    }
}



    public function buyAction($id)       //토큰값 확인하고 구현할 것
    {


        $token = $this->_request->getPost('_token');
        if(!$this->checkToken(self::BUY,$token)) {
            return $this->redirect('/');
        }

        $user = $this->_session->get('user');
        $item = $this->_connect_model->get('shop')->getItemIdRecord($id['id']);

        $ea = $this->_request->getPost('ea');
        $cost = $ea * $item['item_price'];

        $this->_connect_model->get('shop')->insertHistory(
            $item['item_name'],
            $user['user_name'],
            $item['item_title_image'],
            $item['category'],
            $ea,
            $cost
        );

        return $this->redirect('/');
    }



    public function showAction($id)
    {

        if(!$this->_session->isAuthenticated()){
            return $this->redirect('/account');
        }
        $item = $this->_connect_model->get('shop')->getItemIdRecord($id['id']);
        $item_sub_img = $this->_connect_model->get('shop')->getImgData($id['id']);

        $product_view = $this->render(array(
            'item' => $item,
            'item_sub_img' => $item_sub_img,
            '_token' => $this->getToken(self::BUY),
        ));

        return $product_view;
    }





}
 ?>

