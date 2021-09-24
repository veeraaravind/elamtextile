/** Global Variable start */
let baseURL = window.location.href.split("?")[0]+"?r=",
    modelNameURLMapping = {
        'SareeType': 'saree-type',
        'User': 'user',
        'Bank': 'bank',
        'UserType': 'user-type',
        'InventoryType': 'inventory-type',
        'MapWarpWeaver': 'map-warp-weaver',
        'MapWeaverInventory': 'map-weaver-inventory',
        'MapWarpBabeenWeaver': 'map-warp-babeen-weaver',
        'MapWarpWeaverInventory': 'map-warp-weaver-inventory',
        'Colour': 'colour',
        'Company': 'company'
    };
/** Global Variable end */

function getKeyByValue(object, value) {
    return Object.keys(object).find(key => object[key] === value);
}

function lcfirst(givenString) {
    return givenString.charAt(0).toLowerCase() + givenString.slice(1);
}

function clearModalFieldValues(modelName) {
    let documentElement = $(document),
        formDataElement = documentElement.find('form#'+lcfirst(modelName)+'Form'),
        saveButtonElement = documentElement.find('.saveData');

    formDataElement.find('input[type="checkbox"]:not(.mandatoryField)').prop('checked', false);
    formDataElement.find(':not(.mandatoryField):not(option)').val('');
    formDataElement.find('select').change();
    saveButtonElement.removeAttr('data-id');

    formDataElement.find('[required]').each(function(index, element) {
        let elementObject = $(element), 
            elementId = elementObject.attr('id'), 
            select2Element = formDataElement.find(`[aria-labelledby="select2-${elementId}-container"]`);
        
        if (select2Element.length > 0) {
            select2Element.removeClass('border border-danger');
        } else {
            elementObject.removeClass('border border-danger');
        }
    });
}

function updateRecordModal(id, model) {
    let documentElement = $(document),
        urlModelName = modelNameURLMapping[model],
        lcModelName = lcfirst(model),
        formDataElement = documentElement.find('form#'+lcModelName+'Form'),
        saveButtonElement = documentElement.find('.saveData'),
        tempFieldElement;

    clearModalFieldValues(model);
    $.getJSON(baseURL+urlModelName+'/view&id='+id).done(function(data) {
        $.each( data['data'], function( key, value ) {
            tempFieldElement = formDataElement.find('[name="'+model+'['+key+']"]');
            if (tempFieldElement.length > 0) {
                if (tempFieldElement.attr('type') != "file") {
                    tempFieldElement.val(value);
                } else {
                    tempFieldElement.attr('data-href', value);

                }
            }
        });
        updateCustomFieldValues(model, data);
        formDataElement.find('select').change();
        saveButtonElement.attr('data-id', id);
        documentElement.find(`#${lcModelName}Modal .modal-body`).animate({ scrollTop: 0 }, "slow");
        $('#'+lcModelName+'Modal').modal('show');
    }).fail(function() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
        });
    });
}

function viewRecordModal(id, model) {
    let urlModelName = modelNameURLMapping[model],
        lcModelName = lcfirst(model),
        defaultViewModal = $(document).find('#defaultViewModal'),
        defaultViewModalTable = defaultViewModal.find('#defaultViewDisplayTable tbody');

    defaultViewModalTable.html('');    
    $.getJSON(baseURL+urlModelName+'/view&id='+id).done(function(data) {
        $.each( data['displayFields'], function( key, fieldName ) {
            if ($.inArray(fieldName, ['id']) == -1) {
                let label = data['label'][fieldName],
                    value = data['data'][fieldName];
                if (typeof label == 'undefined') {
                    label = fieldName;
                }
                if (
                    fieldName.indexOf("foreign_value") !== -1 
                    || fieldName.indexOf("foreign_image") !== -1
                ) {
                    return;
                }
                if (`foreign_value_${fieldName}` in data['data']) {
                    value = data['data'][`foreign_value_${fieldName}`];
                }
                if (`foreign_image_${fieldName}` in data['data']) {
                    let src = baseURL.replace('/web/index.php?r=', data['data'][`foreign_image_${fieldName}`]);
                    value = "<img src='"+src+"' height='100rem' />";
                }
                value = value == null ? '' : value;
                defaultViewModalTable.append( "<tr><th>"+label+"</th><td>"+value+"</td></tr>" );
            }
        });

        defaultViewModal.find('#defaultViewLabel').text(
            $('#'+lcModelName+'Label').text()
        );
        defaultViewModal.modal('show');
    }).fail(function() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
        });
    });
}

