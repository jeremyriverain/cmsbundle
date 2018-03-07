import ClassicEditor from 'ck5-custom-build';

let els = document.querySelectorAll( '.textarea-ckeditor.html' );

let instances = [];

els.forEach(function(el){
  
ClassicEditor
    .create( el, {
        } )
    .then( editor => {
            console.log( 'Editor was initialized', editor );
        } )
    .catch( error => {
            console.error( error.stack );
        } );


});

//console.log(instances);

function updateInstances() {
  instances.forEach(function(el){
    let textarea = $("#" + el.element.attributes.id.nodeValue);
    if(!textarea.length) {
      throw "L'élement se rapportant à l'instance de ckeditor n'a pas été trouvée et ne peut donc pas être rafraîchi.";
    }
    textarea.val(el.getData());
  });
}

export {updateInstances};
