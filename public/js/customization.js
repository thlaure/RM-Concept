document.getElementById('shopping_cart_product_customized_customization_image').onchange = function (evt) {
    let tgt = evt.target || window.event.srcElement,
        files = tgt.files;
    if (FileReader && files && files.length) {
        let fr = new FileReader();
        fr.onload = function () {
            document.getElementById('out-image').src = fr.result;
        };
        fr.readAsDataURL(files[0]);
    }
};