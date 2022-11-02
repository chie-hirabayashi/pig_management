// htmlにidで埋め込み

let malePigs = document.getElementById('malePigs');
malePigs.
console.log(malePigs);
let element = document.getElementById('choice');
console.log(element);
element.onchange = function () {
  let a = this.value;
  document.getElementById('box').textContent = a;
}

