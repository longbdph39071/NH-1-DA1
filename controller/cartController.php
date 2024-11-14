<?php

function cartAdd($productID, $quantity = 0)
{
    $product = showOne('sanpham', $productID);

    if (empty($product)) {
        debug('404 notfound');
    }

    $cartId = getCartID($_SESSION['user']['id']);
    $_SESSION['cartId'] = $cartId;

    if ($quantity <= 0) {
        debug('Invalid quantity');
    }

    if (!isset($_SESSION['cart'][$productID])) {
        $_SESSION['cart'][$productID] = $product;
        $_SESSION['cart'][$productID]['soluong'] = $quantity;
        insert('giohang_item', [
            'id_giohang' => $cartId,
            'id_sanpham' => $productID,
            'soluong' => $quantity,
        ]);
    } else {
        $qty = $_SESSION['cart'][$productID]['soluong'] += $quantity;
        updateQuantitybyCartIDAndProductID($cartId, $productID, $qty);
    }

    header('Location: ' . BASE_URL . '?act=cart');
}

function cartList()
{
    $view = 'cart';
    $title = ' - Giỏ hàng';
    $cate = listAll('danhmuc');

    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . '?act=login');
        exit();
    }
    require_once PATH_VIEW . 'layouts/master.php';
}

function cartInc($productID)
{
    $product = showOne('sanpham', $productID);
    if (empty($product)) {
        debug('404 notfound');
    }
    if (isset($_SESSION['cart'][$productID])) {
        $qty = $_SESSION['cart'][$productID]['soluong'] += 1;
        updateQuantitybyCartIDAndProductID($_SESSION['cartId'], $productID, $qty);
        header('Location:' . BASE_URL . '?act=cart');
    }
}

function cartDec($productID)
{
    $product = showOne('sanpham', $productID);
    if (empty($product)) {
        debug('404 notfound');
    }
    if (isset($_SESSION['cart'][$productID]) && $_SESSION['cart'][$productID]['soluong'] > 1) {
        $qty = $_SESSION['cart'][$productID]['soluong'] -= 1;
        updateQuantitybyCartIDAndProductID($_SESSION['cartId'], $productID, $qty);
    } else {
        unset($_SESSION['cart'][$productID]);
        deleteCartItemByCartIDAndProductID($_SESSION['cartId'], $productID);
    }
    header('Location:' . BASE_URL . '?act=cart');
}

function cartDel($productID)
{
    $product = showOne('sanpham', $productID);
    if (empty($product)) {
        debug('404 notfound');
    }
    if (isset($_SESSION['cart'][$productID])) {
        unset($_SESSION['cart'][$productID]);
        deleteCartItemByCartIDAndProductID($_SESSION['cartId'], $productID);
    }
    header('Location:' . BASE_URL . '?act=cart');
}
?>