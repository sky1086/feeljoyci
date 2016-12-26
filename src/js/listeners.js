// custom mina easing
mina.easeOutExpo = function (n) {
  return(n == 1) ? 1 : -Math.pow(2, -10 * n) + 1;
};
var svgIconConfig = {
    hamburger: {
      url: 'svg/hamburger.svg',
      animation: [{
        el: 'path:nth-child(1)',
        animProperties: {
          from: {
            val: '{"path" : "M 3,6 3,8 21,8 21,6 3,6 Z"}'
          },
          to: {
            val: '{"path" : "M 11.992214,3.9981903 10.578,5.4124036 18.497595,13.332 19.911809,11.917787 Z"}'
          }
        }
      }, {
        el: 'path:nth-child(2)',
        animProperties: {
          from: {
            val: '{"path" : "m 3,13 18,0 0,-2 -18,0 0,2 z"}'
          },
          to: {
            val: '{"path" : "m 11,5.5 0,14.5 2,0 0,-14.5 -2,0 z"}'
          }
        }
      }, {
        el: 'path:nth-child(3)',
        animProperties: {
          from: {
            val: '{"path" : "m 3,18 18,0 0,-2 -18,0 0,2 z"}'
          },
          to: {
            val: '{"path" : "M 11.959596,4.00619 4.04,11.925786 5.4542136,13.34 13.37381,5.420404 11.959596,4.00619 Z"}'
          }
        }
      }]
    }
  },
  menuButton = document.getElementById('fj-icon-hamburger'),
  main = document.getElementById('fj-main-content'),
  fjFloatMenu = document.getElementById('fj-float-menu'),
  fjDiversionButton = document.getElementById('fj-diversion-button'),
  // fjHomeButton = document.getElementById('fj-home-button'),
  fjInnerContent = document.getElementById('fj-inner-content'),
  fjLayout = document.getElementById('fj-layout'),
  fjContentLoading = document.getElementById('fj-content-loading'),
  fjLoaderCircular = document.getElementById('fj-loader-circular'),
  fjRetryLoader = document.getElementById('fj-retry-loader'),
  fjFloatContainer = document.getElementById('fj-float-container'),
  header = document.getElementById('fj-main-header'),
  fjHeaderTitle = document.getElementById('fj-header-title'),
  fjHeaderLogo = document.getElementById('fj-header-logo'),
  svgicon = new svgIcon(menuButton, svgIconConfig, {
    easing: mina.easeOutExpo
  }),
  redirect = false,
  isIconMenuOpen = false,
  isMenuOpen = false,
  ifNoAnimation = false,
  // base api url
  // TODO replace it with https for better results
  base_url = 'partials/listeners.json',
  // base_url = 'partials/api/',
  // id is also the base route
  fjLayout_Hammer = new Hammer.Manager(fjLayout, {}),
  // fj_diversion_Hammer = new Hammer(fjDiversionButton),
  defaultRoute = 0,
  page_scroll = 0,
  page_scrollVal = 0,
  page_scrollDir = Hammer.DIRECTION_NONE,
  isPageMoving = false,
  pageCalc = false,
  page_cards = [],
  page_firstChild = '',
  page_lastChild = '',
  page_cardCount = 0,
  page_viewPortCards = 0,
  page_cardPeek = 0,
  page_topHeight = 0,
  page_menuAdded = false,
  page_colors = ['cyan', 'darkcyan', 'darkgreen', 'green', 'white', 'inverted'],
  true_colors = ['cyan', 'darkcyan', 'darkgreen', 'green'],
  // to determine the type of swipe / scroll to implement
  scrollThreshold = 0.5,
  stdEasing = 's cubic-bezier(.4, 0, .2, 1)',
  outEasing = 's cubic-bezier(.4, 0, 1, 1)',
  inEasing = 's cubic-bezier(0, 0, .2, 1)',
  pageHash = [],
  timeouts = {
    menuClose: '',
    menuOpen: '',
    showFjLoader: ''
  },
  // configuring hammer options
  fjLayoutTap = new Hammer.Tap(),
  fjLayoutPan = new Hammer.Pan({
    direction: Hammer.DIRECTION_ALL
  });

