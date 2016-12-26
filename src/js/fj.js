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
  fjHomeButton = document.getElementById('fj-home-button'),
  fjInnerContent = document.getElementById('fj-inner-content'),
  fjLayout = document.getElementById('fj-layout'),
  fjContentLoading = document.getElementById('fj-content-loading'),
  fjLoaderCircular = document.getElementById('fj-loader-circular'),
  fjRetryLoader = document.getElementById('fj-retry-loader'),
  fjFloatContainer = document.getElementById('fj-float-container'),
  fjAnimationContainer = document.getElementById('fj-animation-container'),
  header = document.getElementById('fj-main-header'),
  fjHeaderTitle = document.getElementById('fj-header-title'),
  fjHeaderLogo = document.getElementById('fj-header-logo'),
  fjCoverHeader = document.getElementById('fj-cover-header'),
  fjCoverProgress = document.getElementById('fj-cover-progress'),
  svgicon = new svgIcon(menuButton, svgIconConfig, {
    easing: mina.easeOutExpo
  }),
  redirect = false,
  isIconMenuOpen = false,
  isMenuOpen = false,
  ifNoAnimation = false,
  // base api url
  // TODO replace it with https for better results
  base_url = '//feeljoy.in/apis/topics/',
  // base_url = 'partials/api/',
  // id is also the base route
  fjLayout_Hammer = new Hammer.Manager(fjLayout, {}),
  fj_diversion_Hammer = new Hammer(fjDiversionButton),
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
  // 0 : scroll
  // 1 : card swiper
  page_type = 0,
  relationship_cardLast = 0,
  relationship_cardCount = 0,
  relationship_cards = [],
  isSwiping = false,
  scrollThreshold = 0.5,
  stdEasing = 's cubic-bezier(.4, 0, .2, 1)',
  outEasing = 's cubic-bezier(.4, 0, 1, 1)',
  inEasing = 's cubic-bezier(0, 0, .2, 1)',
  pageHash = [],
  timeouts = {
    menuClose: '',
    menuClose1: '',
    menuOpen: '',
    menuOpen1: '',
    menuOpen2: '',
    showFjLoader: '',
    loadSwipeableCards: '',
  },
  pages = {
    firstclick: '',
    secondclick: [],
    thirdclick: []
  },
  // routes logic setup crossroads
  mainRouter = crossroads.addRoute('{base}/:section:/:cardno:'),
  // configuring hammer options
  fjLayoutTap = new Hammer.Tap(),
  fjLayoutPan = new Hammer.Pan({
    direction: Hammer.DIRECTION_ALL
  }),
  fjLayoutSwipe = new Hammer.Swipe({
    direction: Hammer.DIRECTION_ALL
  });

// adding recognisers for both
fjLayout_Hammer.add([fjLayoutSwipe, fjLayoutPan, fjLayoutTap]);
fjLayoutSwipe.recognizeWith(fjLayoutPan);

// open close menu function
function menuToggle() {
  if(isMenuOpen) {
    menuClose();
  } else {
    menuOpen();
  }
}

// helper extract values into an array from an array with objects
function getArrayFromObject(objArr, key) {
  var i = objArr.length,
    arr = [];
  while(i--) {
    arr.push(objArr[i][key]);
  }
  return arr;
}

// get other val from an object using other val's key
function getOtherVal(objArr, other, key, find) {
  var i = objArr.length,
    val;
  while(i--) {
    if(objArr[i][other] === key) {
      val = objArr[i][find];
      break;
    }
  }
  return val;
}

function getOtherInnerVal(objArr, innerSearchKey, innerSecondKey, other, key) {
  var i = objArr.length,
    val;
  while(i--) {
    if(objArr[i][innerSearchKey][0][other] === key) {
      val = objArr[i][innerSecondKey];
      break;
    }
  }
  return val;
}

