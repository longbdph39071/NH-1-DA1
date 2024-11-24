<div class="col-md-9">
    <div class="card">
        <div class="card-header p-2">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle rounded-circle" src="<?= BASE_URL .$_SESSION['user']['anh'] ?>" alt="User profile picture" width="150">
                </div>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <input type="file" name="anh" id="" value="Ảnh">
                    <strong><i class="fa-solid fa-file-signature"></i> Tên</strong><br>
                    <input type="text" name="ten" value="<?= $_SESSION['user']['ten'] ?>">
                    <strong><i class="fa-regular fa-envelope"></i> Email</strong><br>
                    <input type="text" name="email" value="<?= $_SESSION['user']['email'] ?>">
                    <hr>
                    <strong><i class="fa-solid fa-phone-volume"></i> Số điện thoại</strong><br>
                    <input type="text" name="sodienthoai" value="<?= $_SESSION['user']['sodienthoai'] ?>">
                    <hr>
                    <strong><i class="fa-solid fa-calendar-days"></i> Ngày sinh</strong><br>
                    <input type="date" name="ngaysinh" value="<?= $_SESSION['user']['ngaysinh'] ?>">
                    <hr>
                    <strong><i class="fa-solid fa-location-dot"></i> Địa chỉ</strong><br>
                    <input type="text" name="diachi" value="<?= $_SESSION['user']['diachi'] ?>">
                    <hr>
                    <strong><i class="fa-solid fa-lock"></i> Mật khẩu</strong><br>
                    <input type="text" name="matkhau" value="<?= $_SESSION['user']['matkhau'] ?>">
                    <hr>
                    <button type="submit" class="btn mt-3 btn-warning">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>

</div>