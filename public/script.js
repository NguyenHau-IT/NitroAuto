let filterToggleBtn = document.getElementById("filter-toggle-btn");
let filterDropdown = document.getElementById("filter-dropdown");

if (filterToggleBtn && filterDropdown) {
    // Mở và đóng dropdown khi nhấn vào nút
    filterToggleBtn.addEventListener("click", function (e) {
        e.stopPropagation(); // Ngăn không cho sự kiện truyền ra ngoài
        filterDropdown.classList.toggle("show");
    });

    // Đóng dropdown khi nhấn ra ngoài
    document.addEventListener("click", function (e) {
        if (!filterToggleBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
            filterDropdown.classList.remove("show");
        }
    });

    // Đặt lại bộ lọc khi nhấn nút "Đặt lại"
    document.getElementById("reset-filters").addEventListener("click", function () {
        document.getElementById("filter-form").reset(); // Đặt lại các bộ lọc về mặc định
        filterDropdown.classList.remove("show"); // Đóng dropdown sau khi reset
    });
}

function updatePrice() {
    const carSelect = document.getElementById('car_id');
    const carQuantity = document.getElementById('quantity');
    const accessorySelect = document.getElementById('accessory_id');
    const accessoryQuantity = document.getElementById('accessory_quantity');
    const totalPriceDisplay = document.getElementById('total_price_display');
    const totalPriceInput = document.getElementById('total_price');
    const carNameInput = document.getElementById('car_name');

    let subtotal = 0;

    // Xử lý xe
    const selectedCar = carSelect.options[carSelect.selectedIndex];
    const carPrice = parseFloat(selectedCar.getAttribute('data-price') || 0);
    if (carSelect.value) {
        if (!carQuantity.value || carQuantity.value <= 0) {
            carQuantity.value = 1;
        }
        subtotal += carPrice * parseInt(carQuantity.value);
        carNameInput.value = selectedCar.getAttribute('data-name') || '';
    }

    // Xử lý phụ kiện
    const selectedAccessory = accessorySelect.options[accessorySelect.selectedIndex];
    const accessoryPrice = parseFloat(selectedAccessory.getAttribute('data-accessosy-price') || 0);
    if (accessorySelect.value) {
        if (!accessoryQuantity.value || accessoryQuantity.value <= 0) {
            accessoryQuantity.value = 1;
        }
        subtotal += accessoryPrice * parseInt(accessoryQuantity.value);
    }

    // Tính thuế VAT 8%
    const vat = subtotal * 0.08;
    const total = subtotal + vat;

    // Gán vào input (để submit)
    totalPriceInput.value = total;

    // Hiển thị chi tiết
    totalPriceDisplay.innerHTML = `
        <div><strong>Tạm tính:</strong> ${subtotal.toLocaleString('vi-VN')} VNĐ</div>
        <div><strong>Thuế VAT (8%):</strong> ${vat.toLocaleString('vi-VN')} VNĐ</div>
        <div><strong>Tổng thanh toán:</strong> <span class="text-danger fw-bold">${total.toLocaleString('vi-VN')} VNĐ</span></div>
    `;
}

// Gọi khi trang load
document.addEventListener("DOMContentLoaded", function () {
    updatePrice();
});

