<?php

function Homeindex() {
  $view = 'home';
  $cate = listAll('danhmuc');
  $title = ' ';
  // debug($cate); // Uncomment for debugging if necessary

  $pro = listSelling('sanpham');
  $proNew = listNew('sanpham');

  require_once PATH_VIEW . 'layouts/master.php';  
}
function About() {
  $view = 'gioithieu';
  
  $cate = listAll('danhmuc');

  $title = ' - Giới thiệu';
  require_once PATH_VIEW . 'layouts/master.php';  
}


function  Blog() {
  $view = 'tintuc';
  $cate = listAll('danhmuc');

  $title = ' - Tin tức';
  require_once PATH_VIEW . 'layouts/master.php';  

}


function  Contact() {
  $view = 'lienhe';
  $cate = listAll('danhmuc');

  $title = ' - Liên hệ';
  require_once PATH_VIEW . 'layouts/master.php';  

}


