let products = [];
if (localStorage.getItem('products')) {
    products = JSON.parse(localStorage.getItem('products'));
}


document.addEventListener('DOMContentLoaded', () => {
    const cart = document.querySelector('.add-to-cart__html')
    const cartOpen = document.querySelector('.add-to-cart__html-open')
    const cartBg = document.querySelector('.add-to-cart__html-bg')
    const cartContainer = document.querySelector('.add-to-cart__html__container')
    const cartSubmit = document.querySelector('.add-to-cart__html button')
    const cartID = document.querySelector('.add-to-cart__id')
    const cartVal = document.querySelector('.add-to-cart__value')
    const cartTitle = document.querySelector('.add-to-cart__title')
    const cartPrice = document.querySelector('.add-to-cart__price')
    const cartBtn = document.querySelector('.add-to-cart__button')
    const cartList = document.querySelector('.add-to-cart__html ul')
    const cartInput = document.querySelector('.add-to-cart__html-input')


    if (cartVal?.value !== null)
        cartBtn?.addEventListener('click', () => {
            if (cartVal.value >= 1)
                addToCart()
            else console.log('masukkan jumlah')

        })

    cartOpen?.addEventListener('click', () => {
        cartContainer.classList.add('is-open')
    })


    const addToCart = () => {
        products = products.filter(x => x.productId != cartID.value)
        products.push({
            productId: cartID.value,
            title: cartTitle.value,
            value: cartVal.value,
            price: cartPrice.value
        });

        localStorage.setItem('products', JSON.stringify(products));
        loadCart();
        showCart()
    }

    const loadCart = () => {
        let products = JSON.parse(localStorage.getItem('products'));
        cartList.innerHTML = products?.map(product => {
            return (
                '<li class="add-to-cart__html__list-single">' +
                '<span class="add-to-cart__html__list-single__delete">[x]</span> '
                + product.title + ' ( ' + product.value + ' )' +
                '</li>')
        }).join('')
    }

    const showCart = () => {
        cart.style.left = '50%'
        cartContainer.classList.add('is-open')

        setTimeout(() => {
            cart.style.left = '100%'

        }, 3000);
    }


    submitCart = () => {
        let products = JSON.parse(localStorage.getItem('products'));
        const productsList = products.map(product => product.productId)
        const productsAmount = products.map(product => product.value)
        cartInput.querySelector('[name="nvn-products"]').value = productsList
        cartInput.querySelector('[name="nvn-amounts"]').value = productsAmount

        cart.submit()
    }

    loadCart();


    /** utilities*/
    // modal
    cartBg.addEventListener('click', () => cartContainer.classList.remove("is-open"))
    // submit
    cartSubmit.addEventListener('click', () => {
        submitCart()
    })
})

// use `` got some hidden error
const cartHTML = '\
<div class="add-to-cart__html-open"><button type="button">[view cart]</button></div>\
<div class="add-to-cart__html__container">\
    <div class="add-to-cart__html-bg"></div>\
    <div class="add-to-cart__html-close"></div>\
    <form action="/checkout" method="post" class="add-to-cart__html">\
        <ul class="add-to-cart__html__list"></ul>\
        <div class="add-to-cart__html-input">\
            <input type="hidden" name="nvn-products"/>\
            <input type="hidden" name="nvn-amounts"/>\
        </div>\
        <button type="button">Checkout</button>\
    </form>\
</div>'

document.body.innerHTML += cartHTML;