// adding recognisers for both
fjLayout_Hammer.add([fjLayoutPan, fjLayoutTap]);

// open close menu function
function menuToggle() {
  if(isMenuOpen) {
    menuClose();
  } else {
    menuOpen();
  }
}

// multi calls to an array quickly helper
function multiCall(func, arr) {
  var i = arr.length;

  for(var _len = arguments.length, arg = Array(_len > 2 ? _len - 2 : 0), _key = 2; _key < _len; _key++) {
    arg[_key - 2] = arguments[_key];
  }

  while(i--) {
    func.apply(this, [arr[i]].concat(arg));
  }
}

function menuClose() {
  // if page cards aren't calculated
  if(!pageCalc) {
    calculateCardValues();
  }
  // send the timing
  var time = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0.3,
    transitionTime = time * 1000;
  isPageMoving = true;
  fjFloatMenu.classList.remove('visible');
  // reset any present transform or transitions
  setTransform(main, '');
  setTransition(main, time + inEasing);
  // temporarily disable handlers
  fjLayout_Hammer.set({
    enable: false
  });
  // animate the cards down
  // for # of viewport fixed items
  var i = page_viewPortCards;
  while(i--) {
    if(i > 0) {
      rafCall(setTransform, page_cards[i], '');
      setTransition(page_cards[i], time + inEasing);
    }
  }
  // clear any previous timeouts
  window.clearTimeout(timeouts.menuClose);
  // remove transition values in the end
  timeouts.menuClose = window.setTimeout(function () {
    setTransition(main, '');
    multiCall(setTransition, page_cards, '');
    // reset scroll pos
    page_scroll = 0;
    page_scrollVal = 0;
    page_scrollDir = Hammer.DIRECTION_NONE;
    isPageMoving = false;
    // reenable them later
    fjLayout_Hammer.set({
      enable: true
    });
    // change logo and title state
    fjHeaderTitle.classList.remove('fj-fade-down');
    fjHeaderLogo.classList.add('fj-fade-down');
  }, transitionTime);
  dummyToggle();
}

function menuOpen() {
  // if page cards aren't calculated
  if(!pageCalc) {
    calculateCardValues();
  }
  // send the timing
  var time = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0.3,
    transitionTime = time * 1000;
  isPageMoving = true;
  fjFloatMenu.classList.add('visible');
  // reset any present transform or transitions
  setTranslate3dY(main, 'calc(100% - 50px)');
  if(!ifNoAnimation) {
    setTransition(main, time + outEasing);
  }
  multiCall(setTransform, page_cards, '');
  multiCall(setOpacity, page_cards, '');
  // temporarily disable handlers
  fjLayout_Hammer.set({
    enable: false
  });
  // animate the cards down
  // for # of viewport fixed items
  var i = page_viewPortCards;
  while(i--) {
    if(i > 0) {
      rafCall(setTranslate3dY, page_cards[i], 'calc(' + (page_cardPeek * i) + 'px - ' + (100 * i) + '%)');
      if(!ifNoAnimation) {
        setTransition(page_cards[i], time + outEasing);
      }
    }
  }
  // clear any previous timeouts
  window.clearTimeout(timeouts.menuOpen);
  // remove transition values in the end

  function callFunc() {
    setTransition(main, '');
    multiCall(setTransition, page_cards, '');
    // reset scroll pos
    page_scroll = 0;
    page_scrollVal = window.innerHeight - header.offsetHeight - 50;
    page_scrollDir = Hammer.DIRECTION_NONE;
    isPageMoving = false;
    // reenable them later
    fjLayout_Hammer.set({
      enable: true
    });
    // change logo and title state
    fjHeaderTitle.classList.add('fj-fade-down');
    fjHeaderLogo.classList.remove('fj-fade-down');
    dummyToggle();
  }

  if(ifNoAnimation) {
    callFunc();
  } else {
    timeouts.menuOpen = window.setTimeout(callFunc.bind(callFunc), transitionTime);
  }
}

function dummyToggle() {
  // dummy to fool the svgicons toggle
  var dummy = {};
  dummy.type = 'mouseover';
  svgIcon.prototype.options.toggleFn(dummy);
  // toggle menu open state
  isMenuOpen = !isMenuOpen;
}

