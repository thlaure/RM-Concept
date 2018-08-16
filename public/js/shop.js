let choiceCustomization = document.getElementById('shopping_cart_product_is_customized');
let btnCustomization = document.getElementById('btn_customization');
if (choiceCustomization === 'Non') {
    btnCustomization.href = '#';
} else {
    btnCustomization.href = '##';
}