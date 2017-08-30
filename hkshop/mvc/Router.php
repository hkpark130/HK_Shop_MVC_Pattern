<?php
class Router{
    //Routing 정보를 저장하는 프로파티
    protected $_convertedRoutes;

    // ***Constructor**
    // $routedef:Routing 정보를 정의한 배열(APP클래스에서 정의)
    public function __construct($routedef){
        $this->_convertedRoutes = $this->routeConverter($routedef);
    }

public function routeConverter($routedef){
  $converted = array();
  foreach ($routedef as $url => $par){
    $converts = explode('/', ltrim($url,'/'));
    foreach($converts as $i => $convert){

      if(0 ===strpos($convert, ':')){

        $bar = substr($convert,1);
        $convert = '(?<'.$bar.'>[^/]+)';

      }
      $converts[$i] = $convert;

    }
    $pattern = '/'.implode('/',$converts);

    $converted[$pattern]=$par;

  }
  return $converted;


}

public function getRouteParams($path){

  if('/' !== substr($path,0,1)){
    $path = '/'.$path;
  }
  foreach ($this -> _convertedRoutes as $pattern => $par){
    if(preg_match('#^'.$pattern.'$#',$path,$p_match)){
      //$pattern을 반드시 만족하도록 ^시작종료$
      $par = array_merge($par, $p_match);

      return $par;
    }
  }
  return false;
}
}
