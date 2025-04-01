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

    setupAutoSubmit("sortCar", "sort-form", ["brand-select", "search-input"]);
    setupAutoSubmit("brand-select", "brand-form", ["sortCar", "search-input"]);
    setupAutoSubmit("fuel-type", "fuel-type-form", ["sortCar", "brand-select", "search-input"]);
    setupAutoSubmit("car-type", "car-type-form", ["sortCar", "brand-select", "search-input"]);
    setupAutoSubmit("year-manufacture", "year-manufacture-form", ["sortCar", "brand-select", "search-input"]);
    setupAutoSubmit("price-range", "price-form", ["sortCar", "brand-select", "search-input"]);
});

document.getElementById("reset-filters").addEventListener("click", function () {
    let form = document.getElementById("filter-form");

    form.reset();
    
    form.querySelectorAll("select").forEach(select => select.value = "");

    form.submit();
});

function updatePrice() {
    var carSelect = document.getElementById("car_id");
    var quantityInput = document.getElementById("quantity");
    var totalPriceInput = document.getElementById("total_price");
    var totalPriceDisplay = document.getElementById("total_price_display");

    var selectedCar = carSelect.options[carSelect.selectedIndex];
    var price = selectedCar.getAttribute("data-price") ? parseFloat(selectedCar.getAttribute("data-price")) : 0;
    var quantity = parseInt(quantityInput.value) || 1;

    var total = price * quantity;
    totalPriceInput.value = total;
    totalPriceDisplay.innerText = total.toLocaleString('vi-VN') + " VNĐ";
    carNameInput.value = selectedCar.getAttribute("data-name");
}

document.addEventListener("DOMContentLoaded", function() {
    updatePrice();
});
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
