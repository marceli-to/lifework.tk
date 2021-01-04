var Curriculum = (function() {
	
	// selectors
	var selectors = {
    html: 'html',
    body: 'body',
    btnCv: '.js-btn-cv',
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
    $(selectors.body).on('click', selectors.btnCv, function(){
      _toggle($(this));
    });
  };

  var _toggle = function() {
    
  };


  return {
    init: _initialize,
  };
	
})();

// Initialize
$(function() {
  Curriculum.init();
});

