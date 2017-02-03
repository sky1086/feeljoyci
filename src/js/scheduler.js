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
  fjDateHolder = document.getElementById('fj-date-holder'),
  fjDateTab = document.getElementById('fj-date-tab'),
  fjDiversionButton = document.getElementById('fj-diversion-button'),
  fjInnerContent = document.getElementById('fj-inner-content'),
  fjFloatContainer = document.getElementById('fj-float-container'),
  header = document.getElementById('fj-main-header'),
  fjHeaderTitle = document.getElementById('fj-header-title'),
  fjSlotButton = document.getElementById('fj-slot-button'),
  fjSaveButton = document.getElementById('fj-save-button'),
  fjDropdownElement = document.getElementById('fj-dropdown-element'),
  fjDropdownContent = document.getElementById('fj-dropdown-content'),
  fjButtonContainer = document.getElementById('fj-button-container'),
  fjInnerScroller = zenscroll.createScroller(fjInnerContent, 1000, 0),
  svgicon = new svgIcon(menuButton, svgIconConfig, {
    easing: mina.easeOutExpo
  }),
  isSideMoving = false,
  page_scrollDir = Hammer.DIRECTION_NONE,
  page_menuVal = 0,
  isSideMenuOpen = false,
  isDropdownOpen = false,
  schedule = [],
  // base api url
  projectHostName = '//feeljoy.in',
  base_url = projectHostName + '/apis/user/scheduler',
  // id is also the base route
  fjLayout_Hammer = new Hammer.Manager(document.body, {
    recognizers: [
      [Hammer.Tap]
    ]
  }),
  fjDropdownContent_Hammer = new Hammer.Manager(fjDropdownContent, {
    recognizers: [
      [Hammer.Tap]
    ]
  }),
  page_colors = ['cyan', 'darkcyan', 'darkgreen', 'green', 'white', 'inverted'],
  true_colors = ['cyan', 'darkcyan', 'darkgreen', 'green'],
  scrollThreshold = 0.5,
  curStart = moment(),
  timeouts = {
    showFjLoader: ''
  };

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

// get an array of moment special objects
function updateDays() {
  var days = fjDateTab.querySelectorAll('.fj-date-tab'),
    temp, num = days.length;
  while(num--) {
    temp = curStart.clone()
      .add(num, 'd');
    // if today or tomorrow then same else change
    days[num].querySelector('.fj-date-title')
      .innerHTML = temp.calendar(curStart, {
        sameDay: '[Today]',
        nextDay: '[Tomorrow]',
        nextWeek: 'ddd',
        lastDay: '[Yesterday]',
        lastWeek: '[Last] ddd',
        sameElse: 'ddd'
      });
    days[num].querySelector('.fj-date-subtitle')
      .innerHTML = temp.format('D MMM');
  }
}

function generateTimeList() {
  var start = moment()
    .startOf('day'),
    li,
    frag = document.createDocumentFragment();
  for(var i = 0; i < 288; i++) {
    li = document.createElement('li');
    li.innerHTML = start.format('h:mm A');
    li.setAttribute('data-date', start.toISOString());
    start = start.clone()
      .add(5, 'm');
    frag.appendChild(li);
  }
  fjDropdownContent.appendChild(frag);
}

// update smaller timeslot
function updateSmalltimestamp(el, time) {
  el = document.querySelector(el);
  el.parentNode.parentNode.parentNode.setAttribute('data-' + el.getAttribute('data-cur'), time);
  el = el.querySelectorAll('li');
  time = moment(time);
  el[0].innerHTML = time.clone()
    .subtract(5, 'm')
    .format('h:mm A');
  el[1].innerHTML = time.format('h:mm A');
  el[2].innerHTML = time.clone()
    .add(5, 'm')
    .format('h:mm A');
}

// show edit dot
function showEditdot() {
  var el = fjDateTab.querySelector('.active');
  el = el.querySelector('.fj-date-change');
  el.classList.remove('updated');
  el.classList.add('changed');
}

// show update dot
function showUpdatedot() {
  var el = fjDateTab.querySelector('.active');
  el = el.querySelector('.fj-date-change');
  el.classList.remove('changed');
  el.classList.add('updated');
}

function deleteSlot(el) {
  // hide the element
  el.classList.add('is-hidden');
  showEditdot();
  setTimeout(function () {
    clearInner(el);
  }, 300);
}

