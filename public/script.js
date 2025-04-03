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
    let carSelect = document.getElementById("car_id");
    let quantityInput = document.getElementById("quantity");
    let totalPriceInput = document.getElementById("total_price");
    let totalPriceDisplay = document.getElementById("total_price_display");
    let carNameInput = document.getElementById("car_name");

    if (!carSelect || !quantityInput || !totalPriceInput || !totalPriceDisplay || !carNameInput) {
        console.error("Một hoặc nhiều phần tử bị thiếu.");
        return;
    }

    let selectedCar = carSelect.options[carSelect.selectedIndex];
    let price = selectedCar.getAttribute("data-price") ? parseFloat(selectedCar.getAttribute("data-price")) : 0;
    let quantity = parseInt(quantityInput.value) || 1;

    let total = price * quantity;
    totalPriceInput.value = total;
    totalPriceDisplay.innerText = total.toLocaleString('vi-VN') + " VNĐ";
    carNameInput.value = selectedCar.getAttribute("data-name");
}

if (document.getElementById("car_id")) {
    updatePrice();
}


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

    // Lọc theo trạng thái
    window.filterOrders = function (status) {
        currentStatus = status;
        applyFilter();
    };

    // Lọc theo thời gian khi thay đổi dropdown
    dateRange.addEventListener('change', function () {
        if (this.value === 'custom') {
            customRange.style.display = 'block';
        } else {
            customRange.style.display = 'none';
            applyFilter();
        }
    });

    // Lọc khi người dùng chọn ngày tùy chỉnh
    startDate.addEventListener('change', applyFilter);
    endDate.addEventListener('change', applyFilter);

    function applyFilter() {
        const selectedRange = dateRange.value;
        const now = new Date();

        let start = null;
        let end = new Date(); // hôm nay

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
            const sDate = startDate.value;
            const eDate = endDate.value;
            if (sDate && eDate) {
                start = new Date(sDate);
                end = new Date(eDate);
                end.setHours(23, 59, 59, 999);
            }
        }

        orderCards.forEach(card => {
            const statusMatch = (currentStatus === 'all') || card.classList.contains(currentStatus);
            const orderDateStr = card.querySelector('p:last-child').textContent.match(/\d{2}\/\d{2}\/\d{4}/)?.[0];
            let dateMatch = true;

            if (start && orderDateStr) {
                const [day, month, year] = orderDateStr.split('/');
                const orderDate = new Date(`${year}-${month}-${day}`);
                dateMatch = orderDate >= start && orderDate <= end;
            }

            if (statusMatch && dateMatch) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
});
