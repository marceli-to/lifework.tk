import debounce from '../vendor/debounce';

var Circles = (function() {
	
	// Selectors
	var selectors = {
    html: 'html',
    body: 'body',
  };

  // Classes
  var classes = {
    visible: 'is-visible'
  };

  // Current tick
  var tick = 1;

  // Maximum ticks
  var maxTicks = 4;

  // State
  var isRunning = false;

  // Types
  var types = [
    'ol', 'or', 'ur', 'ul'
  ];

  // Interval in ms
  var interval = 2000;

  // Pause in ms
  var pause = 250;

  // Init
  var _initialize = function() {
    _bind();
  };

  // Events
  var _bind = function() {
    $(selectors.body).mousemove(function(e){
      _initAnimation(e.pageX, e.pageY);
    });

    // $(selectors.body).click(function(){
    //   if (!isRunning) {
    //     _initPartsAnimation();
    //   }
    // });
  };

  var _initAnimation = debounce(function(x,y) {
    var pos = _getMousePosition(x,y);
    switch(pos) {
      case 'tl':
        _animate(1);
      break;
      case 'tr':
        _animate(3);
      break;
      case 'bl':
        _animate(4);
      break;
      case 'br':
        _animate(2);
      break;
    }
  }, 0);

  var _animate = function(figure) {
    $('[data-figure]').removeClass(classes.visible);
    $('[data-figure="'+figure+'"]').addClass(classes.visible);
  };

  var _initPartsAnimation = function() {
    isRunning = true;
    setInterval(function(){
    _animateParts();
    }, interval);
  };

  async function _animateParts() {
    tick = tick < maxTicks ? tick + 1 : 1;
    for(var i=0; i<types.length; i++) {
      $('[data-shape-type="'+types[i]+'"]').removeClass(classes.visible);
      $('[data-shape-type="'+types[i]+'"][data-figure="'+tick+'"]').addClass(classes.visible);
      await _sleep(pause);
    }
  };

  var _sleep = function(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  };

  var _getMousePosition = function(x,y) {
    if (y > $(window).height()/2) {
      if (x > $(window).width()/2) {
        return 'br';
      }
      else {
        return 'bl';
      }
    }
    else {
      if (x > $(window).width()/2) {
        return 'tr';
      }
      else {
        return 'tl';
      }
    }
  };

  return {
    init: _initialize,
  };
	
})();

// Initialize
$(function() {
  Circles.init();
});
