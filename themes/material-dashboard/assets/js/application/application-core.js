$(document).ready(function() {

    let baseURL = window.location.href.split("?")[0]+"?r=",
        modelNameURLMapping = {
            'SareeType': 'saree-type',
            'User': 'user',
            'Bank': 'Bank',
            'UserType': 'user-type'
        };

    function lcfirst(givenString) {
        return givenString.charAt(0).toLowerCase() + givenString.slice(1);
    }

    function clearModalFieldValues(modelName) {
        let formDataElement = $(document).find('form#'+lcfirst(modelName)+'Form'),
            saveButtonElement = $(document).find('.saveData');

        formDataElement.find(':not(.mandatoryField)').val('');
        saveButtonElement.removeAttr('data-id');
    }

    $('.logout').on('click', function() {
        let logoutURL = $(this).data('href');

        $.post(logoutURL).done(function(){
            console.info('Successfully logout.');
        });
    });

    $('.language-switch button').on('click', function() {
        let selectedLanguage = $(this).data('value');
        $.post(baseURL+'saree-type/switch-language', {'language': selectedLanguage}, function(){
            location.reload();
        });
    });

    $(document).on('click', '.createDataModal', function(e) {
        e.preventDefault();
        let model = $(this).data('model');

        clearModalFieldValues(model);
    });

    $(document).on('click', '.saveData', function(e) {
        e.preventDefault();
        let element = $(this),
            sareeTypeId = element.attr('data-id'),
            model = element.attr('data-model'),
            urlModelName = modelNameURLMapping[model],
            lcModelName = lcfirst(model),
            submitURL = baseURL+urlModelName+'/update&id='+sareeTypeId,
            formDataElement = $(document).find('form#'+lcModelName+'Form'),
            formData = formDataElement.serializeArray();

        if ($.isNumeric(sareeTypeId) === false) {
            submitURL = baseURL+urlModelName+'/create';
        }
        $.post(submitURL, formData).done(function() {
            $.pjax.reload('#pjax-grid-view', {timeout : false});
            $('#'+lcModelName+'Modal').modal('hide');
        }).always(function() {
            clearModalFieldValues(model);
        });
    });

    $(document).on('click', '.grid-view a[title="Update"]', function(e) {
        e.preventDefault();

        let id = $(this).closest('tr').data('key'),
            model = $('#pjax-grid-view').attr('data-model'),
            urlModelName = modelNameURLMapping[model],
            lcModelName = lcfirst(model),
            formDataElement = $(document).find('form#'+lcModelName+'Form'),
            saveButtonElement = $(document).find('.saveData');

        $.getJSON(baseURL+urlModelName+'/view&id='+id).done(function(data) {
            $.each( data['data'], function( key, value ) {
                formDataElement.find('[name="'+model+'['+key+']"]').val(value);
            });
            saveButtonElement.attr('data-id', id);
            $('#'+lcModelName+'Modal').modal('show');
        });
    });

    $(document).on('click', '.grid-view a[title="View"]', function(e) {
        e.preventDefault();

        let id = $(this).closest('tr').data('key'),
            model = $('#pjax-grid-view').attr('data-model'),
            urlModelName = modelNameURLMapping[model],
            lcModelName = lcfirst(model),
            defaultViewModal = $(document).find('#defaultViewModal'),
            defaultViewModalTable = defaultViewModal.find('#defaultViewDisplayTable tbody');

        $.getJSON(baseURL+urlModelName+'/view&id='+id).done(function(data) {
            $.each( data['data'], function( key, value ) {
                if ($.inArray(key, ['id']) == -1) {
                    let label = data['label'][key];
                    if (typeof label == 'undefined') {
                        label = key;
                    }
                    defaultViewModalTable.append( "<tr><th>"+label+"</th><td>"+value+"</td></tr>" );
                }
            });

            defaultViewModal.find('#defaultViewLabel').text(
                $('#'+lcModelName+'Label').text()
            );
            defaultViewModal.modal('show');
        });
    });

    $(document).on('click', '.grid-view a[title="Delete"]', function(e) {
        e.preventDefault();

        let id = $(this).closest('tr').data('key'),
            model = $('#pjax-grid-view').attr('data-model'),
            defaultDeleteModal = $(document).find('#defaultDeleteModal'),
            defaultViewModalTable = defaultDeleteModal.find('.deleteData');

        defaultViewModalTable.attr('data-id', id);
        defaultViewModalTable.attr('data-model', model);
        defaultDeleteModal.modal('show');
    });

    $(document).on('click', '.deleteData', function(e) {
        
        let id = $(this).data('id'),
            model = $(this).data('model'),
            urlModelName = modelNameURLMapping[model],
            defaultDeleteModal = $(document).find('#defaultDeleteModal');

        $.post(baseURL+urlModelName+'/delete&id='+id).done(function() {
            $.pjax.reload('#pjax-grid-view', {timeout : false});
            defaultDeleteModal.modal('hide');
        }).always(function() {
            clearModalFieldValues(model);
        });
    });
});