// show the slot
function expandSlot(el) {
  var start = el.getAttribute('data-start'),
    end = el.getAttribute('data-end'),
    timedisplay = el.querySelector('.fj-time-display');
  // hide the element
  timedisplay.classList.add('is-hidden');
  // remove element after hidden
  setTimeout(function () {
    deleteNode(timedisplay);
    // change the class
    el.classList.remove('is-close');
    el.classList.add('is-open');
  }, 300);
  // go ahead if both are valid
  if(start) {
    start = moment(start);
  } else {
    start = '-:- --';
  }
  if(end) {
    end = moment(end);
  } else {
    end = '-:- --';
  }
  // add a opened slot
  el.appendChild(createOpenedSlot(start, end));
}

// hide the slot
function unexpandSlot(el) {
  var start = el.getAttribute('data-start'),
    end = el.getAttribute('data-end'),
    timeslot = el.querySelector('.fj-time-slot');
  // hide the element
  timeslot.classList.add('is-hidden');
  // remove element after hidden
  setTimeout(function () {
    deleteNode(timeslot);
    // change the class
    el.classList.remove('is-open');
    el.classList.add('is-close');
  }, 300);
  // go ahead if both are valid
  if(start) {
    start = moment(start)
      .format('h:mm A');
  } else {
    start = '-:- --';
  }
  if(end) {
    end = moment(end)
      .format('h:mm A');
  } else {
    end = '-:- --';
  }
  // add a closed slot
  el.appendChild(createClosedSlot(start, end));
  setTimeout(function () {
    fjInnerScroller.setup(1000, header.offsetHeight);
    fjInnerScroller.center(el);
  }, 300);
}

// create a opened slot
function createOpenedSlot(start, end) {
  var frag = document.createDocumentFragment(),
    cont = document.createElement('div'),
    p = document.createElement('p'),
    li = document.createElement('li'),
    div = document.createElement('div');
  cont.classList.add('fj-time-slot');
  div.classList.add('fj-dropdown-container');
  p.innerHTML = 'Start Time';
  div.appendChild(p);
  p = document.createElement('ul');
  p.setAttribute('data-cur', 'start');
  p.classList.add('fj-dropdown-button');
  if(start === '-:- --') {
    li.innerHTML = '-:- --';
    p.appendChild(li);
    li = document.createElement('li');
    li.classList.add('is-active');
    li.innerHTML = '-:- --';
    p.appendChild(li);
    li = document.createElement('li');
    li.innerHTML = '-:- --';
  } else {
    li.innerHTML = start.clone()
      .subtract(5, 'm')
      .format('h:mm A');
    p.appendChild(li);
    li = document.createElement('li');
    li.classList.add('is-active');
    li.innerHTML = start.format('h:mm A');
    p.appendChild(li);
    li = document.createElement('li');
    li.innerHTML = start.clone()
      .add(5, 'm')
      .format('h:mm A');
  }
  p.appendChild(li);
  div.appendChild(p);
  cont.appendChild(div);
  p = document.createElement('p');
  p.innerHTML = 'to';
  cont.appendChild(p);
  div = document.createElement('div');
  div.classList.add('fj-dropdown-container');
  p = document.createElement('p');
  p.innerHTML = 'End Time';
  div.appendChild(p);
  p = document.createElement('ul');
  p.setAttribute('data-cur', 'end');
  p.classList.add('fj-dropdown-button');
  li = document.createElement('li');
  if(end === '-:- --') {
    li.innerHTML = '-:- --';
    p.appendChild(li);
    li = document.createElement('li');
    li.classList.add('is-active');
    li.innerHTML = '-:- --';
    p.appendChild(li);
    li = document.createElement('li');
    li.innerHTML = '-:- --';
  } else {
    li.innerHTML = end.clone()
      .subtract(5, 'm')
      .format('h:mm A');
    p.appendChild(li);
    li = document.createElement('li');
    li.classList.add('is-active');
    li.innerHTML = end.format('h:mm A');
    p.appendChild(li);
    li = document.createElement('li');
    li.innerHTML = end.clone()
      .add(5, 'm')
      .format('h:mm A');
  }
  p.appendChild(li);
  div.appendChild(p);
  cont.appendChild(div);
  frag.appendChild(cont);
  return frag;
}

