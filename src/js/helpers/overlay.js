// overlay funcs
var fjOverlayElt = document.getElementById('fj-overlay-elt'),
  overlayClasses = ['animate', 'fadeIn', 'fadeOut'],
  overlayTimeout;

function showOverlay(overlayItems, el) {
  fjOverlayElt.classList.remove('is-hidden');
  fjOverlayElt.classList.add('animate', 'fadeIn');
  multiCall(doClasses, overlayItems, ['below-overlay']);
  if(overlayTimeout) {
    overlayTimeout.clearTimeout();
    overlayTimeout = false;
  }
  if(el) {
    el.classList.remove('below-overlay');
  }
}

function hideOverlay(overlayItems) {
  fjOverlayElt.classList.add('animate', 'fadeOut');
  overlayTimeout = setTimeout(function () {
    multiCall(doClasses, overlayItems, ['below-overlay'], true);
    doClasses(fjOverlayElt, overlayClasses, true);
    fjOverlayElt.classList.add('is-hidden');
    overlayTimeout = false;
  }, 600);
}