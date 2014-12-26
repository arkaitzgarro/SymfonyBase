/**
 * Unicorn Admin Template
 * Version 2.2.0
 * Diablo9983 -> diablo9983@gmail.com
**/
$(document).ready(function(){
    'use strict';

    var $form = $('form');

    $('input[type=checkbox], input[type=radio]').iCheck({
        checkboxClass: 'icheckbox_minimal-grey',
        radioClass: 'iradio_minimal-grey'
    });

    $('select.per-page').change(function(event) {
        $('input[type=submit]').hide();

        window.top.location.href=this.options[this.selectedIndex].value;
    });

    $('select:not(.raw)').select2();
    // $('.colorpicker').colorpicker();
    // $('.datepicker').datepicker();
    // $('.spinner').spinner();

    tinymce.init({
        selector: '.tinymce',
        skin: 'flat',
        language : 'es',
        height : 400,
        toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | removeformat',
        plugins : 'paste link code table',
        paste_word_valid_elements: 'b,strong,i,em,p,h1,h2,h3,h4,h5,h6,ul,li,a'
     });

    $('[data-slug]').on('blur', function(e){
        if(this.value.length === 0) return;

        var $this = $(this),
            id = this.id.replace(/_[a-zA-Z]+$/gi, '_slug'),
            repository = $this.closest('form').data('repository'),
            locale = $this.closest('[data-locale]').data('locale'),
            $target = $('#' + id);

        if ($form.data('action') === 'create' || $target.val().length === 0) {
            $.ajax({
                url: Routing.generate('ajax_slug', {'string': this.value, 'locale': locale, 'repository': repository}),
                dataType: 'json',
                success: function(data, textStatus, jqXHR) {
                    $target.val(data.slug);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Se ha producido un error al obtener el slug.');
                }
            });
        }
    });

    $('a[data-toggle="tab"]').on('click', function(e){
        var $this = $(this);

        $('a[data-target="' + $this.data('target') + '"]').tab('show');
    });

    /**
     * Gallery type
     */
    (function(){
        var $collectionHolder = $('.gallery-image-forms'),
            unique_id = $collectionHolder.data('id'),
            cancel = false;

        $('.edit-image').fancybox({
            padding: 0,
            width: 600,
            height: 430,
            autoSize: false,
            closeBtn: false,
            topRatio: 0.3,
            modal: true,
            title: null,
            keys: {
                close : [27]
            },
            afterClose: function() {
                if(!cancel) {
                    $('form').submit();
                }
            }
        });

        $(document).on('click', '.delete-image', function(e){
            e.preventDefault();

            var eliminar = confirm('¿Seguro que desea eliminar esta imagen?');

            if (eliminar) {
                var $this = $(this);

                var key = $this.data('key');
                var $img = $('#'+key+'_img');
                var $box = $('#'+key+'_box');

                $box.find('.delete_checkbox input').attr('checked', 'checked');
                $('form').submit();
            }
        });

        $(document).on('click', '.update-image', function(e){
            e.preventDefault();

            cancel = false;

            //Actualizar el contenido del formulario
            // var data_key = $(this).attr('data-key');

            $.fancybox.close();
            //$('form').submit();
        });

        $(document).on('click', '.close-image', function(e){
            e.preventDefault();

            cancel = true;
            $.fancybox.close(true);
        });

        $(document).on('click', '.add-image', function(e){
            e.preventDefault();

            cancel = false;
            $.fancybox.close(true);
        });

        $(document).on('click', '.add_new_image', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var $this = $(this),
                $form = $this.closest('form');

            // the ajax post
            $form.ajaxSubmit({
                url: $this.attr('href'),
                type: "POST",
                dataType: 'html',
                data: { _xml_http_request: true },
                success: function(html) {
                    if (!html.length) {
                        return;
                    }

                    var $html = $(html),
                        $image = $html.last(),
                        $container = $('.gallery-image-forms'),
                        $a = $('<a/>', {
                            href: "#" + $image.attr('id')
                        });

                    $container.append($image);
                    $container.append($a);

                    $image.find('input[type=checkbox], input[type=radio]').iCheck({
                        checkboxClass: 'icheckbox_minimal-grey',
                        radioClass: 'iradio_minimal-grey'
                    });

                    if($image.find('input[type="file"]').length > 0) {
                        $form.attr('enctype', 'multipart/form-data');
                        $form.attr('encoding', 'multipart/form-data');
                    }

                    $a.fancybox({
                        padding: 0,
                        width: 600,
                        height: 430,
                        autoSize: false,
                        closeBtn: false,
                        topRatio: 0.3,
                        modal: true,
                        title: null,
                        keys: {
                            close : [27]
                        },
                        afterClose: function() {
                            if(!cancel) {
                                $('form').submit();
                            } else {
                                $container.find('.gallery-item').last().remove();
                            }
                        }
                    }).trigger('click');
                }
            });
        });
    })();

    // Color type
    (function(){
        $('.color[type="text"]').ColorPicker({
            color: '#000',
            onChange : function(hsb, hex, rgb, el) {
                $(el).val('#' + hex);
            }
        });
    })();

    // Delete file
    (function(){
        $(document).on('click', '.delete-file', function(e){
            e.preventDefault();

            var eliminar = confirm('¿Seguro que desea eliminar este fichero?');

            if (eliminar) {
                var $this = $(this);

                var id = $this.data('id');
                var entity = $this.data('class');
                var field = $this.data('field');

                //AJAX
                $.getJSON(
                    Routing.generate('ajax_delete_file', {entity: entity, field: field, id: id}),
                    function() {
                        $('.delete-file, .show-file').remove();
                    }
                ).fail(function(jqXHR, textStatus, errorThrown) {
                    alert('Se ha producido un error al eliminar el fichero.');
                });
            }
        });
    })();

    // Admin collection type
    (function(){
        var $input = $('.admin-collection');

        var formatSelection = function(data) {
            return data.name;
        };

        var formatResult = function(data) {
            var markup = '<table class=\'data-result\'><tr>';
            if (data.image !== null) {
                markup += '<td class=\'data-image\'><img src=\'' + data.image + '\' style=\'width: 20%;\'/></td>';
            }
            markup += '<td class=\'data-info\'><div class=\'data-title\'>' + data.name + '</div></td>';
            markup += '</tr></table>';

            return markup;
        };

        var $select2 = $input.select2({
            placeholder: 'Buscar elementos...',
            minimumInputLength: 3,
            ajax: {
                url: Routing.generate('ajax_admin_collection'),
                dataType: 'jsonp',
                data: function (term, page) {
                    return {
                        entity : this.data('class'),
                        filtro: term,
                        limit: 10,
                    };
                },
                results: function (data, page) {
                    return {results: data.results};
                }
            },
            formatResult: formatResult,
            formatSelection: formatSelection,
            dropdownCssClass: 'bigdrop'
        });

        $input.on('change', function(){
            var $this = $(this);
            var data = $input.select2('data');

            console.log(data);

            $this.closest('.choice').find('select option[value=\''+data.id+'\']').attr('selected', 'selected');

            var $tr = $('<tr/>', {
                id : $this.data('field') + '_' + data.id + '_row',
            });

            var $td = $('<td/>', {
                text : data.name
            });

            var $td_a = $('<td/>', {
                class : 'text-center'
            });

            var $a = $('<a/>', {
                href : '#',
                class : 'delete-mn-row btn btn-xs btn-danger',
                'data-id' : data.id,
                text : 'Borrar'
            });

            $tr.append($td);
            $tr.append($td_a.append($a));

            $this.closest('.choice').find('.table-mn tbody').append($tr);
        });

        $(document).on('click', '.delete-mn-row', function(e){
            e.preventDefault();

            var $this = $(this);
            var eliminar = confirm('¿Seguro que desea eliminar este elemento?');

            if (eliminar) {
                var id = $this.data('id');

                $this.closest('.choice').find('select option[value=\''+id+'\']').removeAttr('selected');
                $this.closest('tr').remove();
            }
        });
    })();
});
