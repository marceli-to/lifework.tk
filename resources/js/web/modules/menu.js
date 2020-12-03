var Menu = (function() {
	
	// selectors
	var selectors = {
    html:     'html',
    body:     'body',
    menu:     '.js-menu',
    menuWrap: '.js-menu-wrap',
    menuBtn:  '.js-menu-btn',
	};

  // css classes
  var classes = {
    active:   'is-active',
    visible:  'is-visible',
    hidden:   'is-hidden',
    open:     'is-open',
    hasMenu:  'has-menu',
  };

  // Init
  var _initialize = function() {
    _bind();
  };

  // Bind events
  var _bind = function() {
    $(selectors.body).on('click', selectors.menuBtn, function(){
      _toggle($(this));
    });
  };

  var _toggle = function() {
    $(selectors.menu).toggleClass(classes.visible);
    $(selectors.menuBtn).toggleClass(classes.active);
    $(selectors.menuWrap).toggleClass(classes.hasMenu);
  };

  /* --------------------------------------------------------------
    * RETURN PUBLIC METHODS
    * ------------------------------------------------------------ */

  return {
    init:  _initialize,
  };
	
})();

// Initialize
$(function() {
  Menu.init();
});

