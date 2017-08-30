<?php

    class Page
    {
        public $recordTotalCount;//레코드 총 갯수
        public $firstPage;       //현재 페이지 첫 목록 번호
        public $lastPage;        //현재 페이지 끝 목록 번호
        public $finalPage;       //제일 마지막 번호
        public $nowPage;


        const SHOWRECORD = 6;       //한 페이지에 출력 레코드 수
        const PAGES = 10;           //페이지 목록 수 10개 까지

        public function __construct($nowPage,$rows){
            $this->recordTotalCount = count($rows);      //$rows
            $this->nowPage = $nowPage;
            $this->firstPage = $this->firstPageFunc($this->nowPage );
            $this->lastPage = $this->lastPageFunc($this->nowPage );
            $this->finalPage = $this->finalPageFunc();


            if($this->lastPage > $this->finalPage){
                $this->lastPage = $this->finalPage;
            }



        }


        public function finalPageFunc(){
            if( $this->recordTotalCount % self::SHOWRECORD == 0 ){
                return floor( $this->recordTotalCount/self::SHOWRECORD );
            }else{

                return floor( $this->recordTotalCount/self::SHOWRECORD ) + 1;
            }
        }



        public function firstPageFunc($nowPage){
           $page = $nowPage / self::PAGES;

           $page = (floor($page) * self::PAGES) + 1;

            if( $nowPage % self::PAGES == 0){
                $page -= self::PAGES;
                return $page;
            }else {
                return $page;
            }
        }

        public function lastPageFunc($nowPage){
            $page = $nowPage / self::PAGES;
            $page = (floor($page) * self::PAGES) + self::PAGES;

            if( $nowPage % self::PAGES == 0){
                $page -= self::PAGES;
                return $page;
            }else {

                return $page;
            }
        }




    }
?>