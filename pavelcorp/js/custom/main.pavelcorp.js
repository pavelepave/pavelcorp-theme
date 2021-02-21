/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _scss_header_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./scss/header.scss */ \"./src/scss/header.scss\");\n/* harmony import */ var _js_utils_affixElement__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./js/utils/affixElement */ \"./src/js/utils/affixElement.js\");\n/* harmony import */ var _js_utils_functions__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./js/utils/functions */ \"./src/js/utils/functions.js\");\n// Style\n\n\n\n/**\n * Navbar DOM id\n * @type {String}\n */\n// const NAVBAR_ID = 'SiteHeader';\n\n(0,_js_utils_functions__WEBPACK_IMPORTED_MODULE_2__.onDomContentLoaded)(() => {\n  for (let i = 0; i < document.images.length; i++) {\n    const img = document.images[i];\n\n    if (img.dataset.srcset) {\n      img.srcset = img.dataset.srcset;\n      delete img.dataset.srcset;\n    }\n  }\n});\n\n//# sourceURL=webpack://pavelcorp-template/./src/index.js?");

/***/ }),

/***/ "./src/js/utils/affixElement.js":
/*!**************************************!*\
  !*** ./src/js/utils/affixElement.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (/* export default binding */ __WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/**\n * Affix breakpoint\n * @name NAVBAR_HIDE\n * @memberOf moduleScroll\n * @constant\n * @type {number}\n */\nconst NAVBAR_HIDE = 20;\n/**\n * Affix class name\n * @name AFFIX_CLASS\n * @memberOf moduleScroll\n * @constant\n * @type {string}\n */\n\nconst AFFIX_CLASS = 'affix';\n/**\n * Affix navbar\n * @constructor moduleScroll\n * @param  {HTMLElement} navbar [description]\n */\n\nfunction Affix(navbar, options) {\n  'use strict';\n\n  if (!navbar) {\n    return console.warn('Affix: navbar element not found.');\n  }\n\n  options = options || {};\n  this.threshold = options.threshold ? options.threshold : NAVBAR_HIDE;\n  this.affixClass = options.affixClass ? options.affixClass : AFFIX_CLASS;\n  this.navbarAffix = false;\n  this.affix = affix.bind(this);\n  affix.call(this);\n\n  function _setAffix(bool) {\n    let action = bool ? 'add' : 'remove';\n    this.navbarAffix = bool;\n    navbar.classList[action](this.affixClass);\n  }\n\n  function affix() {\n    if (window.scrollY > this.threshold && !this.navbarAffix) _setAffix.call(this, true);\n    if (window.scrollY <= this.threshold && this.navbarAffix) _setAffix.call(this, false);\n  }\n\n  return this;\n}\n/** Affix */\n\n\n/* harmony default export */ function __WEBPACK_DEFAULT_EXPORT__(navbar, options) {\n  const module = new Affix(navbar, options);\n  window.addEventListener('scroll', module.affix);\n  return function () {\n    window.removeEventListener('scroll', module.affix);\n  };\n}\n\n//# sourceURL=webpack://pavelcorp-template/./src/js/utils/affixElement.js?");

/***/ }),

/***/ "./src/js/utils/functions.js":
/*!***********************************!*\
  !*** ./src/js/utils/functions.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"onDomContentLoaded\": () => (/* binding */ onDomContentLoaded)\n/* harmony export */ });\n/**\n * Add a function to fire when DOM is loaded\n * @function\n * @name onDomContentLoaded\n * @memberof FunctionsIndex\n * @param {function} cb Callback function to execute when DOM is ready\n */\nfunction onDomContentLoaded(cb) {\n  /**\n   * Set DOMLoaded variable when DOM has loaded\n   */\n  let loop = setInterval(() => {\n    if (document.readyState === 'complete' || document.readyState === 'interactive') {\n      cb();\n      clearInterval(loop);\n    }\n  }, 10);\n}\n\n//# sourceURL=webpack://pavelcorp-template/./src/js/utils/functions.js?");

/***/ }),

/***/ "./src/scss/header.scss":
/*!******************************!*\
  !*** ./src/scss/header.scss ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n\n\n//# sourceURL=webpack://pavelcorp-template/./src/scss/header.scss?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		if(__webpack_module_cache__[moduleId]) {
/******/ 			return __webpack_module_cache__[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./src/index.js");
/******/ 	
/******/ })()
;