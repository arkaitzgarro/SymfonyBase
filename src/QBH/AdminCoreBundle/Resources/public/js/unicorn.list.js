$(document).ready(function() {
    $('#list_batch_checkbox').on('ifToggled', function(e) {
        var $this = $(this);
        $this
            .closest('table')
            .find("td input[type='checkbox']").each(function(){
                if($this.is(':checked')) {
                    $(this).iCheck('check').attr('checked', true);
                } else {
                    $(this).iCheck('uncheck').attr('checked', false);
                }
            });
    });

    $('input[type=checkbox],input[type=radio]').iCheck({
        checkboxClass: 'icheckbox_minimal-grey',
        radioClass: 'iradio_minimal-grey'
    });

    $('select.per-page').change(function(event) {
        $('input[type=submit]').hide();

        window.top.location.href=this.options[this.selectedIndex].value;
    });
    
    $('select:not(.raw)').select2();

    $(document).on('click', '.x-editable', function(e) {
        e.preventDefault();
        
        var $this = $(this);

        var jqxhr = $.post(
            $this.data('url'),
            {value : $this.data('value')},
            function(response) {
                if('KO' === response.status) {
                    alert(response.message);
                    return false;
                }

                var html = $(response.content);
                $this
                    .closest('td')
                    .replaceWith(html)
                ;
            }
        ).fail(function(jqXHR, textStatus, errorThrown){
            alert("Error al realizar la petición: " + textStatus);
        });
    });
});