function deleteRecordModal(id, model) {
    let defaultDeleteModal = $(document).find('#defaultDeleteModal'),
        defaultViewModalTable = defaultDeleteModal.find('.deleteData');

    defaultViewModalTable.attr('data-id', id);
    defaultViewModalTable.attr('data-model', model);
    defaultDeleteModal.modal('show');
}

function updateCustomFieldValues(model, viewResponse) {
    let documentElement = $(document);

    if (model == 'User' && documentElement.find('.loomDetails').length > 0) {
        updateLoomDetails(viewResponse);
    } else if (model == 'MapWarpWeaver') {
        let fieldsList = {'body_colour':'bodyColour', 'pettu_colour':'pettuColour'};
        
        for (key in fieldsList) {
            let tempColour = '';

            if (key in viewResponse['data'] 
                && typeof viewResponse['data'][key] == 'string'
                && viewResponse['data'][key].length > 0
            ) {
                tempColour = viewResponse['data'][key];
                tempColour = colourList[tempColour]; 
            }
            documentElement.find(`#${fieldsList[key]}-source`).spectrum("set", tempColour);
        }
    } else if (model == 'Colour') {
        let key = 'code', tempColour = '';
        
        if (key in viewResponse['data'] 
            && typeof viewResponse['data'][key] == 'string'
            && viewResponse['data'][key].length > 0
        ) {
            tempColour = viewResponse['data'][key];

        }
        documentElement.find(`#${key}-source`).spectrum("set", tempColour);
    } else if (model == 'Company') {
        let logo = viewResponse['data']['logo'];

        if (logo !== null && logo.length > 0) {
            let src = baseURL.replace('/web/index.php?r=', viewResponse['data'][`foreign_image_logo`]);

            $('#companyLogo').fileinput('destroy');
            $('#companyLogo').fileinput({
                'initialPreview': [src], 
                'initialPreviewAsData' : true,
                'showUpload' : false,
                'browseLabel' : '',
                'removeLabel' : '',
                'mainClass' : 'input-group-lg',
                'overwriteInitial' : true,
                'initialPreviewShowDelete' : false
            });
        }
    }
}

function checkPageBasedDomUpdate(model, formData = null) {
    let urlModelName = modelNameURLMapping[model], cardElement;
    
    if (model == 'User' && (cardElement = $(document).find('.userDetailUpdate')).length) {
        let userId = cardElement.find('.userDetailsEdit').attr('data-id'),
            fetchURL = `${baseURL}${urlModelName}/user-details-view&id=${userId}`;

        $.get(fetchURL, function(viewContent) {
            cardElement.html(viewContent);
        }).fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
        });
    } else if (model == 'MapWarpWeaverInventory' && (cardElement = $(document).find('.warpWeaverInventoryGrid')).length) {
        $(document).find('.warpWeaverDetailsDropdown').change();
    } else if (model == 'MapWarpBabeenWeaver' && (cardElement = $(document).find('.warpWeaverInventoryGrid')).length) {
        $(document).find('.warpWeaverDetailsDropdown').change();
    }
}

