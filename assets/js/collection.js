"use strict";

var elementClass, items, collectionContainer, formPrototype, length, max, namespace;
var upArrow = `<a href="#" class="sortable-action up"><i class="material-icons">arrow_upward</i></a>`;
var downArrow = `<a href="#" class="sortable-action down"><i class="material-icons">arrow_downward</i></a>`;

var initCollection = function(options) {
  elementClass = '.item-collection';
  collectionContainer = $(this);
  items = $(collectionContainer).find(elementClass);
  formPrototype = $(this).attr('data-prototype');
  length = items.length;
  max = null;

  if(Number.isInteger(options.max)){
    if(options.max > 0){
      max = options.max;
    }
  }

  handleAddButton();
  handleRemoveButtons(collectionContainer); 
  handlePositionButtons();

  $(collectionContainer).on('click', 'a.collection-action.remove', function(e){
    e.preventDefault();
    collectionContainer = $(this).closest('.collection-container');
    handleRemoval($(this).closest(elementClass));
    items = $(e.currentTarget).closest(elementClass).find(elementClass);
    length = items.length;
    handleAddButton();
    handlePositionButtons();
  });

  $(collectionContainer).on('click', 'div.collection-action.add', function(e){

    collectionContainer = $(this).closest('.collection-container');
    e.preventDefault();
    addForm($(this));

    items = $(elementClass);
    length = items.length;

    handleAddButton($(this));
    handlePositionButtons();
    handleRemoveButtons(collectionContainer);

    callbackAfterAdd(options.afterAdd);
  });

  $(this).on('click', '.sortable-action.up', function(e){
    e.preventDefault();
    upAction($(this).closest(elementClass));    
  });

  $(this).on('click', '.sortable-action.down', function(e){
    e.preventDefault();
    downAction($(this).closest(elementClass));    
  });

};

var callbackAfterAdd = function(method = null) {
  if(typeof method === "function") {
    method();
  }
};

var handlePositionButtons = function() {
  if ($(collectionContainer).hasClass('sortable-container')) {
    $(collectionContainer).find('.sortable-action').remove(); 
    $.each(items.filter('.sortable-item'), function(index, value){
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

var upAction = function(item) {
  let prev = $(item).prev(elementClass);
  item.insertBefore(prev);
  items = $(elementClass);
  handlePositionButtons();
  updatePosition();
};

var downAction = function(item) {
  let next = $(item).next(elementClass);
  item.insertAfter(next);
  items = $(elementClass);
  handlePositionButtons();
  updatePosition();
};

var updatePosition = function() {
  if(Boolean($(collectionContainer).data('collection-sf')) === true) {
    let re = /\[([0-9]+)\]/;
    $.each(items, function(index, value){
      $.each($(value).find('select, input'), function(i, v) {
        let str = $(v).attr('name');
        if (str !== undefined) {
          let newstr = str.replace(re, `[${index}]`);
          $(v).attr('name', newstr);
        }
      });
    });
  }
  else {
    let data = [];
    $.each(items, function(index, value){
      let exPosition = Number($(value).attr('data-collection-position'));
      $(value).attr('data-collection-position', index);
      data.push({
        id: $(value).data('collection-id'),
        position: index
      }); 

    });

    namespace = $(collectionContainer).data('collection-namespace');
    if(namespace === null || namespace === undefined){
      throw "Le namespace de l'entité n'a pas été renseigné";
    }


    $.ajax({
      url: "/admin/ajax/position",
      method: 'POST',
      data: {
        namespace: namespace,
        items: data
      },
      success: function(response) {
        console.log(response);
      }
    });

  }
};

var handleAddButton = function(addButton = null){
  if(max !== null){
    if(length >= max){
      if(addButton !== null) {
        $(addButton).remove();
      }
      else {
        $(collectionContainer).find('.collection-action.add').remove();
      }
    }
    else
    {
      if(!$(collectionContainer).find('div.collection-action.add').length){
        let label = $(collectionContainer).data('add-label') || 'ajouter';
        let template = `<div class="mt-1 collection-action add" id="${(new Date().getTime()).toString(16)}">
<a class="success-color-bg waves-effect waves-light btn light-green accent-2 off-black-text"><i class="material-icons left off-black-text">playlist_add</i>${label}</a>
</div>`;
        $(collectionContainer).append(template);
      }
    }
  }
};

var addForm = function(addButton){
  formPrototype = $(addButton).closest('.collection-container').data('prototype');
  let newForm = formPrototype.replace(/__name__/g, `${length}`);
  let hasElementClass = newForm.search('item-collection') === -1 ? false : true;
  if(!hasElementClass){
    newForm = "<div class='item-collection'>" + newForm + "</div>";
  }
  $(newForm).insertBefore(addButton);

};

var handleRemoval = function(elementContainer){
  elementContainer.remove();
};

var handleRemoveButtons = function(collectionContainer) {
  if(Boolean($(collectionContainer).data('collection-deletable')) === false && $(collectionContainer).data('collection-deletable') !== undefined) {
    return;
  } 
  else {
    $.each(collectionContainer.find('.item-collection'),function(index, item) {
      $(item).find('.collection-action').remove();
      addRemoveButton(item);
    });

  }
};

var addRemoveButton = function(item) {
  let wrapper, removeButton;
  wrapper = $("<p class=''></p>");
  removeButton = "<a href='' class='collection-action remove'><i class='red-text material-icons'>delete</i></a>";
  $(wrapper).append(removeButton);
  $(item).prepend(wrapper);
};

export {initCollection};