// create a closed slot
function createClosedSlot(start, end) {
  var frag = document.createDocumentFragment(),
    cont = document.createElement('div'),
    button = document.createElement('button'),
    i = document.createElement('i'),
    div = document.createElement('div');
  cont.classList.add('fj-time-display');
  div.classList.add('fj-time-range');
  div.innerHTML = start + ' to ' + end;
  cont.appendChild(div);
  div = document.createElement('div');
  div.classList.add('fj-time-options');
  doClasses(button, ['waves-effect', 'waves-circle', 'waves-light', 'btn-floating', 'btn-large', 'fj-icon', 'fj-toolbar-button', 'fj-edit-button']);
  i.classList.add('icon-mode_edit');
  button.appendChild(i);
  div.appendChild(button);
  button = document.createElement('button');
  i = document.createElement('i');
  doClasses(button, ['waves-effect', 'waves-circle', 'waves-light', 'btn-floating', 'btn-large', 'fj-icon', 'fj-toolbar-button', 'fj-delete-button']);
  i.classList.add('icon-delete');
  button.appendChild(i);
  div.appendChild(button);
  cont.appendChild(div);
  frag.appendChild(cont);
  return frag;
}

function addAnotherSlot() {
  var el = fjDateHolder.querySelector('.fj-date-panel.is-active');
  el = el.querySelectorAll('.fj-slot-container.is-open');
  for(var i in el) {
    if(el.hasOwnProperty(i)) {
      unexpandSlot(el[i]);
    }
  }
  // add a full slot
  createAnotherSlot();
}

function createAnotherSlot() {
  var frag = document.createDocumentFragment(),
    cont = document.createElement('div'),
    div = document.createElement('div'),
    span = document.createElement('span'),
    input = document.createElement('input'),
    el = fjDateHolder.querySelector('.fj-date-panel.is-active'),
    count = el.querySelectorAll('.fj-slot-container')
    .length + 1,
    i = el.getAttribute('data-tab');
  doClasses(cont, ['mdl-shadow--2dp', 'fj-slot-container', 'is-open']);
  cont.id = 'fj-slot-container-' + i + count;
  // checkbox container
  div.classList.add('fj-checkbox-container');
  span.classList.add('fj-checkbox-text');
  span.innerHTML = 'Availability';
  div.appendChild(span);
  span = document.createElement('label');
  doClasses(span, ['mdl-switch', 'mdl-js-switch', 'mdl-js-ripple-effect', 'fj-checkbox-label']);
  span.id = 'fj-switch-' + i + count;
  input.setAttribute('type', 'checkbox');
  input.setAttribute('checked', '');
  input.setAttribute('for', 'fj-switch-' + i + count);
  input.classList.add('mdl-switch__input');
  span.appendChild(input);
  input = document.createElement('span');
  input.classList.add('mdl-switch__label');
  span.appendChild(input);
  div.appendChild(span);
  // button slot hide
  span = document.createElement('button');
  doClasses(span, ['waves-effect', 'waves-circle', 'waves-dark', 'btn-floating', 'btn-large', 'fj-toolbar-button', 'fj-slot-hide']);
  input = document.createElement('i');
  input.classList.add('icon-expand_less');
  span.appendChild(input);
  div.appendChild(span);
  cont.appendChild(div);
  // cap title
  div = document.createElement('h6');
  div.innerHTML = 'Select your slot';
  div.classList.add('fj-slot-captitle');
  cont.appendChild(div);
  // subtitle
  div = document.createElement('p');
  div.innerHTML = 'You will be marked online during this period';
  div.classList.add('fj-slot-subtitle');
  cont.appendChild(div);
  cont.appendChild(createOpenedSlot('-:- --', '-:- --'));
  frag.appendChild(cont);
  el.appendChild(frag);
  // scroll to that item
  setTimeout(function () {
    fjInnerScroller.setup(1000, header.offsetHeight);
    fjInnerScroller.center(document.getElementById('fj-slot-container-' + i + count));
  }, 600);
}

function showDropdown(el) {
  fjDropdownElement.classList.remove('is-hidden');
  doClasses(fjDropdownElement, ['animate', 'zoomIn']);
  showOverlay([fjDropdownElement]);
  isDropdownOpen = true;
  setTimeout(function () {
    fjDropdownElement.classList.remove('animate');
  }, 300);
  if(el) {
    fjDropdownContent.setAttribute('data-el', el);
  }
}

