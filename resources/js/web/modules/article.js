var Article = (function() {
	
	// selectors
	var selectors = {
    html: 'html',
    body: 'body',
    btn:  '.js-btn-article',
  };
  
  // Init
  var _initialize = function() {
    _bind();
  };

  // Classes
  var classes = {
    active: 'is-active',
    visible: 'is-visible',
    hidden: 'is-hidden',
  };

  // Bind events
  var _bind = function() {
    $(selectors.body).on('click', selectors.btn, function(){
      _toggle($(this));
    });
  };

  var _toggle = function(el) {
    el.parents('article').find('.' + classes.hidden).toggleClass(classes.visible);
    el.parents('article').find('a.btn-arrow').toggleClass(classes.active);
  };

  return {
    init: _initialize,
  };
	
})();

// Initialize
$(function() {
  Article.init();
});

