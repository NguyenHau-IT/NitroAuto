console.log("✅ script.js loaded");
const toggleBtn = document.getElementById('toggle-theme');
const icon = toggleBtn.querySelector('i');

const currentTheme = localStorage.getItem('theme');
if (currentTheme === 'dark') {
    enableDarkMode();
}

toggleBtn.addEventListener('click', () => {
    if (document.body.classList.contains('bg-dark')) {
        disableDarkMode();
    } else {
        enableDarkMode();
    }
});

function enableDarkMode() {
    document.body.classList.add('bg-dark', 'text-white');
    toggleBtn.classList.remove('btn-outline-dark');
    toggleBtn.classList.add('btn-outline-light');
    icon.classList.replace('bi-moon-fill', 'bi-sun-fill');
    localStorage.setItem('theme', 'dark');
}

function disableDarkMode() {
    document.body.classList.remove('bg-dark', 'text-white');
    toggleBtn.classList.remove('btn-outline-light');
    toggleBtn.classList.add('btn-outline-dark');
    icon.classList.replace('bi-sun-fill', 'bi-moon-fill');
    localStorage.setItem('theme', 'light');
}

document.addEventListener("DOMContentLoaded", function () {

    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
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

    if (document.getElementById('cart-count')) {
        fetch('/countCart')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('cart-count');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            });
    }
});