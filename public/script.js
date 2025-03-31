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
});

document.addEventListener("DOMContentLoaded", function () {
    let searchInput = document.getElementById("search-input");
    let suggestionBox = document.createElement("div");
    suggestionBox.classList.add("suggestion-box");
    searchInput.parentNode.appendChild(suggestionBox);

    searchInput.addEventListener("input", function () {
        let query = searchInput.value.trim();
        if (query.length > 0) {
            fetch("/views/brands/suggest_brands.php?q=" + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    suggestionBox.innerHTML = "";
                    if (data.length > 0) {
                        data.forEach(item => {
                            let div = document.createElement("div");
                            div.classList.add("suggestion-item");
                            div.textContent = item;
                            div.addEventListener("click", function () {
                                searchInput.value = item;
                                suggestionBox.innerHTML = "";
                            });
                            suggestionBox.appendChild(div);
                        });
                    } else {
                        suggestionBox.innerHTML = "<div class='suggestion-item'>Không tìm thấy</div>";
                    }
                })
                .catch(error => console.error("Lỗi tải gợi ý:", error));
        } else {
            suggestionBox.innerHTML = "";
        }
    });

    document.addEventListener("click", function (e) {
        if (!searchInput.contains(e.target) && !suggestionBox.contains(e.target)) {
            suggestionBox.innerHTML = "";
        }
    });
});

document.getElementById('filter-toggle-btn').addEventListener('click', function () {
    const filterSection = document.getElementById('filter-section');
    filterSection.classList.toggle('d-none');
    });