require("spectrum-colorpicker/spectrum.js");
require('./color-picker');

require("materialize-css/js/initial.js");
require("materialize-css/js/jquery.easing.1.4.js");
require("materialize-css/js/animation.js");
require("materialize-css/js/velocity.min.js");
require("materialize-css/js/hammer.min.js");
require("materialize-css/js/jquery.hammer.js");
require("materialize-css/js/global.js");
//require("materialize-css/js/collapsible.js");
require("materialize-css/js/dropdown.js");
require("materialize-css/js/modal.js");
//require("materialize-css/js/materialbox.js");
//require("materialize-css/js/parallax.js");
require("materialize-css/js/tabs.js");
require("materialize-css/js/tooltip.js");
require("materialize-css/js/waves.js");
//require("materialize-css/js/toasts.js");
require("materialize-css/js/sideNav.js");
//require("materialize-css/js/scrollspy.js");
require("materialize-css/js/forms.js");
require("materialize-css/js/slider.js");
//require("materialize-css/js/cards.js");
require("materialize-css/js/chips.js");
//require("materialize-css/js/pushpin.js");
require("materialize-css/js/buttons.js");
require("materialize-css/js/transitions.js");
//require("materialize-css/js/scrollFire.js");
require("materialize-css/js/date_picker/picker.js");
require("materialize-css/js/date_picker/picker.date.js");
require("materialize-css/js/date_picker/picker.time.js");
require("materialize-css/js/character_counter.js");
//require("materialize-css/js/carousel.js");
require("materialize-css/js/tapTarget.js");

require('./switch');
require('./delete');
require('./page');
require('./propertyUpdater.js');
require('./module.js');
require('./editor.js');
require('./modal.js');

// collection
import {initCollection} from './collection';

(function(){
  "use strict";

  // admin navigation
  $('#admin .button-collapse').on('click', (e) => {
    e.preventDefault();
  });

  if($( window ).width() < 993) {
    $("#admin .button-collapse").sideNav({
      draggable: false
    });
  }

  // form select
  $('select').material_select();

  // form error
  if($('form div.errors').length) {
    let input = $('form div.errors').closest('div.input-field').find('input');
    input.addClass('invalid');
    input.prop("aria-invalid", "true");
  }

  // init collections
  if($('.collection-container').length){
    let containers = $('.collection-container');
    $.each(containers, function(index, val){
      initCollection.apply($(val), [{
        max: Number($(val).data('max')),
        afterAdd: function() {
          $('select').material_select();
        }
      }]);
    });
  }


})();
