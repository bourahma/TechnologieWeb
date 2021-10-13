/* à compléter */

window.onload = function () {
  var x = document.getElementById('bgcheck');
  x.addEventListener("change", funct);

  function funct() {
    x.from.bg.disabled = this.checked;
  }
}
