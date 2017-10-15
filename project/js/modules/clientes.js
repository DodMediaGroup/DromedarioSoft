jQuery(document).ready(function($) {
    $('#Clientes_departamento').on('change', function(){
	    var dep = $(this).val();
	    var clients = $('#Clientes_municipio')
            .attr('disabled',true)
            .html('')
            .append('<option value="" selected="selected">No hay disponibles</option>')
            .change();
	    if($.trim(dep) != ''){
	        var url = $(this).attr('data-url-load');
            $.ajax({
                url: url,
                method: "GET",
                data: { departamento: dep },
                dataType: 'json'
            })
                .done(function( data ) {
                    if(data.length > 0){
                        clients.html('<option value="" selected="selected">--- Seleccione una opción ---</option>');
                        $.each(data, function(key, ciudad){
                            clients.append(
                                $('<option>')
                                    .attr('value', ciudad.id)
                                    .html(ciudad.nombre)
                            );
                        });
                        clients.attr('disabled',false);
                    }
                });
        }
    }).change();


    $('.btn-set-redirect').on('click', function(){
        var form = $(this).parents('#usuarios-form');
        form.attr('data-form__redirect', $(this).attr('data-redirect'));
    });
});