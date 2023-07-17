var link = document.createElement('link');

const linkFrom = '../../Asset/css_temporaire/';


var cssFiles = [
    'Backtotop',
    'Button',
    'Breadcrumb',
    'ButtonGroup',
    'Captcha',
    'Card',
    'Chips',
    'Header',
    'Icon',
    'Link',
    'Loader',
    'Modal',
    'Notification',
    'Tooltip',
    'Typography',
    'Accordions', 
    'Footer', 
    'Tabs',
    'FormInputs',
    'Connexion-module',
    'Cookie',
    'Grid',
    'ActionsBanner',
    'FilterModule' ,
    'SearchResultTemplate',
    'collectionCards'
  ];
  
  var headElement = document.head;
  
  cssFiles.forEach(function(cssFile) {
    var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = linkFrom + cssFile + '-temp.css';
    headElement.appendChild(link);
  });