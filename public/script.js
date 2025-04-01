document.addEventListener("DOMContentLoaded", function () {
    function setupAutoSubmit(selectId, formId, extraFields = []) {
        let selectElement = document.getElementById(selectId);
        if (selectElement) {
            selectElement.addEventListener("change", function () {
                let form = document.getElementById(formId);

                // Thêm các trường ẩn giữ giá trị của bộ lọc
                extraFields.forEach(fieldId => {
                    let field = document.getElementById(fieldId);
                    if (field) {
                        let input = document.createElement("input");
                        input.type = "hidden";
                        input.name = field.name;
                        input.value = field.value;
                        form.appendChild(input);
                    }
                });

                form.submit();
            });
        }
    }

    setupAutoSubmit("sortCar", "filter-form", ["brand-select", "search-input"]);
    setupAutoSubmit("brand-select", "filter-form", ["sortCar", "search-input"]);
    setupAutoSubmit("fuel-type", "filter-form", ["sortCar", "brand-select", "search-input"]);
    setupAutoSubmit("car-type", "filter-form", ["sortCar", "brand-select", "search-input"]);
    setupAutoSubmit("year-manufacture", "filter-form", ["sortCar", "brand-select", "search-input"]);
    setupAutoSubmit("price-range", "filter-form", ["sortCar", "brand-select", "search-input"]);

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

    function resetFilters() {
        let form = document.getElementById("filter-form");
        if (!form) {
            console.error("Không tìm thấy form có ID 'filter-form'");
            return;
        }

        console.log("Resetting filters...");
        form.reset();
        form.querySelectorAll("select").forEach(select => select.value = "");
        let searchInput = document.getElementById("search-input");
        if (searchInput) {
            searchInput.value = "";
        }

        localStorage.removeItem("filterData");
        console.log("Form reset hoàn tất. Submitting...");
        form.submit();
    }

    let resetButton = document.getElementById("reset-filters");
    if (resetButton) {
        resetButton.addEventListener("click", resetFilters);
    } else {
        console.error("Không tìm thấy nút reset-filters.");
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
});