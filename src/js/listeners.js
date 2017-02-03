var menuButton = document.getElementById('fj-icon-hamburger'),
  main = document.getElementById('fj-main-content'),
  fjMainMenu = document.getElementById('fj-main-menu'),
  fjFloatMenu = document.getElementById('fj-float-menu'),
  fjDiversionButton = document.getElementById('fj-diversion-button'),
  fjInnerContent = document.getElementById('fj-inner-content'),
  fjBuddyList = document.getElementById('fj-buddy-list'),
  fjChatList = document.getElementById('fj-chat-list'),
  fjLayout = document.getElementById('fj-layout'),
  fjFloatContainer = document.getElementById('fj-float-container'),
  header = document.getElementById('fj-main-header'),
  fjHeaderTitle = document.getElementById('fj-header-title'),
  fjHeaderLogo = document.getElementById('fj-header-logo'),
  isIconMenuOpen = false,
  isSideMenuOpen = false,
  isSideMoving = false,
  // base api url
  projectHostName = '//feeljoy.in',
  base_url = projectHostName + '/apis/user/listeners',
  chat_url = projectHostName + '/apis/listener/userlist',
  // id is also the base route
  fjLayout_Hammer = new Hammer.Manager(fjLayout, {}),
  defaultRoute = 0,
  page_scroll = 0,
  page_scrollDir = Hammer.DIRECTION_NONE,
  page_scrollVal = 0,
  page_menuVal = 0,
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
  true_colors_hashes = ['#0097A7', '#009688', '#4CAF50', '#8BC34A'],
  // to determine the type of swipe / scroll to implement
  scrollThreshold = 0.5,
  pageHash = [],
  timeouts = {
    menuClose: '',
    menuOpen: '',
    showFjLoader: ''
  },
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

page.base(getBasePage());
// HACK add query ? on page load
page.redirect('?');
page('/', queryParse);
page();


// init menu
function initSideMenu() {
  $('#fj-icon-hamburger')
    .sideNav({
      menuWidth: 250, // Default is 300
      edge: 'right', // Choose the horizontal origin
      closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
      draggable: true // Choose whether you can drag to open on touch screens
    });
}

initSideMenu();

function queryParse(ctx, next) {
  queries = getQueryAsObjects(ctx.querystring);
  if(queries.hasOwnProperty('menu')) {
    if(!isSideMenuOpen) {
      sidemenuOpen();
    }
  } else {
    if(isSideMenuOpen) {
      sidemenuClose();
    }
  }
}

// open or close the side menu
function sidemenuToggle() {
  if(isSideMenuOpen) {
    sidemenuClose();
  } else {
    sidemenuOpen();
  }
}

function sidemenuOpen() {
  $('#fj-icon-hamburger')
    .sideNav('show');
  // toggle it's state
  isSideMenuOpen = true;
}

function sidemenuClose() {
  $('#fj-icon-hamburger')
    .sideNav('hide');
  // toggle it's state
  isSideMenuOpen = false;
}

// detect side menu open or close
// http://stackoverflow.com/questions/39024163/how-to-react-to-a-specific-style-attribute-change-with-mutation-observers
var fjMainMenuObserver = new MutationObserver(fjMainMenuStyleChangedCallback),
  fjMainMenuTransformIndex = fjMainMenu.style.transform;

fjMainMenuObserver.observe(fjMainMenu, {
  attributes: true,
  attributeFilter: ['style']
});

function fjMainMenuStyleChangedCallback(mutations) {
  var newIndex = mutations[0].target.style.transform;
  if(newIndex !== fjMainMenuTransformIndex) {
    var transform = getComputedTranslateX(fjMainMenu);
    // open
    if(transform === 0 && !isSideMenuOpen) {
      isSideMenuOpen = true;
      addQuery('menu=1', true);
      // HACK to detect close
    } else if(transform > 249 && isSideMenuOpen) {
      isSideMenuOpen = false;
      window.history.back();
    }
  }
}

// function make a chat placeholder
function createChatPlaceholder() {
  var frag = document.createDocumentFragment(),
    div = document.createElement('div'),
    img = document.createElement('img');
  div.id = 'fj-chat-placeholder';
  div.classList.add('fj-chat-placeholder');
  img.setAttribute('src', 'img/chat-placeholder.png');
  img.setAttribute('alt', 'chat-placeholder');
  div.appendChild(img);
  img = document.createElement('h6');
  img.innerHTML = 'Hold on, we\'ll soon have a buddy for you to help';
  div.appendChild(img);
  img = document.createElement('h6');
  img.innerHTML = 'Meanwhile, you can view our <a href="#">self help guide</a> to help you prepare';
  div.appendChild(img);
  frag.appendChild(div);
  return frag;
}

