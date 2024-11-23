<style>
    .gallery {
        background: #EEE;
    }

    .gallery-cell {
        width: 100%;
    }

    .gallery-cell img {
        width: 100%;
        height: auto;
        display: block;
    }

    .thumbnail {
        cursor: pointer;
        height: auto;
        border: 2px solid transparent;
    }

    .thumbnail.active {
        border-color: #000;
    }

    .thumbnail-slider {
        overflow: hidden;
        margin-top: 1rem;
        /* Thêm khoảng cách trên */
    }

    .thumbnail-slider .gallery-cell {
        width: auto;
        /* Chiều rộng tự động cho các cell */
        margin-right: 1rem;
        /* Khoảng cách giữa các cell */
    }

    .thumbnail-slider .gallery-cell img {
        width: 100px;
        /* Chiều rộng cố định cho thumbnail */
        height: auto;
        /* Chiều cao tự động */
        display: block;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .thumbnail-slider .gallery-cell img.active {
        border-color: #000;
    }

    .variant-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .variant-button {
        /* Màu nền của nút */
        color: #090d14;
        /* Màu chữ */
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .variant-button:focus {
        outline: none;
    }

    .variant-group {
        display: flex;
        align-items: baseline;
    }

    .item-variant {
        display: flex;
        align-items: center;
        margin: 0 2em 2em 0;
    }

    .list-variants {
        list-style: none;
        display: flex;

    }

    /* Lớp cơ bản cho nút */
    .variant-button {
        border: 2px solid #ddd;
        background-color: transparent;
        border-radius: 4px;
        padding: 10px 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 5px;
    }

    /* Khi nút được nhấn */
    .variant-button.selected {
        border-color: #dc2626;
        background-color: transparent;
        position: relative;
    }

    /* Hiệu ứng dấu tích */
    .variant-button.selected::after {
        content: '\2713';
        color: #007bff;
        font-size: 15px;
        position: absolute;
        top: 8px;
        right: 1px;
        transform: translateY(-50%);
    }
</style>
<div class="container-fluid py-5">
    <div class="row px-xl-12">
        <!-- Phần hiển thị ảnh sản phẩm -->
        <div class="col-lg-5 pb-5">
            <div class="gallery">
                <!-- Sử dụng Flickity để hiển thị các item -->
                <?php if (!empty($pro['anh_all'])) : ?>
                    <?php $anhPaths = explode(',', $pro['anh_all']); ?>
                    <?php foreach ($anhPaths as $index => $path) : ?>
                        <div class="gallery-cell">
                            <img class="w-100 h-100" src="<?= BASE_URL . '/' . $path ?>" alt="Image">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div id="image-thumbnails" class="mt-3">
                <div class="thumbnail-slider">
                    <?php if (!empty($pro['anh_all'])) : ?>
                        <?php $anhPaths = explode(',', $pro['anh_all']); ?>
                        <?php foreach ($anhPaths as $index => $path) : ?>
                            <div class="gallery-cell">
                                <img src="<?= BASE_URL . '/' . $path ?>" alt="Thumbnail Image" class="thumbnail" data-index="<?= $index ?>">
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Phần thông tin sản phẩm -->
        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold"><?= $pro['ten'] ?></h3>
            <h3>
                <?php if (isset($pro['gia_sale']) && !empty($pro['gia_sale'])) : ?>
                    <?= number_format($pro['gia_sale']) ?> VNĐ<br>
                    <del><?= number_format($pro['gia']) ?></del> VNĐ
                <?php else : ?>
                    $<?= number_format($pro['gia']) ?>
                <?php endif; ?>
            </h3>
            <!-- <h3 class="font-weight-semi-bold mb-4"><?= number_format($pro['gia']) ?>VNĐ</h3> -->
            <p class="mb-4"><?= $pro['mota_ngan'] ?></p>
            <div class="d-flex mb-4">
                <form>
                    <!-- Các lựa chọn màu sắc -->
                    <?php if (!empty($pro['variants']['Màu sắc'])) : ?>
                        <div class="variant-group">
                            <strong class="item-variant-name">Màu sắc</strong>
                            <ul class="list-variants">
                                <?php foreach ($pro['variants']['Màu sắc'] as $index => $variantValue) : ?>
                                    <li class="item-variant">
                                        <button class="variant-button" data-type="color" data-value="<?= htmlspecialchars($variantValue) ?>" data-index="<?= $index ?>" title="<?= htmlspecialchars($variantValue) ?>">
                                            <?= htmlspecialchars($variantValue) ?>
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Dung lượng -->
                    <?php if (!empty($pro['variants']['Dung lượng'])) : ?>
                        <div class="variant-group">
                            <strong class="item-variant-name">Dung lượng</strong>
                            <ul class="list-variants">
                                <?php foreach ($pro['variants']['Dung lượng'] as $index => $variantValue) : ?>
                                    <li class="item-variant">
                                        <button class="variant-button" data-type="capacity" data-value="<?= htmlspecialchars($variantValue) ?>" data-index="<?= $index ?>" title="<?= htmlspecialchars($variantValue) ?>">
                                            <?= htmlspecialchars($variantValue) ?>
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Thêm các lựa chọn khác ở đây -->
                    <!-- Example for adding another variant group -->
                    <?php if (!empty($pro['variants']['Another Variant'])) : ?>
                        <div class="variant-group">
                            <strong class="item-variant-name">Another Variant</strong>
                            <ul class="list-variants">
                                <?php foreach ($pro['variants']['Another Variant'] as $index => $variantValue) : ?>
                                    <li class="item-variant">
                                        <button class="variant-button" data-type="another-type" data-value="<?= htmlspecialchars($variantValue) ?>" data-index="<?= $index ?>" title="<?= htmlspecialchars($variantValue) ?>">
                                            <?= htmlspecialchars($variantValue) ?>
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
            <div class="d-flex align-items-center mb-4 pt-2">
                <div class="input-group quantity mr-3" style="width: 130px;">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-minus">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control bg-secondary text-center" value="1">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-plus">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <a href="<?= BASE_URL . '?act=cart-add&productID=' . $pro['id'] . '&quantity=1'  ?>"><button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button></a>
            </div>
        </div>
    </div>
    <!-- Các tab mô tả và đánh giá -->
    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews</a>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <h4 class="mb-3">Mô tả sản phẩm</h4>
                    <p><?= $pro['mota'] ?></p>
                </div>
                <div class="tab-pane fade" id="tab-pane-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4">Review for "<?= $pro['ten'] ?>"</h4>
                            <?php foreach ($commentshowone as $comment) : ?>
                                <div class="media mb-4">
                                    <img src="<?= $comment['anh'] ?>" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                    <div class="media-body">
                                        <h6><?= $comment['ten_taikhoan'] ?><small> - <i><?= $comment['ngay'] ?></i></small></h6>
                                        <p><?= $comment['text'] ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-4">Bình luận</h4>
                            <?php $loggedIn = isset($_SESSION['user']); ?>
                            <?php if ($loggedIn) : ?>
                                <form method="post" action="">
                                    <div class="form-group">
                                        <textarea rows="5" cols="50" name="binhluan" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary px-3">Gửi</button>
                                </form>
                            <?php else : ?>
                                <p>Vui lòng <a href="?act=login">đăng nhập</a> để gửi bình luận.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sản phẩm liên quan -->
<div class="container-fluid py-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                <?php foreach ($produc as $produc) : ?>
                    <div class="card product-item border-0">
                        <a href="" style="text-decoration: none;">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid w-100" src="<?= BASE_URL . '/' . $produc['anh_chinh']; ?>" alt="">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3"><?= $produc['ten'] ?></h6>
                                <div class="d-flex justify-content-center">
                                    <h6>
                                        <?php if (isset($produc['gia_sale']) && !empty($produc['gia_sale'])) : ?>
                                            <?= number_format($produc['gia_sale']) ?> VNĐ<br>
                                            <del><?= number_format($produc['gia']) ?></del> VNĐ
                                        <?php else : ?>
                                            $<?= number_format($produc['gia']) ?>
                                        <?php endif; ?>
                                    </h6>
                                </div>
                            </div>
                        </a>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Khởi tạo Flickity cho gallery
        var gallery = document.querySelector('.gallery');
        var flktyGallery = new Flickity(gallery, {
            cellAlign: 'left',
            contain: true,
            wrapAround: true,
            pageDots: false
        });

        // Khởi tạo Flickity cho thumbnail slider
        var thumbnailSlider = document.querySelector('.thumbnail-slider');
        var flktyThumbnails = new Flickity(thumbnailSlider, {
            cellAlign: 'left',
            contain: true,
            wrapAround: true,
            pageDots: false,
            freeScroll: true,
            groupCells: true // Đảm bảo các thumbnail hiển thị thành nhóm
        });

        // Cập nhật chỉ số slide khi chọn thumbnail và thêm lớp active
        var thumbnails = document.querySelectorAll('.thumbnail');

        thumbnails.forEach(function(thumbnail) {
            thumbnail.addEventListener('click', function() {
                // Loại bỏ lớp active từ tất cả các thumbnail
                thumbnails.forEach(function(img) {
                    img.classList.remove('active');
                });

                // Thêm lớp active vào thumbnail đã chọn
                this.classList.add('active');

                // Chọn ảnh tương ứng trong gallery
                var index = parseInt(this.getAttribute('data-index'), 10);
                flktyGallery.select(index);
            });
        });

        // Đảm bảo thumbnail đầu tiên được chọn khi trang được tải
        if (thumbnails.length > 0) {
            thumbnails[0].classList.add('active');
        }
        var buttons = document.querySelectorAll('.variant-button');

        buttons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định
                // Xử lý hành động khi nhấp vào nút
                var index = parseInt(this.getAttribute('data-index'), 10);
                console.log('Button clicked, index:', index);
                // Thực hiện hành động cần thiết, chẳng hạn như thay đổi ảnh trong gallery
            });
        });
        var buttons = document.querySelectorAll('.variant-button');

        buttons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định

                // Xác định loại biến thể (thuộc tính) và giá trị
                var type = this.getAttribute('data-type');
                var value = this.getAttribute('data-value');

                // Bỏ chọn tất cả các nút cho loại biến thể này
                var buttonsOfType = document.querySelectorAll('.variant-button[data-type="' + type + '"]');
                buttonsOfType.forEach(function(btn) {
                    btn.classList.remove('selected');
                });

                // Chọn nút hiện tại
                this.classList.add('selected');

                // Lấy tất cả các biến thể đã chọn
                var selectedVariants = {};

                buttons.forEach(function(btn) {
                    if (btn.classList.contains('selected')) {
                        var type = btn.getAttribute('data-type');
                        var value = btn.getAttribute('data-value');

                        if (!selectedVariants[type]) {
                            selectedVariants[type] = value;
                        }
                    }
                });

                // In ra các biến thể đã chọn (hoặc xử lý theo cách khác)
                console.log('Selected Variants:', selectedVariants);

                // Thực hiện các hành động khác nếu cần, ví dụ, cập nhật giao diện người dùng
            });
        });
    });
</script>