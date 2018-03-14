import getLoader from './loader';
import {createModal} from './modal';
//import {updateInstances} from './ckeditor';

var failMsg = "Impossible d'effectuer la suppression";

var $delete = function(url, id, namespace) {
  $.ajax({
    url: url,
    method: "DELETE",
    data: {
      namespace: namespace,
      id: id
    },
    success: function(response) {
      if(response.success === true)
      {
        document.location.reload(); 
      }

      else{
        createModal(`<p>${failMsg}</p>`);
        console.log(response);
      }
    }
  });
};

(function(){
  $(document).on('click', 'a.delete-action', function(e){
    let item = $(this);
    e.preventDefault();    

    var id = $(this).attr('data-id');
    createModal("<p>Êtes-vous sûr de vouloir supprimer ?</p>", id, true);

    $(`#${id}`).on('click', '.modal-action.confirm', function(){
      if($('.textarea-ckeditor.html').length) {
        //updateInstances();
      }

      let url = $(item).attr('data-url');
      let namespace = $(item).attr('data-namespace');

      if(url === undefined || id === undefined || namespace === undefined){
        createModal(`<p>${failMsg}</p>`);
        throw new Error("Il manque un paramètre pour la requête ajax.");
      }
      if($('form#form-update-module').length){
        $(this).replaceWith(`<div>${getLoader()}</div>`);

        $('form#form-update-module').submit(function(){
          $.post(document.URL, $(this).serialize(), function(json) {
            if(json.success === true){
              $delete(url, id, namespace);
            }
          }, 'json');
          return false;
        });

        $('form#form-update-module').submit();

      }
      else
      {
        $delete(url, id, namespace);
      }


    });
  });

})();
