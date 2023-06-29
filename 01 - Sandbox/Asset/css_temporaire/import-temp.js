var link = document.createElement('link');

const linkFrom = '../../Asset/css_temporaire/';


var cssFiles = [
    'backtotop',
    'Boutons',
    'breadcrumb',
    'ButtonGroup',
    'captcha',
    'card',
    'chips',
    'collectioncards',
    'formm_test',
    'Header_et_plus',
    'header',
    'Icon',
    'lien',
    'loader',
    'Modal',
    'notification',
    'test',
    'Toggle',
    'tooltip',
    'typography',
    'Accordion', 
    'footer', 
    'onglet'
  ];
  
  var headElement = document.head;
  
  cssFiles.forEach(function(cssFile) {
    var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = linkFrom + cssFile + '-temp.css';
    headElement.appendChild(link);
  });