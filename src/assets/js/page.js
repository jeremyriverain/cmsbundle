import getLoader from './loader';

(function(){

  if($('#page-updatable').length){
    let container = $("#page-updatable");
    container.on('change', 'input.page-name', function(ev){
      ev.preventDefault();

      let input = $(this);

      $.ajax({
        url: $(this).closest('form').attr('action'),
        method: 'POST',
        data: {
          name: $(this).val()
        },
        success: function(response) {
          if(response.success === true){
            let url = location.protocol + '//' + location.host + location.pathname;
            document.location.href = url + '?orderby=updated&direction=desc';
          }
          else {
            let containerError = $('<div class="red-text text-darken-1 errors mb-1"></div>');
            $.each(response.errors, function(index, val){
              containerError.append(val + '<br>');
            });
            containerError.insertAfter(input);
          }
        }
      });
    });
  }

  if ($(".module-adder").length) {
    $(".module-adder").on('click', '.module-item', function(){

      let container = $(this).closest('.module-adder');
      let divLoader = `<div class="d-f jc-c">${getLoader()}</div>`;
      let pageId = $(this).data('page-id');
      let moduleId = $(this).data('module-id');

      $(container).css({opacity:0});
      $(divLoader).insertAfter(container);


      $.ajax({
        url: "/admin/page/ajouter-module",
        method: 'POST',
        data: {
          pageId: pageId,
          moduleId: moduleId
        },
        success: function(response) {
          if (response.success === true) {
            document.location.reload();
          }
          else
          {
            $(container).next().remove();
            $(container).css({opacity:1});
            alert(response.message);
          }
        }
      });
    });
  }


  // chips
  $.each($('.chips-placeholder'), function(idx, val){
    if($(val).data('has-tags') === true) {
      $.ajax({
        url: `/admin/page/get-tags/${$(val).data('id')}`,
        success: (response) => {
          let data = [];
          for (let i = 0; i < response.length; i++) {
            data.push({tag: response[i]});
          }
          $(val).material_chip({
            data: data,
            placeholder: 'Ajouter 1 tag',
            //secondaryPlaceholder: '+Tag',
          });
        }
      });
    } else {
      $(val).material_chip({
        placeholder: 'Ajouter 1 tag',
        //secondaryPlaceholder: '+Tag',
      });
    }
  });

  $('.chips-placeholder').on('chip.add', function(e, chip){
    addTagToPage(e, chip);
  });

  $('.chips-placeholder').on('chip.delete', function(e, chip){
    removeTagFromPage(e, chip);
  });

  function addTagToPage(e, chip) {
    $.ajax({
      url: `/admin/page/tag/${$(e.currentTarget).data('id')}`,
      method: 'POST',
      data: {
        value: chip.tag
      },
      success: function(response) {
        console.log(response);
      }
    });
  }

  function removeTagFromPage(e, chip) {
    $.ajax({
      url: `/admin/page/tag/${$(e.currentTarget).data('id')}`,
      method: "DELETE",
      data: {
        value: chip.tag
      },
      success: function(response) {
         console.log(response);
      }
    });
  }


})();


