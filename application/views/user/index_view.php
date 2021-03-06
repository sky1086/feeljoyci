<?php 
$assetPath = base_url().'assets/home/';
include_once 'index.html';
?>
<!-- DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <title>Feeljoy - Welcome customers</title>
    <meta name="author" content="Puranjay Jain"/>
    <meta name="theme-color" content="#0097A7">
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
    <link rel="stylesheet" href="<?php echo $assetPath;?>css/customer.css">
    <script src="<?php echo $assetPath;?>js/modernizr.js"></script>
  </head>
  <body>
    <div id="fj-layout" class="mdl-layout mdl-js-layout mdl-layout--fixed-header fj-layout">
      
      
  <header id="fj-main-header" class="mdl-layout__header mdl-layout__header--seamed fj-main-header mdl-shadow--2dp">
    <div class="mdl-layout__header-row">
      
      <div id="fj-header-title" class="mdl-layout-title fj-header-title">FeelJoy</div>
      <div id="fj-header-logo" class="fj-header-logo fj-fade-down">
        <img src="<?php echo $assetPath;?>svg/feeljoy.svg" alt="logo"/>
      </div>
      <div class="mdl-layout-spacer"></div>
      <button id="fj-icon-hamburger" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect fj-icon-hamburger fj-toolbar-button" data-icon-name="hamburger"></button>
    </div>
  </header>

      <main id="fj-main-content" class="mdl-layout__content fj-main-content">
        <div id="fj-content-loading" class="fj-content-loading">
          <div id="fj-loader-circular" class="mdl-spinner mdl-spinner--single-color mdl-js-spinner fj-loader-circular"></div>
          <button id="fj-retry-loader" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent fj-retry-loader is-hidden">
            Retry
          </button>
        </div>
        <div id="fj-inner-content" class="page-content fj-inner-content">
          <section class="fj-customer-section color">
            <img class="fj-customer-logo" src="<?php echo $assetPath;?>svg/feeljoy.svg" alt="logo"/>
            <h4>Lead the life you deserve</h4>
            <h6>Online support that provides effective solutions for emotional well-being</h6>
            <button id="fj-customer-login" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect fj-customer-login">
              GET STARTED
            </button>
            <button id="fj-down-button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect fj-icon fj-toolbar-button fj-down-button">
              <i class="icon-expand_more"></i>
            </button>
          </section>
          <section class="fj-customer-section fj-section-2">
            <h5 class="fj-inner-h5">Deal with your problems, Judgment-Free</h5>
            <p class="fj-inner-p is-padded">Struggling with something specific or just looking for a boost, FeelJoy will help you approach life with strength, clarity and calm.</p>
            <div class="fj-pointer-item">
              <i class="icon-about-icon fj-icon-color"></i>
              <div class="fj-pointer-text">
                <h5 class="fj-pointer-title">
                  Tell us about yourself
                </h5>
                <p class="fj-pointer-subtitle">
                  Let us know about yourself and get personalized guidance from us without revealing your identity.
                </p>
              </div>
            </div>
            <div class="fj-pointer-item">
              <i class="icon-emoticon-square-smiling-face-with-closed-eyes fj-icon-color"></i>
              <div class="fj-pointer-text">
                <h5 class="fj-pointer-title">
                  Meet your buddy
                </h5>
                <p class="fj-pointer-subtitle">
                  Receive support from your buddy to keep you motivated to the finish
                </p>
              </div>
            </div>
            <div class="fj-pointer-item">
              <i class="icon-Blog-icon fj-icon-color"></i>
              <div class="fj-pointer-text">
                <h5 class="fj-pointer-title">
                  Tailored content engine
                </h5>
                <p class="fj-pointer-subtitle">
                  Get quick access to responses that help resolve your specific areas of concern
                </p>
              </div>
            </div>
            <div class="fj-pointer-item">
              <i class="icon-content fj-icon-color"></i>
              <div class="fj-pointer-text">
                <h5 class="fj-pointer-title">
                  Read our self help blog
                </h5>
                <p class="fj-pointer-subtitle">
                  Get positive tips and information that work in real life through our blog published by experts
                </p>
              </div>
            </div>
          </section>
          <section class="fj-customer-section color">
            <h5>Access FeelJoy</h5>
            <h4>anytime, anywhere</h4>
          </section>
          <section class="fj-customer-section">
            <h4>Why FeelJoy Works</h4>
            <h5>Simple and
              <span class="fj-highlight-span">
                Effective</span>
            </h5>
            <p class="fj-inner-p side-padded">
              We offer you friendly responses to your emotional concerns through our well researched and neatly structured content
            </p>
            <h5>
              We're in this
              <span class="fj-highlight-span">Together</span>
            </h5>
            <p class="fj-inner-p side-padded">
              We help you find a listening buddy that you can talk to and speak your heart out securely. Receive support and motivation from your
            </p>
            <h5>Just for
              <span class="fj-highlight-span">
                You
              </span>
            </h5>
            <p class="fj-inner-p side-padded">
              FeelJoy gives you the tools to help you in situations that matter to you. Through our structured content and self help blog, unlock skills to lead the life you want
            </p>
          </section>
          <section class="fj-customer-section color">
            <h5>We want to help you</h5>
            <h6>Start your journey with FeelJoy free of cost to live a happy, stress-free life.</h6>
            <a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect fj-start-journey">
              START MY JOURNEY
            </a>
          </section>
          <section class="fj-customer-section">
            <div class="fj-icon-header">
              <i class="icon-close-envelope fj-icon-color"></i>
              <h5>Sign up for our newsletter</h5>
            </div>
            <p class="fj-inner-p side-padded left-aligned">
              Get the latest news and information about FeelJoy and our programs.
            </p>
            <form action="#">
              <div class="fj-subscribe-container">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" id="fj-subscribe" placeholder="e.g me@feeljoy.in">
                  <label class="mdl-textfield__label" for="fj-subscribe">Your Email Address</label>
                </div>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect fj-subscribe-button">
                  Subscribe
                </button>
              </div>
            </form>
            <p class="fj-inner-p side-padded left-aligned">
              or drop us a line
              <a href="mailto:hello@feeljoy.in">hello@feeljoy.in</a>
            </p>
          </section>
          <footer class="fj-inner-footer">
            <div class="fj-footer-icons">
              <i class="icon-quora"></i>
              <i class="icon-facebook"></i>
              <i class="icon-instagram"></i>
            </div>
            <h4>FeelJoy</h4>
            <p>&copy; 2017 Feeljoy Pvt Ltd.</p>
          </footer>
        </div>
      </main>
      
      
  <div id="fj-main-menu" class="fj-main-menu mdl-shadow--3dp">
    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
      <div class="mdl-tabs__tab-bar">
        <a href="#menu-panel" class="mdl-tabs__tab fj-main-tab is-active">Menu</a>
        
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
        
          <div class="fj-palette-changer">
            <i class="icon-palette"></i>
            <i class="icon-lens cyan fj-color-swatch" data-color="cyan"></i>
            <i class="icon-lens darkcyan fj-color-swatch" data-color="darkcyan"></i>
            <i class="icon-lens darkgreen fj-color-swatch" data-color="darkgreen"></i>
            <i class="icon-lens green fj-color-swatch" data-color="green"></i>
          </div>
        
      </div>
      
    </div>
  </div>

    </div>
    <div id="fj-snackbar" class="mdl-js-snackbar mdl-snackbar fj-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-snackbar__action" type="button"></button>
</div>
    <script src=""></script>
    <script src="<?php echo $assetPath;?>js/customer.js"></script>
  </body>
</html-->