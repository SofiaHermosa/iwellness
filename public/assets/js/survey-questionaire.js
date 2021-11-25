let valid = true;
(function (global, factory) {
    if (typeof define === "function" && define.amd) {
      define("/forms/wizard", ["jquery", "Site"], factory);
    } else if (typeof exports !== "undefined") {
      factory(require("jquery"), require("Site"));
    } else {
      var mod = {
        exports: {}
      };
      factory(global.jQuery, global.Site);
      global.formsWizard = mod.exports;
    }
  })(this, function (_jquery, _Site) {
    "use strict";
  
    _jquery = babelHelpers.interopRequireDefault(_jquery);
  
    (function () {
      var defaults = Plugin.getDefaults("wizard");
  
      var options = _jquery.default.extend(true, {}, defaults, {
        step: '.wizard-pane',
        onInit: function onInit() {
          this.$progressbar = this.$element.find('.progress-bar').addClass('progress-bar-striped');
        },
        onBeforeShow: function onBeforeShow(step) {
            step.$element.tab('show');
        },
        onFinish: function onFinish() {
          this.$progressbar.removeClass('progress-bar-striped').addClass('progress-bar-success');
          $('#surveyForm').submit();
        },
        
        onAfterChange: function onAfterChange(prev, step) {
            var total = this.length();
            var current = step.index + 1;
            var percent = current / total * 100;
            this.$progressbar.css({
                width: percent + '%'
            }).find('.sr-only').text(current + '/' + total);
        },
        buttonsAppendTo: '.panel-body'
      });
  
      (0, _jquery.default)("#exampleWizardProgressbar").wizard(options);

    })(); // Example Wizard Tabs
    // -------------------
});  