import getLoader from './loader';
import {updateInstances} from './ckeditor';

(function(){
"use strict";  

  // clone children module
  $(document).on('click', '#copy-child', function(e){
    let btn = $(this);
    e.preventDefault();
    $(this).replaceWith(`<div>${getLoader()}</div>`);

    $('form#form-update-module').submit(function(ev){
      ev.preventDefault();

      if($('.textarea-ckeditor.html').length) {
      updateInstances();
      }


      $.post(document.URL, $(this).serialize(), function(json) {
        if(json.success === true){

          let name = $(btn).data('name');
          let original = $(btn).data('original');
          $.ajax({
            url: "/admin/module/clone-child",
            method: "POST",
            data: {
              name: name,
              original: original
            },
            success: function(response) {
              if(response.success === true){
                document.location.reload(); 
              }
              else
              {
              console.log(response);
              }
            }
          });

        }
      }, 'json');
      return false;
    });

    $('form#form-update-module').submit();
  });

  // position module

  var upArrow = `<a href="#" class="sortable-action up "><i class="material-icons">arrow_upward</i></a>`;
  var downArrow = `<a href="#" class="sortable-action down"><i class="material-icons ">arrow_downward</i></a>`;
  var moduleContainer = $('.children-module-container');
  var length, childrenContainers;

  var handlePositionButtons = function(){
    if($(moduleContainer).data('positionable') === true){
      childrenContainers = $(moduleContainer).find('.sub-module');
      length = $(childrenContainers).length;
      $(childrenContainers).find('.sortable-action').remove();
      $.each(childrenContainers, function(index, value){
        let content = "";
        if(index !== 0) {
          content += upArrow;
        }
        if (index !== length -1) { 
          content += downArrow;
        }
        $(value).append(`<div class="">${content}</div>`);

      });
    }
  };

  var modifyPosition = function(){
    $.each(childrenContainers, function(index, value){
      let inputs = $(value).find('[name]');
      $.each(inputs, function(nest_index, nest_value){
        let currentName = $(nest_value).attr('name');
        let newName = currentName.replace(/(\[\d+\])/, `[${index}]`);
        $(nest_value).attr('name', newName);
      });
    });
  };

  var upAction = function(item) {
    let prev = $(item).prev('.sub-module');
    item.insertBefore(prev);
    childrenContainers = $(moduleContainer).find('.sub-module');
    handlePositionButtons();
    modifyPosition();
  };

  var downAction = function(item) {
    let next = $(item).next('.sub-module');
    item.insertAfter(next);
    childrenContainers = $(moduleContainer).find('.sub-module');
    handlePositionButtons();
    modifyPosition();
  };

  if ($(moduleContainer).length) {
    handlePositionButtons();

    $(moduleContainer).on('click', '.sortable-action.up', function(e){
      e.preventDefault();
      upAction($(this).closest('.sub-module'));    
    });

    $(moduleContainer).on('click', '.sortable-action.down', function(e){
      e.preventDefault();
      downAction($(this).closest('.sub-module'));    
    });

  }
})();


