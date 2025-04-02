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
    const filterDropdown = document.getElementById("filter-dropdown");

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
});

function filterOrders(status) {
    document.querySelectorAll('.order-card').forEach(card => {
        if (status === 'all' || card.classList.contains(status)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

let filterToggleBtn = document.getElementById("filter-toggle-btn");
let filterDropdown = document.getElementById("filter-dropdown");

if (filterToggleBtn && filterDropdown) {
    filterToggleBtn.addEventListener("click", function () {
        filterDropdown.classList.toggle("show");
    });

    document.addEventListener("click", function (e) {
        if (!filterToggleBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
            filterDropdown.classList.remove("show");
        }
    });
}