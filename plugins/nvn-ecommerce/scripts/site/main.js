/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/site/js/main.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/site/js/main.js":
/*!*****************************!*\
  !*** ./src/site/js/main.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("var products = [];\n\nif (localStorage.getItem('products')) {\n  products = JSON.parse(localStorage.getItem('products'));\n}\n\ndocument.addEventListener('DOMContentLoaded', function () {\n  var cart = document.querySelector('.add-to-cart__html');\n  var cartOpen = document.querySelector('.add-to-cart__html-open');\n  var cartBg = document.querySelector('.add-to-cart__html-bg');\n  var cartContainer = document.querySelector('.add-to-cart__html__container');\n  var cartSubmit = document.querySelector('.add-to-cart__html button');\n  var cartID = document.querySelector('.add-to-cart__id');\n  var cartVal = document.querySelector('.add-to-cart__value');\n  var cartTitle = document.querySelector('.add-to-cart__title');\n  var cartPrice = document.querySelector('.add-to-cart__price');\n  var cartBtn = document.querySelector('.add-to-cart__button');\n  var cartList = document.querySelector('.add-to-cart__html ul');\n  var cartInput = document.querySelector('.add-to-cart__html-input');\n  if ((cartVal === null || cartVal === void 0 ? void 0 : cartVal.value) !== null) cartBtn === null || cartBtn === void 0 ? void 0 : cartBtn.addEventListener('click', function () {\n    if (cartVal.value >= 1) addToCart();else console.log('masukkan jumlah');\n  });\n  cartOpen === null || cartOpen === void 0 ? void 0 : cartOpen.addEventListener('click', function () {\n    cartContainer.classList.add('is-open');\n  });\n\n  var addToCart = function addToCart() {\n    products = products.filter(function (x) {\n      return x.productId != cartID.value;\n    });\n    products.push({\n      productId: cartID.value,\n      title: cartTitle.value,\n      value: cartVal.value,\n      price: cartPrice.value\n    });\n    localStorage.setItem('products', JSON.stringify(products));\n    loadCart();\n    showCart();\n  };\n\n  var loadCart = function loadCart() {\n    var products = JSON.parse(localStorage.getItem('products'));\n    cartList.innerHTML = products === null || products === void 0 ? void 0 : products.map(function (product) {\n      return '<li class=\"add-to-cart__html__list-single\">' + '<span class=\"add-to-cart__html__list-single__delete\">[x]</span> ' + product.title + ' ( ' + product.value + ' )' + '</li>';\n    }).join('');\n  };\n\n  var showCart = function showCart() {\n    cart.style.left = '50%';\n    cartContainer.classList.add('is-open');\n    setTimeout(function () {\n      cart.style.left = '100%';\n    }, 3000);\n  };\n\n  submitCart = function submitCart() {\n    var products = JSON.parse(localStorage.getItem('products'));\n    var productsList = products.map(function (product) {\n      return product.productId;\n    });\n    var productsAmount = products.map(function (product) {\n      return product.value;\n    });\n    cartInput.querySelector('[name=\"nvn-products\"]').value = productsList;\n    cartInput.querySelector('[name=\"nvn-amounts\"]').value = productsAmount;\n    cart.submit();\n  };\n\n  loadCart();\n  /** utilities*/\n  // modal\n\n  cartBg.addEventListener('click', function () {\n    return cartContainer.classList.remove(\"is-open\");\n  }); // submit\n\n  cartSubmit.addEventListener('click', function () {\n    submitCart();\n  });\n}); // use `` got some hidden error\n\nvar cartHTML = '\\\n<div class=\"add-to-cart__html-open\"><button type=\"button\">[view cart]</button></div>\\\n<div class=\"add-to-cart__html__container\">\\\n    <div class=\"add-to-cart__html-bg\"></div>\\\n    <div class=\"add-to-cart__html-close\"></div>\\\n    <form action=\"/checkout\" method=\"post\" class=\"add-to-cart__html\">\\\n        <ul class=\"add-to-cart__html__list\"></ul>\\\n        <div class=\"add-to-cart__html-input\">\\\n            <input type=\"hidden\" name=\"nvn-products\"/>\\\n            <input type=\"hidden\" name=\"nvn-amounts\"/>\\\n        </div>\\\n        <button type=\"button\">Checkout</button>\\\n    </form>\\\n</div>';\ndocument.body.innerHTML += cartHTML;\n\n//# sourceURL=webpack:///./src/site/js/main.js?");

/***/ })

/******/ });