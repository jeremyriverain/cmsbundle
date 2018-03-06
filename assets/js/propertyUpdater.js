(function(){
    if($('#property-updatable').length){
        let container = $("#property-updatable");
        container.on('change', 'input.updatable-item', function(ev){
            
            ev.preventDefault();

            let input = $(this); 

            let namespace = input.data('namespace');
            let id = input.data('id');
            let method = input.data('method');

            $.ajax({
                url: $(this).closest('form').attr('action'),
                method: 'POST',
                data: {
                    namespace: namespace,
                    id: id,
                    method: method,
                    value: $(this).val()
                },
                success: function(response) {
                    if(response.success === true){
                        console.log(response);
                        document.location.reload(); 
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

})();