// clear inner elements
function clearInner(el) {
  while(el.firstChild) el.removeChild(el.firstChild);
}

// show fj loader
function showFjLoader(justLoader) {
  if(justLoader) {
    fjContentLoading.classList.add('visible');
  }
  // clear any previous timeouts
  window.clearTimeout(timeouts.showFjLoader);
  timeouts.showFjLoader = window.setTimeout(function () {
    fjLoaderCircular.classList.add('is-active');
  }, 300)
}

// hide fj loader
function hideFjLoader(justLoader) {
  if(justLoader) {
    fjContentLoading.classList.remove('visible');
  }
  fjLoaderCircular.classList.remove('is-active');
}

// helper add and remove multiple classes
// true to remove
function doClasses(el, classes, action) {
  var i = classes.length;
  while(i--) {
    if(action) {
      el.classList.remove(classes[i])
    } else {
      el.classList.add(classes[i])
    }
  }
}

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

// highlight menu button
function highlightMenuButton(hash) {
  // remove highlight class from all the buttons
  var i = pages.firstclick.length;
  while(i--) {
    document.getElementById(pages.firstclick[i]._id)
      .classList.remove('is-highlighted');
  }
  document.getElementById('fj_' + hash.replace(/\-/g, '_') + '_button')
    .classList.add('is-highlighted');
}

// out custom function that converts names to valid urls
function nameToUrl(name) {
  var url = name,
    special = /[!@\#\$%\^&\*\(\)\-\=\_\+\?\\\[\]/.{}<>~`;,"']/g;
  // remove special charaters
  url = url.replace(special, '');
  // remove spaces trailing and preceding
  url = url.trim();
  // to lowercase
  url = url.toLowerCase();
  // spaces to -
  url = url.replace(/\s+/g, '-');
  return url;
}

// load page and list of listeners
function loadBasePage() {
  makeRequest(base_url)
    .then(function (data) {
      // parse hash from hasher
      initCardPage(JSON.parse(data));
    })
    .catch(function (err) {
      // TODO We reached our target server, but it returned an error so retry the last request
      showErrorButton();
      console.error(err);
    });
}

loadBasePage();

// only for the base first page
function initCardPage(data) {
  // turn off the loader icon
  hideFjLoader(true);
  var i, j, colorClass;
  // add content to it
  var frag = document.createDocumentFragment();
  for(i = 0; i < data.length; i++) {
    // anchor tag button
    var avatar = document.createElement('div'),
      icon = document.createElement('i'),
      cont = document.createElement('div'),
      textCont = document.createElement('div'),
      text = document.createElement('h5'),
      subText = document.createElement('h6');
    avatar.innerHTML = data[i].name.charAt(0);
    doClasses(avatar, ['fj-card-avatar', true_colors[Math.floor(Math.random() * true_colors.length)]]);
    doClasses(icon, ['icon-chat', 'fj-card-icon']);
    doClasses(cont, ['fj-card-figure', 'mdl-shadow--2dp', 'white']);
    textCont.classList.add('fj-card-text');
    text.innerHTML = data[i].name;
    subText.innerHTML = '1st Year NYU';
    textCont.appendChild(text);
    textCont.appendChild(subText);
    // cont.setAttribute('data-link', hash + '/' + data[i]._url);
    cont.appendChild(avatar);
    cont.appendChild(textCont);
    cont.appendChild(icon);
    frag.appendChild(cont);
  }
  // add frag to doc
  fjInnerContent.appendChild(frag);
  // remove hidden class after 600ms
  window.setTimeout(function () {
    fjInnerContent.classList.remove('is-hidden');
    doPageStuff([]);
    doClasses(main, ['animate', 'slideInUp']);
    // remove animated classes after animations are over
    window.setTimeout(function () {
      doClasses(main, ['animate', 'slideInUp', 'slideOutDown'], true);
      // reset calculations
      pageCalc = false;
      // set page to scroll mode and reset values
      page_scroll = 0;
      // enable the fj hammer after load
      fjLayout_Hammer.set({
        enable: true
      });
    }, 300);
  }, 300);
}

// do menu and other page loaded settings
function doPageStuff(passHash) {
  // parse hash from hasher
  // pageHash = (passHash.length > 0) ? passHash : hasher.getHashAsArray();
  // if the first click is not loaded
  // if(!page_menuAdded) {
  //   var frag = document.createDocumentFragment();
  //   for(var i in pages.firstclick) {
  //     // anchor tag button
  //     var button = document.createElement('button');
  //     doClasses(button, ['mdl-button', 'mdl-js-button', 'mdl-js-ripple-effect', 'fj-menu-button']);
  //     button.innerHTML = pages.firstclick[i].name;
  //     button.id = pages.firstclick[i]._id;
  //     button.setAttribute('data-link', pages.firstclick[i]._url);
  //     frag.appendChild(button);
  //   }
  //   icon - chat_bubble
  //     // add frag to doc
  //   fjFloatMenu.appendChild(frag);
  //   // toggle menu added to true
  //   page_menuAdded = true;
  //   // upgrade mdl
  //   componentHandler.upgradeDom();
  // }
  // set menu button hash
  // highlightMenuButton(pageHash[0]);
  // hide the inner content page and remove other unnecessary classes
  fjRetryLoader.classList.add('is-hidden');
  doClasses(fjInnerContent, ['animate', 'slideInUp', 'slideOutDown'].concat(page_colors), true);
  // set page title
  // upPageTitle(getOtherVal(pages.firstclick, '_url', pageHash[0], 'name'));
}

// update page title
function upPageTitle(title) {
  // change the document's title to match the new one for bookmark friendly-ness
  // http://stackoverflow.com/questions/413439/how-to-dynamically-change-a-web-pages-title
  document.title = 'Feeljoy' + (title ? ' - ' + title : '');
  fjHeaderTitle.innerHTML = title;
}

// helper to set the opacity via a function
function setOpacity(el, opacity) {
  el.style.opacity = opacity;
}

// helper set transform translate3d's
function setTransform(el, transform) {
  el.style.transform = transform;
  el.style.webkitTransform = transform;
  el.style.mozTransform = transform;
}

// set transition for all browsers
function setTransition(el, transition) {
  el.style.transition = transition;
  el.style.webkitTransition = transition;
  el.style.mozTransition = transition;
}

// load json promise style
// http://stackoverflow.com/questions/30008114/how-do-i-promisify-native-xhr
function makeRequest(url) {
  return new Promise(function (resolve, reject) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url);
    xhr.onload = function () {
      if(this.status >= 200 && this.status < 300) {
        resolve(xhr.response);
      } else {
        reject({
          status: this.status,
          statusText: xhr.statusText
        });
      }
    };
    xhr.onerror = function () {
      reject({
        status: this.status,
        statusText: xhr.statusText
      });
    };
    xhr.send();
  });
}