function hideDropdown(el, time) {
  doClasses(fjDropdownElement, ['animate', 'zoomIn'], true);
  fjDropdownElement.classList.add('is-hidden');
  hideOverlay([fjDropdownElement]);
  isDropdownOpen = false;
  // set the value also
  if(el) {
    updateSmalltimestamp(el, time);
    showEditdot();
    fjDropdownContent.removeAttribute('data-el');
  }
}

// load page and list of listeners
function loadScheduler() {
  loadTheme();
  // week headers
  updateDays();
  // list of time stamps
  generateTimeList();
}

loadScheduler();

// tap overlay to close the diversion
fjLayout_Hammer.on('tap', function (ev) {
  var innerCards, i;

  // open time picker
  innerCards = fjInnerContent.querySelectorAll('.fj-dropdown-button');
  i = innerCards.length;
  while(i--) {
    if(innerCards[i].contains(ev.target) && !isSideMenuOpen) {
      showDropdown('.fj-dropdown-button[data-cur=' + innerCards[i].getAttribute('data-cur') + ']');
      return;
    }
  }

  // edit time picker
  innerCards = fjInnerContent.querySelectorAll('.fj-edit-button');
  i = innerCards.length;
  while(i--) {
    if(innerCards[i].contains(ev.target) && !isSideMenuOpen && !isDropdownOpen) {
      expandSlot(innerCards[i].parentNode.parentNode.parentNode);
      return;
    }
  }

  // delete time picker
  innerCards = fjInnerContent.querySelectorAll('.fj-delete-button');
  i = innerCards.length;
  while(i--) {
    if(innerCards[i].contains(ev.target) && !isSideMenuOpen && !isDropdownOpen) {
      deleteSlot(innerCards[i].parentNode.parentNode.parentNode);
      return;
    }
  }

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

  // if inside container
  innerCards = fjInnerContent.querySelectorAll('.fj-slot-hide');
  i = innerCards.length;
  while(i--) {
    // also the menu must not be open
    if(innerCards[i].contains(ev.target)) {
      unexpandSlot(innerCards[i].parentNode.parentNode);
      return;
    }
  }

  // add a slot
  if(fjSlotButton.contains(ev.target) && !isSideMenuOpen && !isDropdownOpen) {
    addAnotherSlot();
    return;
  }

  // save it to the site
  if(fjSaveButton.contains(ev.target) && !isSideMenuOpen && !isDropdownOpen) {
    console.log('save slots');
    return;
  }

  // if inside tappable menu
  innerCards = fjMainMenu.querySelectorAll('.fj-color-swatch');
  i = innerCards.length;
  while(i--) {
    // also the menu must not be open
    if(innerCards[i].contains(ev.target) && !isSideMenuOpen) {
      saveTheme(innerCards[i].getAttribute('data-color'));
      return;
    }
  }

  // click anywhere to close
  if(isDropdownOpen) {
    hideDropdown();
    return;
  }

  if(isSideMenuOpen && !fjMainMenu.contains(ev.target)) {
    window.history.back();
    return;
  }
});

fjDropdownContent_Hammer.on('tap', function (ev) {
  // select time tap
  var innerCards = fjDropdownContent.querySelectorAll('li'),
    i = innerCards.length;
  while(i--) {
    if(innerCards[i].contains(ev.target)) {
      hideDropdown(fjDropdownContent.getAttribute('data-el'), innerCards[i].getAttribute('data-date'));
      return;
    }
  }
});

fjLayout_Hammer.on('swipeleft swiperight', function (ev) {
  if(isDropdownOpen) {
    return;
  }
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
  if(isDropdownOpen) {
    return;
  }
  page_menuVal = getComputedTranslateX(fjMainMenu) + (ev.velocityX * getScrollVelocityFactor());
  // cant go furthur then left
  if(Math.abs(page_menuVal) <= fjMainMenu.offsetWidth) {
    rafCall(setTransform, fjMainMenu, 'translate3d(' + page_menuVal + 'px,0,0)');
    isSideMoving = true;
    page_scrollDir = ev.direction;
  }
});