function customValidationLogic(model, formDataElement) 
{
    if (model == 'MapWarpBabeenWeaver') {
        let errorClass = 'border border-danger', 
            leftBabeenValidationElement = formDataElement.find('.leftBabeenDetails'),
            rightBabeenValidationElement = formDataElement.find('.rightBabeenDetails'),
            leftBabeenYelai = leftBabeenValidationElement.find('#leftBabeenYelai'),
            leftBabeenLength = leftBabeenValidationElement.find('#leftBabeenLength'),
            rightBabeenYelai = rightBabeenValidationElement.find('#rightBabeenYelai'),
            rightBabeenLength = rightBabeenValidationElement.find('#rightBabeenLength');

        leftBabeenValidationElement.find('input').removeClass(errorClass);
        rightBabeenValidationElement.find('input').removeClass(errorClass);
        if (leftBabeenYelai.val() == '' && leftBabeenLength.val() == ''
            && rightBabeenYelai.val() == '' && rightBabeenLength.val() == '' ) {
                leftBabeenValidationElement.find('input').addClass(errorClass);
                rightBabeenValidationElement.find('input').addClass(errorClass);
                return true;
        } 
        if (leftBabeenYelai.val() != '' && leftBabeenLength.val() == '') {
            leftBabeenLength.addClass(errorClass);
            return true;
        } else if (leftBabeenYelai.val() == '' && leftBabeenLength.val() != '') {
            leftBabeenYelai.addClass(errorClass);
            return true;
        } 

        if (rightBabeenYelai.val() != '' && rightBabeenLength.val() == '') {
            rightBabeenLength.addClass(errorClass);
            return true;
        } else if (rightBabeenYelai.val() == '' && rightBabeenLength.val() != '') {
            rightBabeenYelai.addClass(errorClass);
            return true;
        }
    } else if (model == 'MapWarpWeaverInventory') {
        return validateWarpWeaverInventory(formDataElement);
    }
}

function validateAndAddBorder(formDataElement) {
    let hasGenericValidationError = false;

    formDataElement.find('[required]').each(function(index, element) {
        let elementObject = $(element), 
            elementId = elementObject.attr('id'), 
            select2Element = formDataElement.find(`[aria-labelledby="select2-${elementId}-container"]`);
        if (elementObject.val() == '') {
            hasGenericValidationError = true;
            if (select2Element.length > 0) {
                select2Element.addClass('border border-danger');
            } else {
                elementObject.addClass('border border-danger');
            }
        } else {
            if (select2Element.length > 0) {
                select2Element.removeClass('border border-danger');
            } else {
                elementObject.removeClass('border border-danger');
            }
        }
    });

    return hasGenericValidationError;
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
    let model = $(this).data('model'),
        target = $(this).data('target');

    clearModalFieldValues(model);
    switch(model){
        case 'User':
            let generateLoomElement = $('.generatedLoom');
            generateLoomElement.html();
            generateLoomElement.closest('.generatedLoomDetails').addClass('d-none');
            break;
        case 'MapWarpWeaver':
            let documentElement = $(document);
            documentElement.find(`#bodyColour-source`).spectrum("set", '');
            documentElement.find(`#pettuColour-source`).spectrum("set", '');
            break;
        default:
            break;
    }

    $(document).find(`${target} .modal-body`).animate({ scrollTop: 0 }, "slow");
    $(document).find(target).modal('show');
});

