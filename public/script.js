function redirectToBrand(event) {
    event.preventDefault();
    var brandId = document.getElementById('brand-select').value;
    if (brandId) {
        window.location.href = '/car_find/' + brandId;
    }
}