// show error button
function showErrorButton(page) {
  // hide the loader
  hideFjLoader();
  // show the error button
  fjRetryLoader.classList.remove('is-hidden');
  // add button click event and remove any past events
}

// tap overlay to close the diversion
fjLayout_Hammer.on('tap', function (ev) {
  var innerCards, i;
  // if inside hamburger button toggle the menu
  if(menuButton.contains(ev.target)) {
    menuToggle();
    return;
  }

  // tap home button to go to the default route which is currently the home page also
  // if(fjHomeButton.contains(ev.target) && page_type === 1) {
  //   hasher.setHash(mainRouter.interpolate({
  //     base: pages.firstclick[0]._url
  //   }));
  //   return;
  // }

  if(fjRetryLoader.contains(ev.target)) {
    location.reload();
    return;
  }

  // if on any of the floating menu button
  // innerCards = fjFloatMenu.querySelectorAll('.fj-menu-button'),
  //   i = innerCards.length;
  // while(i--) {
  //   // menu must be opened to do this
  //   if(innerCards[i].contains(ev.target) && isMenuOpen) {
  //     hasher.setHash(mainRouter.interpolate({
  //       base: innerCards[i].getAttribute('data-link')
  //     }));
  //     return;
  //   }
  // }

  // if inside tappable card angry, anxious etc. on a card page
  // innerCards = fjInnerContent.querySelectorAll('.fj-card-figure');
  // i = innerCards.length;
  // while(i--) {
  //   // also the menu must not be open
  //   if(innerCards[i].contains(ev.target) && !isMenuOpen && innerCards[i].getAttribute('data-link')) {
  //     hasher.setHash(innerCards[i].getAttribute('data-link'));
  //     return;
  //   }
  // }

  // click anywhere to close
  // if(isIconMenuOpen) {
  //   fjFloatContainer.classList.add('is-hidden');
  //   fjLayout.classList.remove('is-overlay');
  //   fjLayout_Hammer.get('pan')
  //     .set({
  //       enable: true
  //     });
  //   // toggle it's state
  //   isIconMenuOpen = !isIconMenuOpen;
  //   return;
  // }
});

