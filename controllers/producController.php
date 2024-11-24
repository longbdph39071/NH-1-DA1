<?php

function singerDetail($id)
{
  // $pro = oneForPro($id);
  $cate =  listAll('danhmuc');
  $pro = oneForProLiOne($id);
  // debug($pro);
  $proD = showOne('sanpham', $id);
  $produc = listCL('sanpham', $id);
  $view = 'detail';
  $title = ' - '. $pro['ten'];

  $loggedIn = isset($_SESSION['user_id']);

  $commentshowone = ListshowONEComment('binhluan', $id);

  if (!empty($_POST)) {
    $data = [
      'id_sanpham' => $id,
      'ten' => $_SESSION['user']['ten'],
      'ngay' => $timeDate = date('Y-m-d H:i:s'),
      'id_taikhoan' => $_SESSION['user']['id'],
      'text' => $_POST['binhluan'],
    ];

    insert('binhluan', $data);
    header('location: ' . BASE_URL . '?act=singer-detail&id=' . $id);
    exit();
  }
  require_once PATH_VIEW . 'layouts/master.php';
}

function shopListAll()
{
  $cate =  listAll('danhmuc');
  $view = 'shop';
  $pro = listAll('sanpham');

  $title = ' - Cửa hàng';


  require_once PATH_VIEW . 'layouts/master.php';
}
function listCatePro($idCate)
{
  $category = showOne('danhmuc', $idCate);
  $pro = listCateProAll($idCate);
  $view = 'categories';
  $cate =  listAll('danhmuc');

  $title = ' - Danh mục';

  if (isset($_SESSION['user'])) {
    require_once PATH_VIEW . 'layouts/master-1.php';
  } else {
    require_once PATH_VIEW . 'layouts/master-1.php';
  }
}