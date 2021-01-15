var Article = (function() {
	
	// selectors
	var selectors = {
    html: 'html',
    body: 'body',
    btnArticle: '.js-btn-article',
    btnForm: '.js-btn-form',
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
    $(selectors.body).on('click', selectors.btnArticle, function(){
      _toggleArticleContent($(this));
    });

    $(selectors.body).on('click', selectors.btnForm, function(){
      _toggleArticleForm($(this));
    });
  };

  var _toggleArticleContent = function(el) {
    el.parents('article').find('div.' + classes.hidden).toggleClass(classes.visible);
    el.parents('article').find('a.btn-arrow').toggleClass(classes.active);
    if (!el.parents('article').find('a.btn-arrow').hasClass(classes.active)) {
      _hideArticleForm(el);
    }
  };

  var _toggleArticleForm = function(el) {
    el.parents('article').find('.event-form.' + classes.hidden).toggleClass(classes.visible);
    el.parents('article').find(selectors.btnForm).closest('div').hide();
    if (el.parents('article').find('.event-form').hasClass(classes.visible)) {
      var form = $(el.parents('article').find('.event-form'))[0];
      form.scrollIntoView();
    }
  };

  var _hideArticleForm = function(el) {
    el.parents('article').find('.event-form.' + classes.hidden).removeClass(classes.visible);
    el.parents('article').find(selectors.btnForm).closest('div').show();
  };

  return {
    init: _initialize,
  };
	
})();

// Initialize
$(function() {
  Article.init();
});