// fab button tap events
// fj_diversion_Hammer.on('tap', function (ev) {
//   if(isIconMenuOpen) {
//     fjFloatContainer.classList.add('is-hidden');
//     fjLayout.classList.remove('is-overlay');
//     fjLayout_Hammer.get('pan')
//       .set({
//         enable: true
//       });
//     fjLayout_Hammer.get('swipe')
//       .set({
//         enable: true
//       });
//   } else {
//     fjFloatContainer.classList.remove('is-hidden');
//     fjLayout.classList.add('is-overlay');
//     fjLayout_Hammer.get('pan')
//       .set({
//         enable: false
//       });
//     fjLayout_Hammer.get('swipe')
//       .set({
//         enable: false
//       });
//   }
//   // toggle it's state
//   isIconMenuOpen = !isIconMenuOpen;
// });

// translateY helper
function getComputedTranslateY(obj) {
  if(!window.getComputedStyle) return;
  var style = getComputedStyle(obj),
    transform = style.transform || style.webkitTransform || style.mozTransform;
  var mat = transform.match(/^matrix3d\((.+)\)$/);
  if(mat) return parseFloat(mat[1].split(', ')[13]);
  mat = transform.match(/^matrix\((.+)\)$/);
  return mat ? parseFloat(mat[1].split(', ')[5]) : 0;
}

// helper set transform translate3d's y
function setTranslate3dY(el, y) {
  setTransform(el, 'translate3d(0, ' + y + ', 0)');
}

// get scroll velocity factor
// NOTE get it calculated
function getScrollVelocityFactor() {
  if(Modernizr.touch) {
    return 20;
  } else {
    return 5;
  }
}

// calculate academic cards and their defaults
function calculateCardValues() {
  // check if cards exist and move ahead, otherwise return
  page_cards = fjInnerContent.children;
  if(page_cards.length > 0) {
    page_cardCount = page_cards.length;
    page_firstChild = page_cards[0];
    if(page_firstChild) {
      page_cardHeight = page_firstChild.offsetHeight;
    }
    page_lastChild = page_cards[page_cardCount - 1];
    // number of cards on the viewport
    // TODO improve page viewport calc
    if(page_cardCount <= 4) {
      page_viewPortCards = page_cardCount;
    } else {
      page_viewPortCards = 4;
    }
    page_topHeight = window.innerHeight - header.offsetHeight - 50;
    // the cards peek because of this value
    page_cardPeek = 50 / page_viewPortCards;
    // set page calc true
    pageCalc = true;
  }
}

fjLayout_Hammer.on('swipeup', function (ev) {
  // if page cards aren't calculated
  if(!pageCalc) {
    calculateCardValues();
  }
  // if this is a scroll page
  var primary_card = page_scroll + 1,
    i = page_cardCount;
  // if the page is the first one then open the menu and also if it is closed
  if(isMenuOpen) {
    menuClose();
  } else if((page_scroll + page_viewPortCards) < page_cardCount && !isPageMoving) {
    if(page_scrollDir === Hammer.DIRECTION_DOWN) {
      return;
    }
    movePageCardsUp();
  }
});

fjLayout_Hammer.on('swipedown', function (ev) {
  // if page cards aren't calculated
  if(!pageCalc) {
    calculateCardValues();
  }
  // open menu can't go any furthur down
  if(isMenuOpen) {
    return;
  }
  // if the page is the first one then open the menu and also if it is closed
  if(page_scroll === 0) {
    menuOpen();
  } else {
    if(page_scrollDir === Hammer.DIRECTION_UP) {
      return;
    }
    // move the cards down and decrement the card count
    movePageCardsDown();
  }
});