// only for the base first page
function initChatPage(data) {
  data = data.result;
  // add content to it
  var i, frag = document.createDocumentFragment(),
    avatar,
    right,
    iconfo,
    iconfo2,
    cont,
    textCont,
    text,
    subText;
  for(i = 0; i < data.length; i++) {
    // anchor tag button
    avatar = document.createElement('div');
    right = document.createElement('div');
    iconfo = document.createElement('div');
    iconfo2 = document.createElement('div');
    cont = document.createElement('div');
    textCont = document.createElement('div');
    text = document.createElement('h5');
    subText = document.createElement('h6');
    avatar.innerHTML = data[i].contact_name.charAt(0);
    iconfo.classList.add('fj-card-talk');
    iconfo2.classList.add('fj-card-badge');
    iconfo.innerHTML = '12:30 AM';
    iconfo2.innerHTML = '1';
    doClasses(avatar, ['fj-card-avatar', true_colors[Math.floor(Math.random() * true_colors.length)]]);
    right.classList.add('fj-card-right');
    doClasses(cont, ['fj-card-figure', 'mdl-shadow--2dp', 'white']);
    textCont.classList.add('fj-card-text');
    text.innerHTML = data[i].contact_name;
    subText.innerHTML = 'last message';
    textCont.appendChild(text);
    textCont.appendChild(subText);
    right.appendChild(iconfo);
    right.appendChild(iconfo2);
    right.setAttribute('data-link', data[i].chat_link);
    cont.setAttribute('data-link', data[i].profile_link);
    cont.appendChild(avatar);
    cont.appendChild(textCont);
    cont.appendChild(right);
    frag.appendChild(cont);
  }
  // add frag to doc
  fjChatList.appendChild(frag);
}

// load page and list of listeners
function loadChatEngine() {
  loadTheme();
  makeRequest(chat_url)
    .then(function (data) {
      data = JSON.parse(data);
      // turn off the loader icon
      hideFjLoader(true);
      if(data.error) {
        // show the placeholder on error
        fjChatList.appendChild(createChatPlaceholder());
      } else {
        initChatPage(data);
      }
    })
    .catch(function (err) {
      // TODO We reached our target server, but it returned an error so retry the last request
      showErrorButton();
      console.error(err);
    });
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

function loadPage() {
  loadBasePage();
  loadChatEngine();
}

loadPage();

// only for the base first page
function initCardPage(data) {
  // turn off the loader icon
  hideFjLoader(true);
  // add content to it
  var i, frag = document.createDocumentFragment(),
    avatar,
    left,
    right,
    iconfo,
    icon,
    cont,
    textCont,
    text,
    subText;
  for(i = 0; i < data.length; i++) {
    // anchor tag button
    avatar = document.createElement('div');
    left = document.createElement('div');
    right = document.createElement('div');
    iconfo = document.createElement('div');
    icon = document.createElement('i');
    cont = document.createElement('div');
    textCont = document.createElement('div');
    text = document.createElement('h5');
    subText = document.createElement('h6');
    avatar.innerHTML = data[i].name.charAt(0);
    iconfo.classList.add('fj-card-talk');
    iconfo.innerHTML = 'Talk to ' + data[i].name.split(' ')[0] + '?';
    doClasses(avatar, ['fj-card-avatar', true_colors[Math.floor(Math.random() * true_colors.length)]]);
    doClasses(icon, ['icon-chat_icon', 'fj-card-icon']);
    doClasses(left, ['fj-card-left', 'waves-effect', 'waves-dark'])
    doClasses(right, ['fj-card-right', 'waves-effect', 'waves-dark'])
    doClasses(cont, ['fj-card-figure', 'white']);
    textCont.classList.add('fj-card-text');
    text.innerHTML = data[i].name.split(' ')[0];
    subText.innerHTML = data[i].qualification;
    textCont.appendChild(text);
    textCont.appendChild(subText);
    left.appendChild(avatar);
    left.appendChild(textCont);
    right.appendChild(iconfo);
    right.appendChild(icon);
    left.setAttribute('data-link', data[i].profile_link);
    right.setAttribute('data-link', data[i].link);
    cont.appendChild(left);
    cont.appendChild(right);
    frag.appendChild(cont);
  }
  // add frag to list
  fjBuddyList.appendChild(frag);
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
      // TODO after both are done not just this one
      $('#fj-listener-tabs')
        .tabs({
          'swipeable': true
        });
    }, 300);
  }, 300);
}

