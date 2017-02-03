// Big ol' <3'z to Paul Irish because, you know,
// he's like a brother from another mother and stuff. xD
window.requestAnimFrame = (function () {
  return window.requestAnimationFrame ||
    window.webkitRequestAnimationFrame ||
    window.mozRequestAnimationFrame ||
    window.oRequestAnimationFrame ||
    window.msRequestAnimationFrame ||
    function (callback) {
      window.setTimeout(callback.bind.this(this), 1000 / 60);
    };
})();

// helper call via raf
function rafCall(func) {
  for(var _len = arguments.length, args = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
    args[_key - 1] = arguments[_key];
  }

  requestAnimFrame(func.bind.apply(func, [this].concat(args)));
}