// card mover helpers
// set full to true to do the full transition time
function movePageCardsUp(transitionTime) {
  // default value of transitionTime to .3
  var transitionTime = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : .2,
    i = page_cardCount;
  // set is moving to true
  isPageMoving = true;
  page_scrollVal = -(page_cardHeight * (page_scroll + 1));
  while(i--) {
    if(i > page_scroll) {
      setTranslate3dY(page_cards[i], page_scrollVal + 'px');
      setTransition(page_cards[i], transitionTime + stdEasing);
    }
  }
  // for first page card only
  setTransform(page_cards[page_scroll], 'translate3d(0, ' + getComputedTranslateY(page_cards[page_scroll]) + 'px, 0) scale(.9)');
  page_cards[page_scroll].style.opacity = 0;
  setTransition(page_cards[page_scroll], transitionTime + stdEasing);
  // unset the transition
  window.setTimeout(function () {
    multiCall(setTransition, page_cards, '');
    isPageMoving = false;
  }, transitionTime * 1000);
  // increment page scroll
  page_scroll++;
}

// set full to true to do the full transition time
function movePageCardsDown(transitionTime) {
  // default value of transitionTime to .3
  var transitionTime = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : .2,
    i = page_cardCount;
  // set is moving to true
  isPageMoving = true;
  page_scrollVal = -page_cardHeight * (page_scroll - 1);
  while(i--) {
    if(i >= page_scroll) {
      setTranslate3dY(page_cards[i], page_scrollVal + 'px');
      setTransition(page_cards[i], transitionTime + stdEasing);
    }
  }
  // for first page card only
  setTransform(page_cards[page_scroll - 1], 'translate3d(0, ' + page_scrollVal + 'px, 0)');
  page_cards[page_scroll - 1].style.opacity = 1;
  setTransition(page_cards[page_scroll - 1], transitionTime + stdEasing);
  // unset the transition
  window.setTimeout(function () {
    multiCall(setTransition, page_cards, '');
    isPageMoving = false;
  }, transitionTime * 1000);
  // decrement page scroll
  page_scroll--;
}

