/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************!*\
  !*** ./resources/js/information.js ***!
  \*************************************/
// htmlにidで埋め込み

var malePigs = document.getElementById('malePigs');
malePigs.console.log(malePigs);
var element = document.getElementById('choice');
console.log(element);
element.onchange = function () {
  var a = this.value;
  document.getElementById('box').textContent = a;
};
/******/ })()
;