function getOtherValId(objArr, other, key) {
  var i = objArr.length,
    val = -1;
  while(i--) {
    if(objArr[i][other] === key) {
      val = i;
      break;
    }
  }
  return val;
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
  if(page_type === 0) {
    // for # of viewport fixed items
    var i = page_viewPortCards;
    while(i--) {
      if(i > 0) {
        rafCall(setTransform, page_cards[i], '');
        setTransition(page_cards[i], time + inEasing);
      }
    }
  }
  // clear any previous timeouts
  window.clearTimeout(timeouts.menuClose);
  window.clearTimeout(timeouts.menuClose1);
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

  // after a delay do fab out animation
  timeouts.menuClose1 = window.setTimeout(function () {
    fjFloatContainer.classList.remove('is-invisible');
    doClasses(fjDiversionButton, ['zoomIn', 'zoomOut'], true);
    doClasses(fjDiversionButton, ['zoomIn']);
  }, transitionTime + 300);

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
  if(page_type === 0) {
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
  }
  // clear any previous timeouts
  window.clearTimeout(timeouts.menuOpen);
  window.clearTimeout(timeouts.menuOpen1);
  window.clearTimeout(timeouts.menuOpen2);
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

  // after a delay do fab out animation
  timeouts.menuOpen1 = window.setTimeout(function () {
    doClasses(fjDiversionButton, ['zoomIn', 'zoomOut'], true);
    doClasses(fjDiversionButton, ['zoomOut']);
  }, transitionTime + 300);

  timeouts.menuOpen2 = window.setTimeout(function () {
    fjFloatContainer.classList.add('is-invisible');
  }, transitionTime + 600);
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

function loadFirstClick() {
  makeRequest(base_url + 'firstclick')
    .then(function (data) {
      var passHash = [];
      // put this data in the first click pages
      pushFirstClickData(data);
      if(redirect) {
        toValidPath();
        passHash = [pages.firstclick[0]._url];
        ifNoAnimation = true;
      }
      doPageStuff(passHash);
      // load secondclicks for base pages
      i = pages.firstclick.length;
      while(i--) {
        loadBasePage(pages.firstclick[i].id, pages.firstclick[i]._url, passHash);
      }
    })
    .catch(function (err) {
      // TODO We reached our target server, but it returned an error so retry the last request
      showErrorButton('firstclick');
      console.error(err);
    });
}

// push second clicks into array
function pushFirstClickData(data) {
  pages.firstclick = JSON.parse(data);
  // also add url and id fields
  var i = pages.firstclick.length;
  while(i--) {
    pages.firstclick[i]._url = nameToUrl(pages.firstclick[i].name);
    pages.firstclick[i]._id = 'fj_' + nameToUrl(pages.firstclick[i].name)
      .replace(/\-/g, '_') + '_button';
  }
}

// push second / third clicks into array
function pushClickData(type, dataType, data) {
  var i = data[dataType].length,
    secondType = 'name';
  data.category[0]._url = nameToUrl(data.category[0].name);
  data.category[0]._id = 'fj_' + nameToUrl(data.category[0].name)
    .replace(/\-/g, '_') + '_button';
  // process data type
  if(dataType === 'questions') {
    secondType = 'question';
  }
  while(i--) {
    data[dataType][i]._url = nameToUrl(data[dataType][i][secondType]);
    data[dataType][i]._id = nameToUrl(data[dataType][i][secondType])
      .replace(/\-/g, '_');
  }
  pages[type + 'click'].push(data);
}

function loadThirdClick() {
  makeRequest(base_url + 'firstclick')
    .then(function (data) {
      // put this data in the first click pages
      pushFirstClickData(data);
      doPageStuff([]);
      // load secondclicks which are not required forward
      var i = 0,
        modifiedArr = pages.firstclick.filter(isNotCurrent),
        rest;
      // filter and keep everything but the current page
      function isNotCurrent(value) {
        if(pageHash[0] !== value._url) {
          return true;
        }
        // put the remaning one in rest
        rest = value;
        return false;
      }
      i = modifiedArr.length;
      // pass the rest to sim loaders
      while(i--) {
        loadBasePage(modifiedArr[i].id, modifiedArr[i]._url, ['']);
      }
      return makeRequest(base_url + 'secondclick/' + rest.id);
    })
    .then(function (data) {
      data = JSON.parse(data);
      // push it into second click
      pushClickData('second', 'topics', data);
      loadSecondOrThirdClick(hasher.getHashAsArray(), true);
    })
    .catch(function (err) {
      // TODO We reached our target server, but it returned an error so retry the last request
      showErrorButton('firstclick');
      console.error(err);
    });
}

function loadBasePage(pageid, pageurl, passHash) {
  makeRequest(base_url + 'secondclick/' + pageid)
    .then(function (data) {
      // push them into secondclick
      data = JSON.parse(data);
      pushClickData('second', 'topics', data);
      // parse hash from hasher
      passHash = (passHash.length > 0) ? passHash : hasher.getHashAsArray();
      if(passHash[0] === pageurl) {
        pageHash = passHash;
        initCardPage(passHash[0], true, data.topics, false, true);
      }
    })
    .catch(function (err) {
      // TODO We reached our target server, but it returned an error so retry the last request
      showErrorButton(pageid);
      console.error(err);
    });
}

// only for the base first page
function initCardPage(hash, isBasePage, data, ifClose, openMenu) {
  // turn off the loader icon
  hideFjLoader(true);
  var i, j, colorClass;
  // remove the other items
  clearInner(fjInnerContent);
  // hide it before showing it
  if(!ifNoAnimation) {
    fjInnerContent.classList.add('is-hidden');
  }
  // add content to it
  var frag = document.createDocumentFragment();
  for(i = 0; i < data.length; i++) {
    // anchor tag button
    var button = document.createElement('div'),
      text = document.createElement('h6');
    if(isBasePage) {
      colorClass = page_colors[i % 4];
    } else {
      colorClass = 'white';
    }
    doClasses(button, ['fj-card-figure', 'mdl-shadow--2dp', colorClass]);
    // if name exists else question
    if(data[i].hasOwnProperty('name')) {
      text.innerHTML = data[i].name;
    } else {
      text.innerHTML = data[i].question;
    }
    button.setAttribute('data-link', hash + '/' + data[i]._url);
    button.appendChild(text);
    frag.appendChild(button);
  }
  // add frag to doc
  fjInnerContent.appendChild(frag);
  // remove hidden class after 600ms
  window.setTimeout(function () {
    if(isBasePage) {
      // turn off the loader page after 300ms
      hideFjLoader(true);
    }
    fjInnerContent.classList.remove('is-hidden');
    if(ifClose) {
      menuClose();
      doPageStuff([hash]);
    } else if(!ifNoAnimation) {
      doClasses(main, ['animate', 'slideInUp']);
    } else if(openMenu) {
      menuOpen();
    }
    // remove animated classes after animations are over
    window.setTimeout(function () {
      if(!ifNoAnimation) {
        doClasses(main, ['animate', 'slideInUp', 'slideOutDown'], true);
      } else {
        ifNoAnimation = false;
      }
      // reset calculations
      pageCalc = false;
      // set page to scroll mode and reset values
      page_type = 0;
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
  pageHash = (passHash.length > 0) ? passHash : hasher.getHashAsArray();
  // if the first click is not loaded
  if(!page_menuAdded) {
    var frag = document.createDocumentFragment();
    for(var i in pages.firstclick) {
      // anchor tag button
      var button = document.createElement('button');
      doClasses(button, ['mdl-button', 'mdl-js-button', 'mdl-js-ripple-effect', 'fj-menu-button']);
      button.innerHTML = pages.firstclick[i].name;
      button.id = pages.firstclick[i]._id;
      button.setAttribute('data-link', pages.firstclick[i]._url);
      frag.appendChild(button);
    }
    // add frag to doc
    fjFloatMenu.appendChild(frag);
    // toggle menu added to true
    page_menuAdded = true;
    // upgrade mdl
    componentHandler.upgradeDom();
  }
  // set menu button hash
  highlightMenuButton(pageHash[0]);
  // hide the inner content page and remove other unnecessary classes
  fjRetryLoader.classList.add('is-hidden');
  doClasses(fjInnerContent, ['animate', 'slideInUp', 'slideOutDown'].concat(page_colors), true);
  // set page title
  upPageTitle(getOtherVal(pages.firstclick, '_url', pageHash[0], 'name'));
}

// navigation to a valid path
function toValidPath() {
  location.replace('#/' + pages.firstclick[0]._url);
}

// animate to base page from another page
function animateToBase(from, to) {
  // from and to are hashes for from and to elements
  var colorClass = document.body.className,
    cardHeight = main.offsetHeight / 4,
    scaleSize = window.innerHeight / cardHeight,
    cardTop = 0,
    cardNegativeTop = 0,
    findPos = -1,
    title = '';
  // first fade out the content
  doClasses(fjInnerContent, ['animate', 'slideOutDown']);
  // if the to page is a base page then
  if(to.length === 1) {
    findPos = getOtherInnerVal(pages.secondclick, 'category', 'topics', '_url', to[0]);
    findPos = getOtherValId(findPos, '_url', from[from.length - 1]);
    title = getOtherVal(pages.firstclick, '_url', to[0], 'name');
    // if the position is directly mappable, also we dont want a wrong match
    if(from.length < 3 && from[0] === to[0]) {
      cardTop = header.offsetHeight + (cardHeight * (findPos % 4));
      cardNegativeTop = -cardTop / scaleSize;
      fjAnimationContainer.style.opacity = 1;
      fjAnimationContainer.style.height = cardHeight + 'px';
      fjAnimationContainer.style.width = main.offsetWidth + 'px';
      doClasses(fjAnimationContainer, page_colors, true);
      fjAnimationContainer.classList.add(colorClass);
      fjAnimationContainer.style.top = cardTop + 'px';
      setTransform(fjAnimationContainer, 'scale(1, ' + scaleSize + ') translate3d(0,' + cardNegativeTop + 'px, 0)');
      window.setTimeout(function () {
        // remove the toolbar
        setDestToolbarProps(true, title);
        ifNoAnimation = true;
        doClasses(fjInnerContent, ['animate', 'slideInUp', 'slideOutDown'], true);
        initCardPage(to[0], true, getOtherInnerVal(pages.secondclick, 'category', 'topics', '_url', to[0]));
      }, 400);
      window.setTimeout(function () {
        rafCall(setTransform, fjAnimationContainer, '');
        setTransition(fjAnimationContainer, .4 + stdEasing);
      }, 460);
      // slowly fadeout the overlay
      window.setTimeout(function () {
        setTransition(fjAnimationContainer, .2 + stdEasing);
        fjAnimationContainer.style.opacity = 0;
      }, 860);
      // clear up the animation container
      window.setTimeout(function () {
        setTransform(fjAnimationContainer, '');
        setTransition(fjAnimationContainer, '');
        fjAnimationContainer.style.width = 0;
        fjAnimationContainer.style.height = 0;
      }, 1060);
    } else {
      window.setTimeout(function () {
        // remove the toolbar
        setDestToolbarProps(true, title);
      }, 400);
      window.setTimeout(function () {
        doClasses(fjInnerContent, ['animate', 'slideInUp', 'slideOutDown'], true);
        initCardPage(to[0], true, getOtherInnerVal(pages.secondclick, 'category', 'topics', '_url', to[0]));
      }, 700);
    }
    window.setTimeout(function () {
      doClasses(fjFloatContainer, page_colors, true);
    }, 1400);
  }
}

// animate from base page to another page, also load stuff to dom with this
function animateFromBase(from, title, cardArr, thirdclick, to, isFresh) {
  // get the from element in the page by it's location as element
  // map 1 ... n to 1 ... 4
  var colorClass = page_colors[(from % 4)],
    cards = false,
    cardHeight = main.offsetHeight / 4,
    scaleSize = window.innerHeight / cardHeight,
    page_level = to.length,
    colorCopy,
    cardTop = header.offsetHeight + (cardHeight * (from - page_scroll)),
    cardNegativeTop = -cardTop / scaleSize;
  // if input has questions or not
  if(cardArr.hasOwnProperty('questions')) {
    cardArr = cardArr.questions;
  }
  // check if cards need to be rendered or scrolled
  if((thirdclick && page_level === 3) || (!thirdclick && page_level === 2)) {
    cardArr = getOtherVal(cardArr, '_url', to[page_level - 1], 'answer');
    cardArr = dotSplit(cardArr);
    cards = true;
  }
  // if not a fresh click then do these
  if(!isFresh) {
    fjAnimationContainer.style.opacity = 1;
    fjAnimationContainer.style.height = cardHeight + 'px';
    fjAnimationContainer.style.width = main.offsetWidth + 'px';
    doClasses(fjAnimationContainer, page_colors, true);
    fjAnimationContainer.classList.add(colorClass);
    fjAnimationContainer.style.top = cardTop + 'px';
    // set off animation after a 30ms window
    window.setTimeout(function () {
      rafCall(setTransform, fjAnimationContainer, 'scale(1, ' + scaleSize + ') translate3d(0,' + cardNegativeTop + 'px, 0)');
      // if not cards change color to white
      setTransition(fjAnimationContainer, .4 + stdEasing);
    }, 30);
  }
  // load the toolbar also set the fab and background-color
  window.setTimeout(function () {
    // reset class then add
    doClasses(fjFloatContainer, page_colors, true);
    // if not card change the fab color
    if(cards) {
      // set a random color other then the colorClass
      colorCopy = true_colors.slice(0);
      colorCopy.splice(colorCopy.indexOf(colorClass), 1);
      setDestToolbarProps(false, title, colorClass);
      colorClass = colorCopy[Math.floor(Math.random() * colorCopy.length)];
      fjFloatContainer.classList.add(colorClass);
    } else {
      fjFloatContainer.classList.add(colorClass);
      setDestToolbarProps(true, title, colorClass);
    }
    // slowly fadeout the overlay
    setTransition(fjAnimationContainer, .2 + stdEasing);
    fjAnimationContainer.style.opacity = 0;
    // remove the other items
    clearInner(fjInnerContent);
  }, 460);
  // clear up the animation container
  window.setTimeout(function () {
    setTransform(fjAnimationContainer, '');
    setTransition(fjAnimationContainer, '');
    fjAnimationContainer.style.width = 0;
    fjAnimationContainer.style.height = 0;
  }, 660);
  window.setTimeout(function () {
    if(cards) {
      // call card loading from here
      initCardSwiper(cardArr);
    } else {
      // force animation from bottom
      ifNoAnimation = false;
      initCardPage(to.join('/'), false, cardArr, false);
    }
  }, 720);
}

// dot split returns the split value using dot but without empty values
function dotSplit(value) {
  value = value.split('.');
  // check if last value is empty or not
  if(!value[value.length - 1].trim()) {
    value.pop();
  }
  return value;
}

// load a second click page and animate it
function loadSecondOrThirdClick(to, isFresh) {
  // check if the page is in the storage or not
  var thirdClickPage = getOtherInnerVal(pages.thirdclick, 'category', 'questions', '_url', to[1]),
    pageid = getOtherInnerVal(pages.secondclick, 'category', 'topics', '_url', to[0]),
    title = getOtherVal(pageid, '_url', to[1], 'name'),
    from = getOtherValId(pageid, '_url', to[1]);
  // if page is a thirdclick level page then pass that as well
  if(thirdClickPage) {
    // check if thirdclick flag is present and pass it
    var thirdclick = !!parseInt(getOtherInnerVal(pages.thirdclick, 'category', 'category', '_url', to[1])[0].thirdclick);
    // currently splitting an answer using .
    animateFromBase(from, title, thirdClickPage, thirdclick, to, isFresh);
  } else {
    // load it from api
    pageid = getOtherVal(pageid, '_url', to[1], 'id');
    makeRequest(base_url + 'thirdclick/' + pageid)
      .then(function (data) {
        // push them into thirdclick
        data = JSON.parse(data);
        pushClickData('third', 'questions', data);
        var thirdclick = !!parseInt(getOtherInnerVal(pages.thirdclick, 'category', 'category', '_url', to[1])[0].thirdclick);
        // currently splitting an answer using .
        animateFromBase(from, title, data, thirdclick, to, isFresh);
      })
      .catch(function (err) {
        // TODO We reached our target server, but it returned an error so retry the last request
        showErrorButton(pageid);
        console.error(err);
      });
  }
}

// update page title
function upPageTitle(title) {
  // change the document's title to match the new one for bookmark friendly-ness
  // http://stackoverflow.com/questions/413439/how-to-dynamically-change-a-web-pages-title
  document.title = 'Feeljoy' + (title ? ' - ' + title : '');
  fjHeaderTitle.innerHTML = title;
}


//setup hasher
function parseHash(newHash, oldHash) {
  // don't parse empty hash
  crossroads.parse(newHash);
  // parse hash from hasher
  pageHash = hasher.getHashAsArray();
  // reset page calculate
  pageCalc = false;
  // on menu main target history changed
  if(!pageHash[0]) {
    // to redirect to valid url
    redirect = true;
    loadFirstClick();
  } else if(oldHash) {
    // if both are base pages
    if(oldHash.indexOf('/') === -1 && pageHash.length === 1) {
      initCardPage(pageHash[0], true, getOtherInnerVal(pages.secondclick, 'category', 'topics', '_url', pageHash[0]), true);
    } else {
      var oldHashArr = oldHash.split('/');
      // if the old page is a base page then animate from it to anywhere
      if(pageHash.length > 1) {
        loadSecondOrThirdClick(pageHash);
      }
      // if the new page is a base page then animate to the base page
      else if(oldHashArr.length > 1 && pageHash.length === 1) {
        animateToBase(oldHashArr, pageHash);
      }
    }
  } else {
    // if first page then do the default loadout
    if(!redirect) {
      if(pageHash.length === 1) {
        loadFirstClick();
      } else {
        loadThirdClick();
      }
    } else {
      redirect = false;
    }
  }
}

hasher.initialized.add(parseHash); //parse initial hash
hasher.changed.add(parseHash); //parse hash changes
hasher.init(); //start listening for history change

// calculate destination toolbar props
function setDestToolbarProps(close, title, colorClass) {
  // if close means it needs to first remove all previous classes
  if(close) {
    header.classList.remove('is-hidden');
  } else {
    fjCoverHeader.style.height = header.offsetHeight + 'px';
    // now hide the main header
    header.classList.add('is-hidden');
  }
  // to add a color class or not
  if(colorClass) {
    document.body.classList.add(colorClass);
    header.classList.add(colorClass);
  } else {
    doClasses(document.body, page_colors, true);
    doClasses(header, page_colors, true);
  }
  // header title as well as doc title
  upPageTitle(title);
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

function initCardSwiper(cardArr) {
  // turn off the loader icon
  hideFjLoader(true);
  // reset card swiper data
  relationship_cardLast = 0;
  relationship_cardCount = cardArr.length;
  relationship_cards = cardArr;
  // load cardArr which is an array in the cards and make them
  var cardFrag = document.createDocumentFragment(),
    i = 0;
  for(i in cardArr) {
    if(i <= 2) {
      // add transform and transition if they are lower cards
      if(i > 0) {
        addSwiperCard(cardFrag, i, i, true);
      } else {
        addSwiperCard(cardFrag, i, i);
      }
      relationship_cardLast++;
    } else {
      break;
    }
  }
  //add them to inner
  fjInnerContent.appendChild(cardFrag);
  // update calculations
  calculateCardValues();
  // truncate the cards
  var i = page_cardCount,
    cardHeight = window.innerHeight - fjCoverHeader.offsetHeight - fjDiversionButton.offsetWidth - 91;
  while(i--) {
    // truncate the card
    shave(page_cards[i].querySelector('div'), cardHeight);
  }
  // remove hidden from the inner element
  fjInnerContent.classList.remove('is-hidden');
  // reset card bar
  updateCoverProgress();
  // reset calculations
  pageCalc = false;
  // set page type to cards
  page_type = 1;
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
  if(menuButton.contains(ev.target) && page_type === 0) {
    menuToggle();
    return;
  }

  // tap home button to go to the default route which is currently the home page also
  if(fjHomeButton.contains(ev.target) && page_type === 1) {
    hasher.setHash(mainRouter.interpolate({
      base: pages.firstclick[0]._url
    }));
    return;
  }

  if(fjRetryLoader.contains(ev.target)) {
    location.reload();
    return;
  }

  // if on any of the floating menu button
  innerCards = fjFloatMenu.querySelectorAll('.fj-menu-button'),
    i = innerCards.length;
  while(i--) {
    // menu must be opened to do this
    if(innerCards[i].contains(ev.target) && isMenuOpen) {
      hasher.setHash(mainRouter.interpolate({
        base: innerCards[i].getAttribute('data-link')
      }));
      return;
    }
  }

  // if inside tappable card angry, anxious etc. on a card page
  if(page_type === 0) {
    innerCards = fjInnerContent.querySelectorAll('.fj-card-figure');
    i = innerCards.length;
    while(i--) {
      // also the menu must not be open
      if(innerCards[i].contains(ev.target) && !isMenuOpen && innerCards[i].getAttribute('data-link')) {
        hasher.setHash(innerCards[i].getAttribute('data-link'));
        return;
      }
    }
  }

  // click anywhere to close
  if(isIconMenuOpen) {
    fjFloatContainer.classList.add('is-hidden');
    fjLayout.classList.remove('is-overlay');
    fjLayout_Hammer.get('pan')
      .set({
        enable: true
      });
    fjLayout_Hammer.get('swipe')
      .set({
        enable: true
      });
    // toggle it's state
    isIconMenuOpen = !isIconMenuOpen;
    return;
  }
});

// fab button tap events
fj_diversion_Hammer.on('tap', function (ev) {
  if(isIconMenuOpen) {
    fjFloatContainer.classList.add('is-hidden');
    fjLayout.classList.remove('is-overlay');
    fjLayout_Hammer.get('pan')
      .set({
        enable: true
      });
    fjLayout_Hammer.get('swipe')
      .set({
        enable: true
      });
  } else {
    fjFloatContainer.classList.remove('is-hidden');
    fjLayout.classList.add('is-overlay');
    fjLayout_Hammer.get('pan')
      .set({
        enable: false
      });
    fjLayout_Hammer.get('swipe')
      .set({
        enable: false
      });
  }
  // toggle it's state
  isIconMenuOpen = !isIconMenuOpen;
});

// push swiper card to top
function addPrevSwiperCard() {
  // check if loading a new card is possible or not
  if(relationship_cardLast > 3) {
    var div = document.createElement('div'),
      innerDiv = document.createElement('div'),
      calculatedWidth = window.innerWidth - 25,
      htmlCard = relationship_cardLast - 4;
    if(calculatedWidth > 560) {
      calculatedWidth = 560;
    }
    doClasses(div, ['mdl-card', 'mdl-shadow--2dp', 'fj-swipe-card']);
    // temp disable
    fjLayout_Hammer.get('pan')
      .set({
        enable: false
      });
    // decrement card last
    relationship_cardLast--;
    // update calculations
    calculateCardValues();
    if(htmlCard === relationship_cardCount) {
      htmlCard = relationship_cardCount - 1;
    }
    innerDiv.innerHTML = relationship_cards[htmlCard];
    setTransform(div, 'translate3d(0, -100%, 0)');
    setTransition(div, .2 + inEasing);
    // set div styles
    div.style.height = (window.innerHeight - fjCoverHeader.offsetHeight - fjDiversionButton.offsetWidth - 21) + 'px';
    div.style.width = calculatedWidth + 'px';
    div.style.right = ((window.innerWidth - calculatedWidth) / 2) + 'px';
    div.style.bottom = ((fjDiversionButton.offsetHeight / 2) + 21) + 'px';
    div.style.zIndex = 5;
    // remove the last element only if more than 3
    if(page_lastChild && page_cardCount > 2) {
      page_lastChild.parentNode.removeChild(page_lastChild);
    }
    // append it to the element
    div.appendChild(innerDiv);
    fjInnerContent.insertBefore(div, page_firstChild);
    // recalculate ...
    calculateCardValues();
    var i = page_cardCount;
    // update progress
    updateCoverProgress();
    // add transform reset to all else
    multiCall(setTransform, page_cards, '');
    // reanimate the rest
    // move other cards down
    while(i--) {
      if(i > 0) {
        setTransform(page_cards[i], 'scale(' + (1 - (i * 0.02)) + ') translate3d(0, ' + (i * 8) + 'px, 0)');
        setTransition(page_cards[i], .2 + outEasing);
        page_cards[i].style.zIndex = 4 - i;
      }
    }
    window.setTimeout(function () {
      // change z index of first el here
      page_firstChild.style.zIndex = 4;
      // reenable pan
      fjLayout_Hammer.get('pan')
        .set({
          enable: true
        });
      // remove transition from the first element
      setTransition(page_firstChild, '');
    }, 210);
  }
}

fjLayout_Hammer.on('swipeleft swiperight', function (ev) {
  // if page cards aren't calculated
  if(!pageCalc) {
    calculateCardValues();
  }
  if(page_type === 1 && pageHash.length > 1) {
    fjLayout_Hammer.get('pan')
      .set({
        enable: false
      });
    doSwiperCard(ev, true);
  }
});

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
  if(page_type === 0) {
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
  }
});

fjLayout_Hammer.on('swipedown', function (ev) {
  // if page cards aren't calculated
  if(!pageCalc) {
    calculateCardValues();
  }
  // if this is a base page
  if(page_type === 0) {
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
  } else {
    // get the previous card
    addPrevSwiperCard();
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
  // if this is a scroll page
  if(page_type === 0) {
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
  } else {
    //subroute(s)
    doSwiperCard(ev);
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
  if(page_type === 0) {
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
  } else {
    moveSwipeCard(ev.deltaX, ev.deltaY);
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
  // for base page
  if(page_type === 0) {
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
  } else {
    moveSwipeCard(ev.deltaX, ev.deltaY);
  }
  // change the pan direction
  page_scrollDir = ev.direction;
});

// reset card to it's rightful place
function doSwiperCard(ev, force) {
  var y = ev.deltaY,
    i;
  // send y if only it is greater than 0
  if(y > 0) {
    y = 0;
  }
  if(!page_firstChild || isSwiping) {
    return;
  }
  // set swiping state
  isSwiping = true;
  // disable it during operation
  fjLayout_Hammer.set({
    enable: false
  });
  // check if the deltaX exceeds the threshold
  // if so move the card out
  if((Math.abs(ev.deltaX / page_firstChild.offsetWidth) > scrollThreshold || force) && ((Math.abs((relationship_cardLast - 2) / relationship_cardCount) * 100) < 100)) {
    // add a transition to the card
    rafCall(setTransform, page_firstChild, 'translate3d(' + (Math.sign(ev.deltaX) * ((window.innerWidth / 2) + page_firstChild.offsetWidth)) + 'px,' + y + 'px,0) rotate(' + (Math.sign(ev.deltaX) * 75) + 'deg)');
    setTransition(page_firstChild, .2 + outEasing);
    addSwiperCard(fjInnerContent, relationship_cardLast++, page_cardCount, true);
    // update calculations
    calculateCardValues();
    // update progress
    updateCoverProgress();
    shave(page_lastChild.querySelector('div'), 300);
    // remove the transition
    window.setTimeout(function () {
      // remove element
      page_firstChild.parentNode.removeChild(page_firstChild);
      // redo page calculations
      calculateCardValues();
      i = page_cardCount;
      // move other cards up
      while(i--) {
        if(i > 0) {
          rafCall(setTransform, page_cards[i], 'scale(' + (1 - (i * 0.02)) + ') translate3d(0, ' + (i * 8) + 'px, 0)');
        } else {
          rafCall(setTransform, page_cards[i], '');
        }
        page_cards[i].style.zIndex = 4 - i;
      }
      // reset the el transition
      window.setTimeout(function () {
        if(page_firstChild) {
          setTransition(page_firstChild, '');
        }
        fjLayout_Hammer.set({
          enable: true
        });
        isSwiping = false;
        // renable pan after swipe wait
        if(force) {
          fjLayout_Hammer.get('pan')
            .set({
              enable: true
            });
        }
      }, 200);
    }, 200);
  } else {
    // pull the card back
    rafCall(setTransform, page_firstChild, 'translate3d(0,0,0) rotate(0)');
    // add a transition to the card
    setTransition(page_firstChild, .2 + inEasing);
    // remove the transition
    window.setTimeout(function () {
      setTransition(page_firstChild, '');
      fjLayout_Hammer.set({
        enable: true
      });
      isSwiping = false;
      // renable pan after swipe wait
      if(force) {
        fjLayout_Hammer.get('pan')
          .set({
            enable: true
          });
      }
    }, 200);
  }
}

// update swiper progress
function updateCoverProgress() {
  fjCoverProgress.MaterialProgress.setProgress(Math.abs((relationship_cardLast - 3) / (relationship_cardCount - 1)) * 100);
}

// add swiper card
function addSwiperCard(el, cur, anime, setTrans) {
  // check if loading a new card is possible or not
  if(relationship_cardLast < relationship_cardCount + 1) {
    var div = document.createElement('div'),
      innerDiv = document.createElement('div'),
      calculatedWidth = window.innerWidth - 25;
    if(calculatedWidth > 560) {
      calculatedWidth = 560;
    }
    doClasses(div, ['mdl-card', 'mdl-shadow--2dp', 'fj-swipe-card']);
    innerDiv.innerHTML = relationship_cards[cur];
    if(setTrans) {
      setTransform(div, 'scale(' + (1 - (anime * 0.02)) + ') translate3d(0, ' + (anime * 8) + 'px, 0)');
      setTransition(div, .2 + inEasing);
    }
    // set div styles
    div.style.height = (window.innerHeight - fjCoverHeader.offsetHeight - fjDiversionButton.offsetWidth - 21) + 'px';
    div.style.width = calculatedWidth + 'px';
    div.style.right = ((window.innerWidth - calculatedWidth) / 2) + 'px';
    div.style.bottom = ((fjDiversionButton.offsetHeight / 2) + 21) + 'px';
    div.style.zIndex = 4 - anime;
    // append it to the element
    div.appendChild(innerDiv);
    el.appendChild(div);
  }
}

// https://developer.mozilla.org/en-US/docs/Web/Events/resize
// recalculate cards
var optimizedResize = (function () {
  var callbacks = [],
    running = false;
  // fired on resize event
  function resize() {
    if(!running) {
      running = true;
      if(window.requestAnimationFrame) {
        window.requestAnimationFrame(runCallbacks);
      } else {
        window.setTimeout(runCallbacks, 66);
      }
    }
  }

  // run the actual callbacks
  function runCallbacks() {
    callbacks.forEach(function (callback) {
      callback();
    });
    running = false;
  }

  // adds callback to loop
  function addCallback(callback) {
    if(callback) {
      callbacks.push(callback);
    }
  }

  return {
    // public method to add additional callback
    add: function (callback) {
      if(!callbacks.length) {
        window.addEventListener('resize', resize);
      }
      addCallback(callback);
    }
  }
}());

// optimized window resize event
optimizedResize.add(function () {
  // if page cards aren't calculated
  if(!pageCalc) {
    calculateCardValues();
  }
  // if card swipe page and there are cards
  var i = page_cardCount,
    calculatedWidth = window.innerWidth - 25;
  // set page calc false
  pageCalc = false;
  if(calculatedWidth > 560) {
    calculatedWidth = 560;
  }
  if(page_type === 1 && i > 0) {
    fjCoverHeader.style.height = header.offsetHeight + 'px';
    while(i--) {
      page_cards[i].style.height = (window.innerHeight - fjCoverHeader.offsetHeight - fjDiversionButton.offsetWidth - 21) + 'px';
      page_cards[i].style.width = calculatedWidth + 'px';
      page_cards[i].style.right = ((window.innerWidth - calculatedWidth) / 2) + 'px';
      page_cards[i].style.bottom = ((fjDiversionButton.offsetHeight / 2) + 21) + 'px';
    }
  }
});

// move swipe card
function moveSwipeCard(x, y) {
  // send y if only it is greater than 0
  if(y > 0) {
    y = 0;
  }
  // return if no children
  if(!page_firstChild) {
    return;
  }
  // move the first card with the deltaY
  rafCall(setTransform, page_firstChild, 'translate3d(' + x + 'px,' + y + 'px,0) rotate(' + (x / 12.5) + 'deg)');
}

fjLayout_Hammer.on('panleft panright', function (ev) {
  // if page cards aren't calculated
  if(!pageCalc) {
    calculateCardValues();
  }
  // if page is a subroute
  if(page_type === 1 && pageHash.length > 1) {
    moveSwipeCard(ev.deltaX, ev.deltaY);
  }
});