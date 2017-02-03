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
  fjFloatContainer = document.getElementById('fj-float-container'),
  fjDiversionButton = document.getElementById('fj-diversion-button'),
  fjCustomerLogin = document.getElementById('fj-customer-login'),
  fjStartJourney = document.getElementById('fj-start-journey'),
  header = document.getElementById('fj-main-header'),
  fjHeaderTitle = document.getElementById('fj-header-title'),
  fjDownButton = document.getElementById('fj-down-button'),
  fjPlaceholderInfo = document.getElementById('fj-placeholder-info'),
  fjInnerScroller = zenscroll.createScroller(fjInnerContent, 1000, 0),
  svgicon = new svgIcon(menuButton, svgIconConfig, {
    easing: mina.easeOutExpo
  }),
  isIconMenuOpen = false,
  isSideMenuOpen = false,
  // base api url
  projectHostName = '//feeljoy.in',
  base_url = projectHostName + '/apis/user/customer',
  page_colors = ['cyan', 'darkcyan', 'darkgreen', 'green', 'white', 'inverted'],
  true_colors = ['cyan', 'darkcyan', 'darkgreen', 'green'],
  timeouts = {
    showFjLoader: ''
  },
  fjLayout_Hammer = new Hammer.Manager(document.body, {
    recognizers: [
      [Hammer.Tap]
    ]
  });

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

// should show the first time overlay for fab or show it anyway
function shouldShowFab() {
  var shouldShow = localStorage.getItem('show_it_definitely');
  if(shouldShow) {
    doClasses(fjFloatContainer, ['animate', 'zoomIn']);
    setTimeout(function () {
      fjFloatContainer.classList.remove('is-not-opacity');
    }, 300);
  }
}

// load page and list of listeners
function loadScheduler() {
  loadTheme();
  // should show the fab or not?
  shouldShowFab();
}

loadScheduler();

// show first time overlay
function showFirstTimeOverlay() {
  var first = fjPlaceholderInfo.querySelector('.fj-placeholder-background'),
    second = fjPlaceholderInfo.querySelector('.fj-focus-elt'),
    third = fjPlaceholderInfo.querySelector('.fj-placeholder-text');
  doClasses(fjPlaceholderInfo, ['is-hidden', 'animate', 'fadeIn', 'fadeOut'], true);
  multiCall(doClasses, [fjPlaceholderInfo, third], ['animate', 'fadeIn']);
  multiCall(doClasses, [first, second, fjFloatContainer], ['animate', 'zoomIn']);
  localStorage.setItem('show_it_definitely', true);
}

function hideFirstTimeOverlay() {
  fjFloatContainer.classList.remove('is-not-opacity');
  doClasses(fjPlaceholderInfo, ['animate', 'fadeOut']);
  setTimeout(function () {
    fjPlaceholderInfo.classList.add('is-hidden');
  }, 600);
}

// tap overlay to close the diversion
fjLayout_Hammer.on('tap', function (ev) {
  var innerCards, i;

  if(fjRetryLoader.contains(ev.target)) {
    location.reload();
    return;
  }

  // if inside tappable menu
  innerCards = fjMainMenu.querySelectorAll('.fj-color-swatch');
  i = innerCards.length;
  while(i--) {
    // also the menu must be open
    if(innerCards[i].contains(ev.target)) {
      saveTheme(innerCards[i].getAttribute('data-color'));
      return;
    }
  }

  // placeholder hide it
  if(fjPlaceholderInfo.contains(ev.target)) {
    hideFirstTimeOverlay();
    return;
  }
  // down arrow
  if(fjDownButton.contains(ev.target)) {
    fjInnerScroller.setup(1600, 0);
    fjInnerScroller.to(document.querySelector('.fj-section-2'));
    return;
  }

  // click to redirect pages
  innerCards = fjInnerContent.querySelectorAll('.fj-listener-grid figure');
  i = innerCards.length;
  while(i--) {
    // also the menu must not be open
    if(innerCards[i].contains(ev.target)) {
      window.location.href = innerCards[i].getAttribute('data-link');
      return;
    }
  }

  if(fjStartJourney.contains(ev.target) || fjCustomerLogin.contains(ev.target)) {
    showFirstTimeOverlay();
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