// pan scroll
// increase the card scroll number
fjLayout_Hammer.on('panend pancancel', function (ev) {
  // if page cards aren't calculated
  if(!pageCalc) {
    calculateCardValues();
  }
  var i = page_cardCount,
    checkRatio, transitionTime;
  if(page_scroll >= 0 && !isPageMoving) {
    // handle moving up direction also if the last movable card hasn't been reached
    if(page_scrollDir === Hammer.DIRECTION_UP && !isPageMoving && ((page_scroll + page_viewPortCards) < page_cardCount || isMenuOpen)) {
      // if menu is open
      if(isMenuOpen) {
        // calculate and send the menu to it's place according to the threshold value
        var completeRatio = page_scrollVal / page_topHeight;
        transitionTime = (1 - completeRatio) * .3;
        if(completeRatio < scrollThreshold) {
          // close the menu
          menuClose(transitionTime);
        } else {
          //
          isPageMoving = true;
          // keep the menu open
          setTranslate3dY(main, 'calc(100% - 50px)');
          setTransition(main, transitionTime + outEasing);
          // for # of viewport fixed items
          var i = page_viewPortCards;
          while(i--) {
            if(i > 0) {
              setTranslate3dY(page_cards[i], 'calc(' + (page_cardPeek * i) + 'px - ' + (100 * i) + '%)');
              setTransition(page_cards[i], transitionTime + outEasing);
            }
          }
          // reset scroll and other values
          page_scrollVal = 0;
          window.setTimeout(function () {
            setTransition(main, '');
            multiCall(setTransition, page_cards, '');
            isPageMoving = false;
          }, transitionTime * 1000);
        }
      } else {
        // set the card according to threshold
        // if the card has surpassed the threshold then move the card up
        checkRatio = Math.abs((page_scrollVal + (page_cardHeight * page_scroll)) / page_cardHeight);
        transitionTime = checkRatio * .2;
        if(checkRatio >= scrollThreshold) {
          movePageCardsUp(.2 - transitionTime);
        }
        // else move it back
        else {
          // set is moving to true
          isPageMoving = true;
          page_scrollVal = -page_cardHeight * page_scroll;
          while(i--) {
            if(i > page_scroll) {
              setTranslate3dY(page_cards[i], page_scrollVal + 'px');
              setTransition(page_cards[i], transitionTime + inEasing);
            }
          }
          // just the first card
          setTransform(page_cards[page_scroll], 'translate3d(0, ' + getComputedTranslateY(page_cards[page_scroll]) + 'px, 0) scale(1)');
          page_cards[page_scroll].style.opacity = 1;
          setTransition(page_cards[page_scroll], transitionTime + inEasing);
          // unset the transition
          window.setTimeout(function () {
            multiCall(setTransition, page_cards, '');
            isPageMoving = false;
          }, transitionTime * 1000);
        }
      }
    }
    //  handle moving down direction
    else if(page_scrollDir === Hammer.DIRECTION_DOWN && !isMenuOpen) {
      // check if the first card is the top one then check for menu threshold
      if(page_scroll === 0) {
        var checkRatio = page_scrollVal / page_topHeight;
        transitionTime = (1 - checkRatio) * .3;
        // if the items have crossed the threshold then pull up the menu
        if(checkRatio >= scrollThreshold) {
          // multiCall(setTransform, page_cards, '');
          // open the menu
          menuOpen(transitionTime);
        }
        // keep the menu close and move the items back to their pos
        else {
          // set to moving
          isPageMoving = true;
          page_scrollVal = 0;
          setTranslate3dY(main, 0);
          multiCall(setTranslate3dY, page_cards, 0);
          setTransition(main, transitionTime + inEasing);
          multiCall(setTransition, page_cards, transitionTime + inEasing);
          // reset scroll and other values
          window.setTimeout(function () {
            setTransition(main, '');
            multiCall(setTransition, page_cards, '');
            isPageMoving = false;
          }, transitionTime * 1000);
        }
      } else {
        checkRatio = (page_scrollVal + (page_cardHeight * page_scroll)) / page_cardHeight;
        transitionTime = checkRatio * .2;
        // if the card has passed below the threshold move the cards down to previous card
        if(checkRatio >= scrollThreshold) {
          movePageCardsDown(.2 - transitionTime);
        }
        // reset the cards back
        else {
          // set page moving to true
          isPageMoving = true;
          page_scrollVal = -page_scroll * page_cardHeight;
          while(i--) {
            if(i >= page_scroll) {
              setTranslate3dY(page_cards[i], page_scrollVal + 'px');
              setTransition(page_cards[i], transitionTime + inEasing);
            }
          }
          // reset back the top card
          page_cards[page_scroll - 1].style.opacity = 0;
          setTransition(page_cards[page_scroll - 1], transitionTime + inEasing);
          // wait and reset
          window.setTimeout(function () {
            multiCall(setTransition, page_cards, '');
            isPageMoving = false;
          }, transitionTime * 1000);
        }
      }
    }
  }
  // reset the pan direction
  page_scrollDir = Hammer.DIRECTION_NONE;
});

