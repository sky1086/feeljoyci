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
  isAutoHide = false,
  // id is also the base route
  fjLayout_Hammer = new Hammer.Manager(fjLayout, {}),
  defaultRoute = 0,
  page_scroll = 0,
  page_scrollDir = Hammer.DIRECTION_NONE,
  page_scrollVal = 0,
  page_menuVal = 0,
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

var previous_scroll = $('#fj-inner-content')
  .scrollTop();

$('#fj-inner-content')
  .on('scroll', function () {
    var scroll = $('#fj-inner-content')
      .scrollTop(),
      scroll_change = scroll - previous_scroll;
    previous_scroll = scroll;
    $('#fj-inner-content')
      .trigger('custom_scroll', [scroll_change]);
  });

$('#fj-inner-content')
  .on('custom_scroll', function pos(e, scroll_change) {
    var sign = Math.sign(scroll_change),
      value = getScrollVelocityFactor();
    // go down
    if(scroll_change > value && sign === 1) {
      if(!isAutoHide) {
        onAutoHide()
      }
    }
    // go up
    else if(scroll_change < (value * sign) && sign === -1) {
      if(isAutoHide) {
        onAutoShow()
      }
    }
  });

// hide or show the header and fav
function onAutoHide() {
  header.classList.remove('slideInDown');
  fjFloatContainer.classList.remove('zoomIn');
  doClasses(header, ['animate', 'slideOutUp']);
  doClasses(fjFloatContainer, ['animate', 'zoomOut']);
  setTimeout(function () {
    fjFloatContainer.classList.add('is-not-opacity');
  }, 300);
  isAutoHide = true;
}

function onAutoShow() {
  header.classList.remove('slideOutUp');
  doClasses(fjFloatContainer, ['is-not-opacity', 'zoomOut'], true);
  doClasses(header, ['animate', 'slideInDown']);
  doClasses(fjFloatContainer, ['animate', 'zoomIn']);
  isAutoHide = false;
}

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

// tap overlay to close the diversion
fjLayout_Hammer.on('tap', function (ev) {
  var innerCards, i, curEl;

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