import getLoader from './loader';
import {updateInstances} from './ckeditor';

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
          console.log(response);
            if(response.success === true)
            {
                document.location.reload(); 
            }

            else{
                alert(failMsg);
                console.log(response);
            }
        }
    });
};

(function(){
    $(document).on('click', 'a.delete-action', function(e){
        e.preventDefault();    
        let ask = confirm("Etes de vous sûr de vouloir supprimer ?");


        if(ask)
        {

      if($('.textarea-ckeditor.html').length) {
      updateInstances();
      }
            
            let url = $(this).attr('data-url');
            let id = $(this).attr('data-id');
            let namespace = $(this).attr('data-namespace');

            if(url === undefined || id === undefined || namespace === undefined){
                alert(failMsg);
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
        }
    });
})();
