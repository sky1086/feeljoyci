<?php 
$assetPath = base_url().'assets/clicks/';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <title>Feeljoy</title>
    <meta name="author" content="Puranjay Jain"/>
    <meta name="theme-color" content="#455A64">
    <meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="white">
<meta name="apple-mobile-web-app-title" content="Feeljoy">
<link rel="apple-touch-icon" href="<?php echo $assetPath;?>img/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo $assetPath;?>img/apple-touch-icon-57x57.png"/>
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $assetPath;?>img/apple-touch-icon-114x114.png"/>
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $assetPath;?>img/apple-touch-icon-72x72.png"/>
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $assetPath;?>img/apple-touch-icon-144x144.png"/>
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo $assetPath;?>img/apple-touch-icon-60x60.png"/>
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo $assetPath;?>img/apple-touch-icon-120x120.png"/>
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo $assetPath;?>img/apple-touch-icon-76x76.png"/>
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo $assetPath;?>img/apple-touch-icon-152x152.png"/>
<link rel="icon" type="image/png" href="<?php echo $assetPath;?>img/favicon-196x196.png" sizes="196x196"/>
<link rel="icon" type="image/png" href="<?php echo $assetPath;?>img/favicon-96x96.png" sizes="96x96"/>
<link rel="icon" type="image/png" href="<?php echo $assetPath;?>img/favicon-32x32.png" sizes="32x32"/>
<link rel="icon" type="image/png" href="<?php echo $assetPath;?>img/favicon-16x16.png" sizes="16x16"/>
<link rel="icon" type="image/png" href="<?php echo $assetPath;?>img/favicon-128.png" sizes="128x128"/>
<meta name="application-name" content="Feeljoy"/>
<meta name="msapplication-TileColor" content="#fff"/>
<meta name="msapplication-TileImage" content="<?php echo $assetPath;?>img/mstile-144x144.png"/>
<meta name="msapplication-square70x70logo" content="<?php echo $assetPath;?>img/mstile-70x70.png"/>
<meta name="msapplication-square150x150logo" content="<?php echo $assetPath;?>img/mstile-150x150.png"/>
<meta name="msapplication-wide310x150logo" content="<?php echo $assetPath;?>img/mstile-310x150.png"/>
<meta name="msapplication-square310x310logo" content="<?php echo $assetPath;?>img/mstile-310x310.png"/>
    <link rel="stylesheet" href="<?php echo $assetPath;?>css/fj.css">
    <link rel="manifest" href="<?php echo $assetPath;?>manifest.json">
    <script src="<?php echo $assetPath;?>js/modernizr.js"></script>
  </head>
  <body>
    <div id="fj-layout" class="mdl-layout mdl-js-layout mdl-layout--fixed-header fj-layout">
      
      
  <header id="fj-main-header" class="mdl-layout__header mdl-layout__header--seamed fj-main-header ">
    <div class="mdl-layout__header-row">
      
        <div class="mdl-layout-spacer"></div>
      
      <div id="fj-header-title" class="mdl-layout-title fj-header-title"></div>
      <div id="fj-header-logo" class="fj-header-logo fj-fade-down">
        <img src="<?php echo $assetPath;?>svg/feeljoy.svg" alt="logo"/>
      </div>
      <div class="mdl-layout-spacer"></div>
      <button id="fj-icon-hamburger" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect fj-icon-hamburger fj-toolbar-button" data-icon-name="hamburger"></button>
    </div>
  </header>

      <div id="fj-cover-header" class="fj-cover-header">
  <button id="fj-home-button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect fj-icon fj-toolbar-button">
    <i class="icon-home"></i>
  </button>
  <div id="fj-cover-progress" class="mdl-progress mdl-js-progress fj-cover-progress"></div>
  <button id="fj-info-button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect fj-icon fj-toolbar-button">
    <i class="icon-info_outline"></i>
  </button>
  <button id="fj-share-button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect fj-icon fj-toolbar-button">
    <i class="icon-share"></i>
  </button>
</div>
      <nav id="fj-float-menu" class="fj-float-menu"></nav>
      <div id="fj-nav-info" class="fj-nav-info mdl-shadow--2dp is-hidden">
  <button id="fj-navback-button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect fj-icon fj-toolbar-button">
    <i class="icon-arrow_back"></i>
  </button>
  <div id="fj-nav-breadcrumbs" class="mdl-typography--subhead mdl-typography--text-uppercase fj-nav-breadcrumbs">
  </div>
</div>
      <main id="fj-main-content" class="mdl-layout__content fj-main-content">
        <div id="fj-content-loading" class="fj-content-loading visible">
          <div id="fj-loader-circular" class="mdl-spinner mdl-spinner--single-color mdl-js-spinner fj-loader-circular is-active"></div>
          <button id="fj-retry-loader" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent fj-retry-loader is-hidden">
            Retry
          </button>
        </div>
        <div id="fj-inner-content" class="page-content fj-inner-content is-hidden"></div>
      </main>
      
      
  <div id="fj-main-menu" class="fj-main-menu mdl-shadow--3dp">
    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
      <div class="mdl-tabs__tab-bar">
        <a href="#menu-panel" class="mdl-tabs__tab fj-main-tab is-active">Menu</a>
        
          <a href="#chat-panel" class="mdl-tabs__tab fj-main-tab">Chat</a>
        
      </div>
      <div class="mdl-tabs__panel is-active" id="menu-panel">
        <nav>
          <ul>
            <li>Menu</li>
            <li>Items</li>
            <li>Are</li>
            <li>Here</li>
          </ul>
        </nav>
        
      </div>
      
        <div class="mdl-tabs__panel" id="chat-panel">
          <div class="fj-chat-placeholder">
            <img src="<?php echo $assetPath;?>img/chat-placeholder.png" alt="chat-placeholder">
            <h6>Hold on, we'll soon have a buddy for you to help</h6>
            <h6>Meanwhile, you can view our
              <a href="#">self help guide</a>
              to help you prepare</h6>
          </div>
        </div>
      
    </div>
  </div>

    </div>
    <div id="fj-animation-container" class="fj-animation-container"></div>
    <div id="fj-float-container" class="fj-float-container is-hidden is-nodisplay">
  <div class="fj-fab-container">
    <div class="fj-tooltext">
      Quality Space
    </div>
    <a href="//feeljoy.in/user/topics" id="fj-qs-button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect fj-qs-button">
      <i class="icon-mat"></i>
    </a>
  </div>
  <div class="fj-fab-container">
    <div class="fj-tooltext">
      Talk to a buddy
    </div>
    <a href="listeners.html" id="fj-ttab-button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect fj-ttab-button">
      <i class="icon-chat"></i>
    </a>
  </div>
  <button id="fj-diversion-button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect fj-diversion-button animate">
    <i class="icon-diverse"></i>
  </button>
</div>
    <script src="<?php echo $assetPath;?>js/fj.js"></script>
    <script>
      if ("serviceWorker" in navigator) {
        navigator.serviceWorker.register("<?php echo $assetPath;?>service-worker.js").then(function (reg) {}).catch(function (err) {});
      }
    </script>
  </body>
</html>