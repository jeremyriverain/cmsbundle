$(document).ready(function(){
    $(document ).on('click', 'input[type=checkbox].switch-action', function(e) {
        let input = $(this);
        let value = input.prop('checked');
        let namespaceParent = input.attr('data-namespaceParent');
        let id = input.attr('data-id');
        let method = input.attr('data-method');
        let url = input.attr('data-url');

        if(value === undefined || url === undefined || namespaceParent === undefined || id === undefined || method === undefined){
            e.preventDefault();
            throw new Error("Il manque un paramètre pour la requête ajax.");
        }

        $.ajax({
            url: url,
            method: "POST",
            data: {
                method: method,
                namespaceParent: namespaceParent,
                id: id,
                value: value
            },
            success: function(response) {
                if(response.success === false){
                    input.prop('checked', !value);
                }

                console.log(response);
            },
            error: function(response) {
                e.preventDefault();
            }
        });
    });
});