$(document).on('click', '.saveData', function(e) {
    e.preventDefault();
    let element = $(this), uploadData = new FormData(),
        sareeTypeId = element.attr('data-id'),
        model = element.attr('data-model'),
        urlModelName = modelNameURLMapping[model],
        lcModelName = lcfirst(model),
        submitURL = baseURL+urlModelName+'/update&id='+sareeTypeId,
        formDataElement = $(document).find('form#'+lcModelName+'Form'),
        formData = formDataElement.serializeArray(),
        hasGenericValidationError = hasCustomValidationError = false,
        ajaxSetting;

    if ($.isNumeric(sareeTypeId) === false) {
        submitURL = baseURL+urlModelName+'/create';
    }

    /** Validation starts */
    hasGenericValidationError = validateAndAddBorder(formDataElement);
    hasCustomValidationError = customValidationLogic(model, formDataElement);
    if (hasGenericValidationError || hasCustomValidationError) {
        formDataElement.find('.border.border-danger[required]:eq(0)').focus();
        return false;
    }
    /** Validation end */

    ajaxSetting = {
        url: submitURL,
        type: "POST",
        data: formData
    };
    if (formDataElement.find('input[type="file"]').length > 0) {
        $.each(formData, function (key, value) {
            uploadData.append(key, value);
        });
        $.each(formDataElement.find('input[type="file"]'), function (key, input) {
            let fileData = input.files;
            for (let i = 0; i < fileData.length; i++) {
                uploadData.append(input.name, fileData[i]);
            }
        });
        ajaxSetting = {
            url: submitURL,
            type: "POST",
            data: uploadData,
            dataType: false,
            cache: false,
            processData: false,
            contentType: false
        };
    }
    
    $.ajax(ajaxSetting).done(function(data) {
        if ($(`#pjax-grid-view[data-model="${model}"]`).length) {
            $.pjax.reload(`#pjax-grid-view[data-model="${model}"]`, {timeout : false});
        }
        $('#'+lcModelName+'Modal').modal('hide');
        clearModalFieldValues(model);
        checkPageBasedDomUpdate(model, formData);
    }).fail(function(data) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
        });
    });
});

$(document).on('click', '.userDetailsEdit', function(e) {
    e.preventDefault();

    let id = $(this).data('id'),
        model = $(this).attr('data-model');

    updateRecordModal(id, model);
});

$(document).on('click', '.grid-view a[title="Update"]', function(e) {
    e.preventDefault();

    let id = $(this).closest('tr').data('key'),
        model = $('#pjax-grid-view').attr('data-model');

    updateRecordModal(id, model);
});

$(document).on('click', '.grid-view a[title="View"]', function(e) {
    e.preventDefault();

    let id = $(this).closest('tr').data('key'),
        model = $('#pjax-grid-view').attr('data-model');

    viewRecordModal(id, model);
});

$(document).on('click', '.grid-view a[title="Delete"]', function(e) {
    e.preventDefault();

    let id = $(this).closest('tr').data('key'),
        model = $('#pjax-grid-view').attr('data-model');
        
    deleteRecordModal(id, model);
});

$(document).on('click', '.deleteData', function(e) {
    
    let id = $(this).attr('data-id'),
        model = $(this).attr('data-model'),
        urlModelName = modelNameURLMapping[model],
        defaultDeleteModal = $(document).find('#defaultDeleteModal');

    $.post(baseURL+urlModelName+'/delete&id='+id).done(function() {
        if ($('#pjax-grid-view').length) {
            $.pjax.reload('#pjax-grid-view', {timeout : false});
        }
        defaultDeleteModal.modal('hide');
        checkPageBasedDomUpdate(model);
    }).fail(function() {
        defaultDeleteModal.modal('hide');
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
        });
    });
});

$(document).on('click', '.grid-view a[title="Detailed View"]', function(e) {
    e.preventDefault();
    window.location.href = $(this).attr('href');
});

$(document).on('click', '.addTranslation', function(e) {
    let documentElement = $(document), 
        element = documentElement.find('.eachTranslation:eq(0)').clone();

    documentElement.find('.translationContent').append(element);
    documentElement.find('.translationContent .eachTranslation:last input').val('');
    documentElement.find('.translationContent .eachTranslation:last input:first').focus();
    documentElement.find('.translationContent .eachTranslation:last .deleteTranslation').removeClass('d-none');
});

$(document).on('click', '.deleteTranslation', function(e) {
    $(this).closest('.eachTranslation').remove();
});