// do menu and other page loaded settings
function doPageStuff(passHash) {
  loadTheme();
  // hide the inner content page and remove other unnecessary classes
  fjRetryLoader.classList.add('is-hidden');
  doClasses(fjInnerContent, ['animate', 'slideInUp', 'slideOutDown'].concat(page_colors), true);
}

// update page title
function upPageTitle(title) {
  // change the document's title to match the new one for bookmark friendly-ness
  // http://stackoverflow.com/questions/413439/how-to-dynamically-change-a-web-pages-title
  document.title = 'Feeljoy' + (title ? ' - ' + title : '');
  fjHeaderTitle.innerHTML = title;
}

// tap overlay to close the diversion
fjLayout_Hammer.on('tap', function (ev) {
  var innerCards, i, curEl;

  if(fjRetryLoader.contains(ev.target)) {
    location.reload();
    return;
  }

  // if inside tappable menu
  innerCards = fjMainMenu.querySelectorAll('.fj-color-swatch');
  i = innerCards.length;
  while(i--) {
    // also the menu must not be open
    if(innerCards[i].contains(ev.target)) {
      saveTheme(innerCards[i].getAttribute('data-color'));
      return;
    }
  }

  // if inside tappable card angry, anxious etc. on a card page
  innerCards = fjInnerContent.querySelectorAll('.fj-card-figure');
  i = innerCards.length;
  while(i--) {
    curEl = innerCards[i].querySelector('.fj-card-right');
    if(curEl.contains(ev.target) && curEl.getAttribute('data-link')) {
      window.location = curEl.getAttribute('data-link');
      return;
    }
    curEl = innerCards[i].querySelector('.fj-card-left');
    if(curEl.contains(ev.target) && curEl.getAttribute('data-link')) {
      window.location = innerCards[i].getAttribute('data-link');
      return;
    }
  }
  
  // show or hide overlay
  if(fjDiversionButton.contains(ev.target) && !isIconMenuOpen) {
    fjFloatContainer.classList.remove('is-nodisplay');
    setTimeout(function () {
      fjFloatContainer.classList.remove('is-hidden');
    }, 10);
    showOverlay([fjFloatContainer], fjFloatContainer);
    isIconMenuOpen = true;
    return;
  }

  // outside tap
  if(isIconMenuOpen) {
    fjFloatContainer.classList.add('is-hidden');
    hideOverlay([fjFloatContainer]);
    isIconMenuOpen = false;
    setTimeout(function () {
      fjFloatContainer.classList.add('is-nodisplay');
    }, 300);
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
  if((page_scroll + page_viewPortCards) < page_cardCount && !isPageMoving) {
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
  // if the page is the first one then open the menu and also if it is closed
  if(page_scroll > 0) {
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
    if(page_scrollDir === Hammer.DIRECTION_UP && !isPageMoving && ((page_scroll + page_viewPortCards) < page_cardCount)) {
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
    //  handle moving down direction
    else if(page_scrollDir === Hammer.DIRECTION_DOWN) {
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
  if(page_scrollDir === Hammer.DIRECTION_DOWN || page_scrollDir === Hammer.DIRECTION_LEFT || page_scrollDir === Hammer.DIRECTION_RIGHT || isPageMoving || ((page_scroll + page_viewPortCards) >= page_cardCount)) {
    return;
  }
  // initial calculations
  var i = page_cardCount,
    cardMaxPos, cardRatio;
  // for base page
  // calculate ...
  cardMaxPos = page_cardHeight * (page_scroll + 1);
  // if the last most item has been reached it can't pan up
  // if it exceeds the card's height increment the page_scroll value and set the cards perfectly
  if(Math.abs(page_scrollVal) >= cardMaxPos) {
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
  if(page_scrollDir === Hammer.DIRECTION_UP || page_scrollDir === Hammer.DIRECTION_LEFT || page_scrollDir === Hammer.DIRECTION_RIGHT || isPageMoving || page_scroll === 0) {
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