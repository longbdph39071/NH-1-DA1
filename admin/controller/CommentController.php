<?php

function commentListAll()
{
    $title = 'Danh sách bình luận';
    $view = 'comment/index';
    $scrips = 'datatable';
    $scrips2 = 'comment/scrips';
    $style = 'datatable';

    $comment = ListshowALLComment('binhluan');

    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}
function commentDelete($id)
{
    delete('binhluan', $id);

    header('location: ' . BASE_URL_ADMIN . '?act=comment');
    exit();

    require_once PATH_VIEW_ADMIN . 'layouts/master.php';
}
