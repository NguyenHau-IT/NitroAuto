<div class="row d-flex flex-wrap justify-content-center" id="car-list">
            <?php if (!empty($cars)): ?>
                <?php foreach ($cars as $car): ?>
                    <div class="card car-card m-2" style="width: 23%;">
                        <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="car-img-container">
                            <img src="<?= htmlspecialchars(!empty($car["image"]) ? $car["image"] : '/uploads/cars/default.jpg') ?>"
                                class="card-img-top car-image"
                                alt="<?= htmlspecialchars($car['name']) ?>">
                        </a>
                        <div class="card-body text-center">
                            <div class="car-title mb-3" style="height: 50px;">
                                <h4 class="card-title fs-1">
                                    <strong>
                                        <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="text-white">
                                            <?= htmlspecialchars($car['name']) ?>
                                        </a>
                                    </strong>
                                </h4>
                            </div>
                            <p class="card-text fs-5"><i class="fas fa-money-bill-wave me-1"></i> Giá:
                                <span class="fw-bold"><?= number_format($car['price'], 0, ',', '.') ?> VNĐ</span>
                            </p>
                            <p class="card-text fs-5">
                                <i class="fas fa-gas-pump"></i> <?= htmlspecialchars($car['fuel_type']) ?> |
                                <i class="fas fa-car"></i> <?= htmlspecialchars($car['category_name']) ?>
                            </p>
                            <div class="favorite-btn mt-2 d-flex justify-content-between">
                                <form action="/add_favorite" method="POST" class="me-2">
                                    <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-heart"></i> Yêu thích
                                    </button>
                                </form>
                                <form action="/showOrderForm" method="POST" class="me-2">
                                    <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']); ?>">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-shopping-cart"></i> Đặt mua
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning text-center" role="alert">
                    ⚠️ Không tìm thấy xe nào phù hợp với tiêu chí tìm kiếm của bạn.
                </div>
            <?php endif; ?>
        </div>