fjLayout_Hammer.on('panup', function (ev) {
  // if page cards aren't calculated
  if(!pageCalc) {
    calculateCardValues();
    return;
  }
  // return back if menu is toggling or some pan action is already going on
  if(page_scrollDir === Hammer.DIRECTION_DOWN || isPageMoving || ((page_scroll + page_viewPortCards) >= page_cardCount && !isMenuOpen)) {
    return;
  }
  // initial calculations
  var i = page_cardCount,
    cardMaxPos, cardRatio;
  // for base page
  // calculate ...
  cardMaxPos = page_cardHeight * (page_scroll + 1);
  // if the last most item has been reached it can't pan up
  // if the menu is open then it can't pan down
  if(isMenuOpen) {
    // go up only until you reach the 50px from bottom point
    if(page_scrollVal >= 0) {
      i = page_viewPortCards;
      page_scrollVal = getComputedTranslateY(main) + (ev.velocityY * getScrollVelocityFactor());
      setTranslate3dY(main, page_scrollVal + 'px');
      while(i--) {
        if(i > 0) {
          setTranslate3dY(page_cards[i], (1 - ((getComputedTranslateY(main) / page_topHeight) * i * page_cardHeight)) + 'px');
        }
      }
    }
  }
  // if it exceeds the card's height increment the page_scroll value and set the cards perfectly
  else if(Math.abs(page_scrollVal) >= cardMaxPos) {
    // set page top card's values correctly
    page_cards[page_scroll].style.opacity = 0;
    setTranslate3dY(page_cards[page_scroll + 1], -cardMaxPos + 'px');
    page_scroll++;
  }
  // normal transition
  else {
    // update the scrollVal from one card after the current page scroll
    page_scrollVal = getComputedTranslateY(page_cards[page_scroll + 1]) + (ev.velocityY * getScrollVelocityFactor());
    cardRatio = (Math.abs(page_scrollVal) - (page_cardHeight * page_scroll)) / page_cardHeight;
    // normalize for us
    cardRatio = 1 - cardRatio;
    // update the transform value of the top card
    setTransform(page_cards[page_scroll], 'translate3d(0, ' + getComputedTranslateY(page_cards[page_scroll]) + 'px, 0) scale(' + (.9 + (cardRatio * .1)) + ')');
    page_cards[page_scroll].style.opacity = .5 * (1 + cardRatio);
    // update and transition
    while(i--) {
      if(i > page_scroll) {
        setTranslate3dY(page_cards[i], page_scrollVal + 'px');
      }
    }
  }

  // change the pan direction
  page_scrollDir = ev.direction;
});

fjLayout_Hammer.on('pandown', function (ev) {
  // if page cards aren't calculated
  if(!pageCalc) {
    calculateCardValues();
    return;
  }
  // return back if menu is toggling or some pan action is already going on
  if(page_scrollDir === Hammer.DIRECTION_UP || isPageMoving || isMenuOpen) {
    return;
  }
  // initial calculations
  var i = page_cardCount,
    cardMaxPos, cardRatio;
  // calculate ...
  cardMaxPos = page_cardHeight * (page_scroll - 1);
  // if it is the topmost card, start opening the menu
  if(page_scroll === 0) {
    if(page_scrollVal <= page_topHeight) {
      page_scrollVal = getComputedTranslateY(main) + (ev.velocityY * getScrollVelocityFactor());
      setTranslate3dY(main, page_scrollVal + 'px');
      while(i--) {
        if(i > 0) {
          setTranslate3dY(page_cards[i], (((getComputedTranslateY(main) / page_topHeight) * -i * page_cardHeight) + (page_cardPeek * i)) + 'px');
        }
      }
    }
  }
  // other transition for cards
  else {
    // if it exceeds the card's height decrement the page_scroll value and set the cards perfectly
    if(Math.abs(page_scrollVal) <= cardMaxPos || page_scrollVal >= 0) {
      // set the values for the page top card correctly
      page_cards[page_scroll - 1].style.opacity = 1;
      // set the cards to correct places #pixelperfect :D
      while(i--) {
        if(i >= page_scroll) {
          setTranslate3dY(page_cards[i], -cardMaxPos + 'px');
        }
      }
      // decrement the page scroll
      page_scroll--;
    }
    // normally move the card down
    else {
      cardRatio = Math.abs((Math.abs(page_scrollVal) - (page_cardHeight * page_scroll)) / page_cardHeight);
      // update the transform value of the top card
      setTransform(page_cards[page_scroll - 1], 'translate3d(0, ' + getComputedTranslateY(page_cards[page_scroll - 1]) + 'px, 0) scale(' + (.9 + (cardRatio * .1)) + ')');
      page_cards[page_scroll - 1].style.opacity = .5 * (1 + cardRatio);
      while(i--) {
        if(i >= page_scroll) {
          page_scrollVal = getComputedTranslateY(page_cards[i]) + (ev.velocityY * getScrollVelocityFactor());
          // transform acc to browser
          setTranslate3dY(page_cards[i], page_scrollVal + 'px');
        }
      }
    }
  }
  // change the pan direction
  page_scrollDir = ev.direction;
});