var queries = {},
  fjContentLoading = document.getElementById('fj-content-loading'),
  fjLoaderCircular = document.getElementById('fj-loader-circular'),
  fjRetryLoader = document.getElementById('fj-retry-loader'),
  stdEasing = 's cubic-bezier(.4, 0, .2, 1)',
  outEasing = 's cubic-bezier(.4, 0, 1, 1)',
  inEasing = 's cubic-bezier(0, 0, .2, 1)',
  querystring = '';

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

// show fj loader
function showFjLoader(justLoader) {
  if(justLoader) {
    fjContentLoading.classList.add('visible');
  }
  // clear any previous timeouts
  window.clearTimeout(timeouts.showFjLoader);
  timeouts.showFjLoader = window.setTimeout(function () {
    fjLoaderCircular.classList.add('active');
  }, 300)
}

// hide fj loader
function hideFjLoader(justLoader) {
  if(justLoader) {
    fjContentLoading.classList.remove('visible');
  }
  fjLoaderCircular.classList.remove('active');
}

// show error button
function showErrorButton(page) {
  // hide the loader
  hideFjLoader();
  // show the error button
  fjRetryLoader.classList.remove('is-hidden');
  // add button click event and remove any past events
}

// translateX helper
function getComputedTranslateX(obj) {
  if(!window.getComputedStyle) return;
  var style = getComputedStyle(obj),
    transform = style.transform || style.webkitTransform || style.mozTransform;
  var mat = transform.match(/^matrix3d\((.+)\)$/);
  if(mat) return parseFloat(mat[1].split(', ')[7]);
  mat = transform.match(/^matrix\((.+)\)$/);
  return mat ? parseFloat(mat[1].split(', ')[4]) : 0;
}

// helper set transform translate3d's y
function setTranslate3dY(el, y) {
  setTransform(el, 'translate3d(0, ' + y + ', 0)');
}

// Detect touch screen and enable scrollbar if necessary
function isTouchDevice() {
  try {
    document.createEvent("TouchEvent");
    return true;
  } catch(e) {
    return false;
  }
}

// get scroll velocity factor
// NOTE get it calculated
function getScrollVelocityFactor() {
  if(isTouchDevice()) {
    return 20;
  } else {
    return 5;
  }
}

// delete self node
// http://stackoverflow.com/questions/8830839/javascript-dom-remove-element
function deleteNode(node) {
  node.parentNode.removeChild(node);
}

// clear inner elements
function clearInner(el) {
  while(el.firstChild) el.removeChild(el.firstChild);
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

// helper add and remove multiple classes
// true to remove
function doClasses(el, classes, action) {
  for(var i in classes) {
    if(action) {
      el.classList.remove(classes[i])
    } else {
      el.classList.add(classes[i])
    }
  }
}

// get hash as array
function getHashAsArray(hash) {
  // remove query if it is present
  hash = hash.split('?');
  hash = hash[0];
  // seperate using /
  hash = hash.split('/');
  var i = hash.length;
  while(i--) {
    // remove empty
    if(hash[i] === '') {
      hash.splice(i, 1);
    }
  }
  return hash;
}

// get base url dynamically
function getBasePage() {
  var base = '',
    hash = getHashAsArray(window.location.pathname);
  for(var i in hash) {
    if(hash[i].indexOf('.html') === -1) {
      base += '/' + hash[i];
    }
  }
  if(!base) {
    base = '/';
  }
  return base;
}

// get query string as objects
function getQueryAsObjects(query) {
  query = query.split('&');
  var retQueries = {},
    q,
    i = query.length;
  while(i--) {
    if(query[i]) {
      q = query[i].split('=');
      retQueries[q[0]] = q[1];
    }
  }
  return retQueries;
}

// add querystring to url
function addQuery(query, toUrl) {
  // prefix query
  var q = query.split('='),
    noError = true;
  queries[q[0]] = q[1];
  querystring = '';
  for(var i in Object.keys(queries)) {
    if(i > 0) {
      querystring += '&';
    }
    querystring += Object.keys(queries)[i] + '=' + queries[Object.keys(queries)[i]];
  }
  if(toUrl && querystring) {
    // http://stackoverflow.com/questions/16719277/checking-if-a-variable-exists-in-javascript
    try {
      newHash;
    } catch(e) {
      noError = false;
      page('?' + querystring);
    } finally {
      if(noError) {
        page('#/' + newHash.join('/') + '?' + querystring);
      }
    }
  }
}

// remove querystring to url
function removeQuery(query, toUrl) {
  var q = query.split('=');
  // prefix query
  delete queries[q[0]];
  querystring = '';
  for(var i in Object.keys(queries)) {
    addQuery(Object.keys(queries)[i] + '=' + queries[i]);
  }
  if(toUrl) {
    page('#/' + newHash.join('/') + querystring);
  }
}

// ga tracking
(function (i, s, o, g, r, a, m) {
  i['GoogleAnalyticsObject'] = r;
  i[r] = i[r] || function () {
    (i[r].q = i[r].q || [])
    .push(arguments)
  }, i[r].l = 1 * new Date();
  a = s.createElement(o),
    m = s.getElementsByTagName(o)[0];
  a.async = 1;
  a.src = g;
  m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

ga('create', 'UA-86096862-1', 'auto');
ga('send', 'pageview');