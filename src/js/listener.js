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
  fjMainMenu = document.getElementById('fj-main-menu'),
  fjInnerContent = document.getElementById('fj-inner-content'),
  fjLayout = document.getElementById('fj-layout'),
  fjFloatContainer = document.getElementById('fj-float-container'),
  header = document.getElementById('fj-main-header'),
  fjHeaderTitle = document.getElementById('fj-header-title'),
  fjDownButton = document.getElementById('fj-down-button'),
  fjInnerScroller = zenscroll.createScroller(fjInnerContent, 1000, 0),
  svgicon = new svgIcon(menuButton, svgIconConfig, {
    easing: mina.easeOutExpo
  }),
  isSideMoving = false,
  page_scrollDir = Hammer.DIRECTION_NONE,
  page_menuVal = 0,
  isSideMenuOpen = false,
  // base api url
  projectHostName = '//feeljoy.in',
  base_url = projectHostName + '/apis/user/scheduler',
  // id is also the base route
  fjLayout_Hammer = new Hammer.Manager(fjLayout, {
    touchAction: 'pan-y'
  }),
  page_colors = ['cyan', 'darkcyan', 'darkgreen', 'green', 'white', 'inverted'],
  true_colors = ['cyan', 'darkcyan', 'darkgreen', 'green'],
  scrollThreshold = 0.5,
  timeouts = {
    showFjLoader: ''
  },
  fjLayoutTap = new Hammer.Tap(),
  fjLayoutPan = new Hammer.Pan({
    direction: Hammer.DIRECTION_HORIZONTAL
  }),
  fjLayoutSwipe = new Hammer.Swipe({
    direction: Hammer.DIRECTION_HORIZONTAL
  });

// adding recognisers for both
fjLayout_Hammer.add([fjLayoutSwipe, fjLayoutPan, fjLayoutTap]);
fjLayoutSwipe.recognizeWith(fjLayoutPan);

page.base(getBasePage());
// HACK add query ? on page load
page.redirect('?');
page('/', queryParse);
page();

function queryParse(ctx, next) {
  queries = getQueryAsObjects(ctx.querystring);
  if(queries.hasOwnProperty('menu') && !isSideMenuOpen) {
    sidemenuOpen();
  } else {
    sidemenuClose();
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
  rafCall(setTransform, fjMainMenu, 'translate3d(-100%,0,0)');
  setTransition(fjMainMenu, .3 + stdEasing);
  fjLayout.classList.add('is-overlay');
  setTimeout(function () {
    setTransition(fjMainMenu, '');
  }, 300);
  // toggle it's state
  isSideMenuOpen = true;
}

function sidemenuClose() {
  rafCall(setTransform, fjMainMenu, '');
  setTransition(fjMainMenu, .3 + stdEasing);
  fjLayout.classList.remove('is-overlay');
  setTimeout(function () {
    setTransition(fjMainMenu, '');
  }, 300);
  // toggle it's state
  isSideMenuOpen = false;
}

// load page and list of listeners
function loadScheduler() {
  loadTheme();
}

loadScheduler();

// tap overlay to close the diversion
fjLayout_Hammer.on('tap', function (ev) {
  var innerCards, i;
  // if inside hamburger button toggle the menu
  if(menuButton.contains(ev.target)) {
    addQuery('menu=1', true);
    return;
  }

  if(fjRetryLoader.contains(ev.target) && !isSideMenuOpen) {
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

  // down arrow
  if(!isSideMenuOpen && fjDownButton.contains(ev.target)) {
    fjInnerScroller.setup(1600, 0);
    fjInnerScroller.to(document.querySelector('.fj-section-2'));
    return;
  }

  // click to redirect pages
  innerCards = fjInnerContent.querySelectorAll('.fj-listener-grid figure');
  i = innerCards.length;
  while(i--) {
    // also the menu must not be open
    if(innerCards[i].contains(ev.target) && !isSideMenuOpen) {
      window.location.href = innerCards[i].getAttribute('data-link');
      return;
    }
  }

  // click anywhere to close
  if(isSideMenuOpen && !fjMainMenu.contains(ev.target)) {
    window.history.back();
    return;
  }
});

fjLayout_Hammer.on('swipeleft swiperight', function (ev) {
  if(isSideMenuOpen && ev.direction === Hammer.DIRECTION_RIGHT) {
    window.history.back();
  } else if(!isSideMenuOpen && ev.direction === Hammer.DIRECTION_LEFT) {
    addQuery('menu=1', true);
  }
});

// pan scroll
// increase the card scroll number
fjLayout_Hammer.on('panend pancancel', function (ev) {
  var checkRatio, transitionTime;
  if(isSideMoving) {
    checkRatio = Math.abs(getComputedTranslateX(fjMainMenu)) / fjMainMenu.offsetWidth;
    // if the menu was open attempt closing it
    if(isSideMenuOpen) {
      if(checkRatio < scrollThreshold) {
        window.history.back();
      } else {
        rafCall(setTransform, fjMainMenu, 'translate3d(-100%,0,0)');
        setTransition(fjMainMenu, .3 + stdEasing);
        setTimeout(function () {
          setTransition(fjMainMenu, '');
        }, 300);
      }
    } else {
      if(checkRatio > scrollThreshold) {
        addQuery('menu=1', true);
      } else {
        rafCall(setTransform, fjMainMenu, '');
        setTransition(fjMainMenu, .3 + stdEasing);
        setTimeout(function () {
          setTransition(fjMainMenu, '');
        }, 300);
      }
    }
    isSideMoving = false;
  }
  // reset the pan direction
  page_scrollDir = Hammer.DIRECTION_NONE;
});

fjLayout_Hammer.on('panleft panright', function (ev) {
  page_menuVal = getComputedTranslateX(fjMainMenu) + (ev.velocityX * getScrollVelocityFactor());
  // cant go furthur then left
  if(Math.abs(page_menuVal) <= fjMainMenu.offsetWidth) {
    rafCall(setTransform, fjMainMenu, 'translate3d(' + page_menuVal + 'px,0,0)');
    isSideMoving = true;
    page_scrollDir = ev.direction;
  }
});