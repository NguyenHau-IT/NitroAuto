
console.log("✅ script.js loaded");

let filterToggleBtn = document.getElementById("filter-toggle-btn");
let filterDropdown = document.getElementById("filter-dropdown");

if (filterToggleBtn && filterDropdown) {
    filterToggleBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        filterDropdown.classList.toggle("show");
    });

    document.addEventListener("click", function (e) {
        if (!filterToggleBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
            filterDropdown.classList.remove("show");
        }
    });

    const resetBtn = document.getElementById("reset-filters");
    const filterForm = document.getElementById("filter-form");
    if (resetBtn && filterForm) {
        resetBtn.addEventListener("click", function () {
            filterForm.reset();
            filterDropdown.classList.remove("show");
        });
    }
}

function updatePrice() {
    const carSelect = document.getElementById('car_id');
    const carQuantity = document.getElementById('quantity');
    const accessorySelect = document.getElementById('accessory_id');
    const accessoryQuantity = document.getElementById('accessory_quantity');
    const totalPriceDisplay = document.getElementById('total_price_display');
    const totalPriceInput = document.getElementById('total_price');
    const carNameInput = document.getElementById('car_name');

    if (!carSelect || !carQuantity || !accessorySelect || !accessoryQuantity ||
        !totalPriceDisplay || !totalPriceInput || !carNameInput) return;

    let subtotal = 0;

    const selectedCar = carSelect.options[carSelect.selectedIndex];
    const carPrice = parseFloat(selectedCar.getAttribute('data-price') || 0);
    if (carSelect.value) {
        if (!carQuantity.value || carQuantity.value <= 0) {
            carQuantity.value = 1;
        }
        subtotal += carPrice * parseInt(carQuantity.value);
        carNameInput.value = selectedCar.getAttribute('data-name') || '';
    }

    const selectedAccessory = accessorySelect.options[accessorySelect.selectedIndex];
    const accessoryPrice = parseFloat(selectedAccessory.getAttribute('data-accessosy-price') || 0);
    if (accessorySelect.value) {
        if (!accessoryQuantity.value || accessoryQuantity.value <= 0) {
            accessoryQuantity.value = 1;
        }
        subtotal += accessoryPrice * parseInt(accessoryQuantity.value);
    }

    const vat = subtotal * 0.08;
    const total = subtotal + vat;

    totalPriceInput.value = total;

    totalPriceDisplay.innerHTML = `
        <div><strong>Tạm tính:</strong> ${subtotal.toLocaleString('vi-VN')} VNĐ</div>
        <div><strong>Thuế VAT (8%):</strong> ${vat.toLocaleString('vi-VN')} VNĐ</div>
        <div><strong>Tổng thanh toán:</strong> <span class="text-danger fw-bold">${total.toLocaleString('vi-VN')} VNĐ</span></div>
    `;
}

document.addEventListener("DOMContentLoaded", function () {
    updatePrice();

    const filterForm = document.getElementById("filter-form");
    const searchForm = document.getElementById("search-form");
    const filterDropdown = document.getElementById("filter-dropdown");
    const filterFromCurrentYearBtn = document.getElementById("filter-from-current-year");

    if (filterForm) {
        filterForm.addEventListener("submit", function (event) {
            event.preventDefault();
            const formData = new FormData(filterForm);
            fetch("/filter-cars", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                const carList = document.getElementById("car-list-container");
                if (carList) carList.innerHTML = data;
                if (filterDropdown) filterDropdown.classList.remove("show");
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
        searchForm.addEventListener("submit", function (event) {
            event.preventDefault();
            const formData = new FormData(searchForm);
            fetch("/filter-cars", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                const carList = document.getElementById("car-list-container");
                if (carList) carList.innerHTML = data;
            })
            .catch(error => console.error("Lỗi khi tải dữ liệu:", error));
        });
    }

    if (filterFromCurrentYearBtn) {
        filterFromCurrentYearBtn.addEventListener("click", function () {
            const yearSelect = document.getElementById("year-manufacture-select");
            if (yearSelect) yearSelect.value = new Date().getFullYear();
            if (filterForm) {
                filterForm.dispatchEvent(new Event("submit", { bubbles: true, cancelable: true }));
            }
        });
    }

    const dateRange = document.getElementById('date-range');
    const customRange = document.getElementById('custom-date-range');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const orderCards = document.querySelectorAll('.order-card');

    if (dateRange && customRange && startDate && endDate && orderCards.length > 0) {
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
    }

    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
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
    }

    const params = new URLSearchParams(window.location.search);
    const status = params.get("status");
    const message = params.get("message");

    if (status && message && typeof Swal !== 'undefined') {
        let icon = "info";
        let title = "Thông báo";

        if (status === "success") {
            icon = "success";
            title = "Thành công!";
        } else if (status === "error") {
            icon = "error";
            title = "Lỗi!";
        } else if (status === "warning") {
            icon = "warning";
            title = "Cảnh báo!";
        }

        Swal.fire({
            icon: icon,
            title: title,
            text: decodeURIComponent(message),
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        }).then(() => {
            history.replaceState(null, "", window.location.pathname);
        });
    }

    const selectAll = document.getElementById("select-all");
    const checkboxes = document.querySelectorAll(".select-item");

    if (selectAll) {
        selectAll.addEventListener("change", function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    }
    
    const quantityInputs = document.querySelectorAll(".quantity-input");

    quantityInputs.forEach(input => {
        input.addEventListener("input", function () {
            const quantity = parseInt(this.value) || 1;
            const itemId = this.name.match(/\d+/)[0];
            const price = parseInt(this.dataset.price);

            // Gọi AJAX cập nhật server
            fetch("/update_cart_quantity", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    id: itemId,
                    quantity: quantity,
                }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const totalElement = document.getElementById("total-" + itemId);
                    if (totalElement) {
                        const total = price * quantity;
                        totalElement.textContent = total.toLocaleString("vi-VN") + " VNĐ";
                    }
                } else {
                    alert("Cập nhật thất bại!");
                }
            })
            .catch(() => alert("Lỗi kết nối đến server."));
        });
    });
});
