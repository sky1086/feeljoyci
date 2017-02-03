var true_colors = ['cyan', 'darkcyan', 'darkgreen', 'green'],
  theme_700_colors = ['#0097A7', '#009688', '#4CAF50', '#8BC34A'],
  page_theme = 'cyan',
  fjCustomerLogin = document.getElementById('fj-customer-login'),
  fjListenerLogin = document.getElementById('fj-listener-login');

function classToColor(classes) {
  return theme_700_colors[true_colors.indexOf(classes)];
}

// update theme color
// http://stackoverflow.com/questions/32330305/update-theme-color-meta-without-page-refresh
function updateThemeColor(color) {
  // create a new meta
  var meta = document.createElement('meta');
  meta.name = 'theme-color';
  meta.content = color;
  //remove the current meta
  deleteNode(document.querySelector('meta[name=theme-color]'));
  //add the new one
  document.querySelector('head')
    .appendChild(meta);
}

// load theme
function loadTheme() {
  var colorCopy, theme = localStorage.getItem('page_color');
  if(theme) {
    doClasses(document.body, true_colors, true);
    document.body.classList.add(theme);
    updateThemeColor(classToColor(theme));
    // if login button add the random logic
    if(fjListenerLogin) {
      // set a random color other then the colorClass
      colorCopy = true_colors.slice(0);
      doClasses(fjListenerLogin, colorCopy, true);
      colorCopy.splice(colorCopy.indexOf(theme), 1);
      theme = colorCopy[Math.floor(Math.random() * colorCopy.length)];
      fjListenerLogin.classList.add(theme);
    }
    // if customer login is present
    if(fjCustomerLogin) {
      // set a random color other then the colorClass
      colorCopy = true_colors.slice(0);
      doClasses(fjCustomerLogin, colorCopy, true);
      colorCopy.splice(colorCopy.indexOf(theme), 1);
      theme = colorCopy[Math.floor(Math.random() * colorCopy.length)];
      fjCustomerLogin.classList.add(theme);
    }
  }
}

function undoTheme(event) {
  if(page_theme) {
    localStorage.setItem('page_color', page_theme);
  } else {
    localStorage.setItem('page_color', 'cyan');
  }
  loadTheme();
  // TODO to hide the snackbar for now
};

function saveTheme(theme) {
  page_theme = localStorage.getItem('page_color');
  localStorage.setItem('page_color', theme);
  loadTheme();
  var $toastContent = $('<span class="fj-snackbar">Theme changed<a class="waves-effect waves-light btn-flat fj-undo-theme">Undo</a></span>');
  Materialize.toast($toastContent, 9000);
}