document.addEventListener("DOMContentLoaded", function () {
    const filterForm = document.getElementById("filter-form");
    const searchForm = document.getElementById("search-form");
    const filterDropdown = document.getElementById("filter-dropdown");
    const filterFromCurrentYearBtn = document.getElementById("filter-from-current-year");

    if (filterForm) {
        // Submit form via AJAX (fetch)
        filterForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent page reload

            const formData = new FormData(filterForm);

            fetch("/filter-cars", {
                method: "POST",
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    document.getElementById("car-list-container").innerHTML = data;
                    if (filterDropdown) {
                        filterDropdown.classList.remove("show");
                    }
                })
                .catch(error => console.error("Lỗi khi tải dữ liệu:", error));
        });

        filterForm.addEventListener("reset", function () {
            setTimeout(() => {
                filterForm.dispatchEvent(new Event("submit", { bubbles: true, cancelable: true }));
            }, 0);
        });
    }

    if (searchForm) {
        // Submit form via AJAX (fetch)
        searchForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent page reload

            const formData = new FormData(searchForm);

            fetch("/filter-cars", {
                method: "POST",
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    document.getElementById("car-list-container").innerHTML = data;
                })
                .catch(error => console.error("Lỗi khi tải dữ liệu:", error));
        });
    }

    if (filterFromCurrentYearBtn) {
        filterFromCurrentYearBtn.addEventListener("click", function () {
            const currentYear = new Date().getFullYear();

            // Set năm sản xuất trong filter-form
            const yearSelect = document.getElementById("year-manufacture-select");
            if (yearSelect) {
                yearSelect.value = currentYear;
            }

            // Gửi form để lọc
            if (filterForm) {
                filterForm.dispatchEvent(new Event("submit", { bubbles: true, cancelable: true }));
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const dateRange = document.getElementById('date-range');
    const customRange = document.getElementById('custom-date-range');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const orderCards = document.querySelectorAll('.order-card');

    let currentStatus = 'all';

    window.filterOrders = function (status) {
        currentStatus = status;
        applyFilter();
    };

    dateRange.addEventListener('change', function () {
        if (this.value === 'custom') {
            customRange.style.display = 'block';
        } else {
            customRange.style.display = 'none';
            applyFilter();
        }
    });

    startDate.addEventListener('change', applyFilter);
    endDate.addEventListener('change', applyFilter);

    function applyFilter() {
        const selectedRange = dateRange.value;
        const now = new Date();
        let start = null;
        let end = new Date();

        if (selectedRange === 'today') {
            start = new Date();
            start.setHours(0, 0, 0, 0);
        } else if (selectedRange === 'last_week') {
            start = new Date();
            start.setDate(now.getDate() - 7);
        } else if (selectedRange === 'this_month') {
            start = new Date(now.getFullYear(), now.getMonth(), 1);
        } else if (selectedRange === 'last_5_days') {
            start = new Date();
            start.setDate(now.getDate() - 5);
        } else if (selectedRange === 'custom') {
            if (startDate.value && endDate.value) {
                start = new Date(startDate.value);
                end = new Date(endDate.value);
                end.setHours(23, 59, 59, 999);
            } else {
                start = null;
            }
        } else if (selectedRange === 'none') {
            start = null;
        }

        orderCards.forEach(card => {
            const cardStatus = card.classList;
            const cardDateStr = card.getAttribute('data-date');
            const statusMatch = (currentStatus === 'all') || cardStatus.contains(currentStatus);
            let dateMatch = true;

            if (start && cardDateStr) {
                const cardDate = new Date(cardDateStr + 'T00:00:00');
                dateMatch = (cardDate >= start && cardDate <= end);
            }

            card.style.display = (statusMatch && dateMatch) ? 'block' : 'none';
        });
    }

    applyFilter();
});

$(document).ready(function () {
    $('.quantity-input').on('input', function () {
        const quantity = parseInt($(this).val());
        const price = parseFloat($(this).data('price'));
        const id = $(this).data('id');

        if (quantity >= 1) {
            const total = quantity * price;

            // Format tiền tệ VNĐ
            const formattedTotal = total.toLocaleString('vi-VN') + 'VNĐ';

            // Cập nhật vào cột "Thành tiền"
            $('#total-' + id).text(formattedTotal);
        }
    });
});

$(document).ready(function () {
    $('.quantity-input').on('input', function () {
        const quantity = parseInt($(this).val());
        const price = parseFloat($(this).data('price'));
        const id = $(this).data('id');

        if (quantity >= 1) {
            $.ajax({
                url: '/update_cart',
                method: 'POST',
                data: {
                    id: id,
                    quantity: quantity
                },
                success: function (response) {
                    const total = quantity * price;
                    const formattedTotal = total.toLocaleString('vi-VN') + ' VNĐ';
                    $('#total-' + id).text(formattedTotal);
                },
                error: function () {
                    alert('Lỗi khi cập nhật số lượng!');
                }
            });
        }
    });
});

document.getElementById('logoutBtn').addEventListener('click', function(e) {
    e.preventDefault(); // Không chuyển hướng ngay

    Swal.fire({
        title: 'Đăng xuất?',
        text: 'Bạn có chắc chắn muốn đăng xuất không?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Đăng xuất',
        cancelButtonText: 'Hủy',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/logout';
        }
    });
});