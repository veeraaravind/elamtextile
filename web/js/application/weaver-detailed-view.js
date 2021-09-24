
function validateWarpWeaverInventory(formDataElement) {
    let validationPattern = [
        ['givenYarnWeight'],
        ['returnYarnWeight'],
        ['givenJarigaiQuantity', 'givenJarigaiWeight'],
        ['returnJarigaiQuantity'],
        ['producedSarees', 'actualAmount'],
        ['givenAmount'],
        ['mistakeAmount']
    ], mainValidationError = 0, validInputPattern = 0;

    for (fields of validationPattern) {
        let fieldIDWithInvalidData = [], tempErrorFieldsName = '', tempValue, validInput = 0;
        for (field of fields) {
            tempValue = formDataElement.find(`#${field}`).val();
            if (tempValue == '' || tempValue <= 0) {
                fieldIDWithInvalidData.push(field);
            } else {
                formDataElement.find(`#${field}`).removeClass('border border-danger');
                validInput++;
            }
        }
        if (fields.length == validInput) {
            validInputPattern++;
        }
        if (fieldIDWithInvalidData.length > 0 && fieldIDWithInvalidData.length != fields.length) {
            tempErrorFieldsName = fieldIDWithInvalidData.join(', #');
            formDataElement.find(`#${tempErrorFieldsName}`).addClass('border border-danger');
            mainValidationError++;
        }
    }

    return mainValidationError == 0 && validInputPattern > 0 ? false : true;
}

function warpWeaverDetailsDropdown(warpWeaverId) {
    let documentElement = $(document);

    $('.warpInitialText, .warpWeaverInventoryRecords, .printWarpWeaverInventory').addClass('d-none');
    $('.spinnerClass').addClass('spinner-border');
    if (warpWeaverId > 0) {
        $.get(
            `${baseURL}user/warp-details&warp_weaver_id=${warpWeaverId}`
        ).done(function(response) {
            $('.warpWeaverInventoryGrid').html(response);
            documentElement.find('.warpWeaverInventoryGrid #MapWarpWeaverInventoryTable').DataTable();
        }).always(function() {
            $('.spinnerClass').removeClass('spinner-border');
            $('.warpWeaverInventoryRecords, .printWarpWeaverInventory').removeClass('d-none');
            if (documentElement.find('.warpStatus .badge').attr('data-status') == 6) {
                documentElement.find('.warpWeaverChangeStatus').addClass('d-none');
            }
        });
    } else {
        $('.warpInitialText').removeClass('d-none');
        $('.spinnerClass').removeClass('spinner-border');
    }
}

$(document).on('change', '.warpWeaverDetailsDropdown', function(e) {
    let warpWeaverId = $(this).val();

    warpWeaverDetailsDropdown(warpWeaverId)
});

$(document).on('click', '.addWarpWeaverInventory', function(e) {
    let documentElement = $(document),
        warpWeaverId = documentElement.find('.warpWeaverDetailsDropdown').val();

        clearModalFieldValues('MapWarpWeaverInventory');
        documentElement.find('#mapWarpWeaverInventoryModal form input').removeClass('border border-danger');
        documentElement.find('#mapWarpWeaverInventoryModal').modal('show');
        documentElement.find('#mapWarpWeaverInventoryForm [name="MapWarpWeaverInventory[warp_weaver_id]"]').val(warpWeaverId);
});

$(document).on('click', '.updateWarpWeaverInventory', function(e) {
    e.preventDefault();

    let id = $(this).attr('data-id'),
        model = $(this).attr('data-model');

    $(document).find('#mapWarpWeaverInventoryModal form input').removeClass('border border-danger');
    updateRecordModal(id, model);
});

$(document).on('click', '.deleteWarpWeaverInventory', function(e) {
    e.preventDefault();

    let id = $(this).attr('data-id'),
        model = $(this).attr('data-model');

    deleteRecordModal(id, model);
});

$(document).on('click', '.viewWarpWeaverInventory', function(e) {
    e.preventDefault();

    let id = $(this).attr('data-id'),
        model = $(this).attr('data-model');

    viewRecordModal(id, model);
});

$(document).on('click', '.printWarpWeaverInventory', function(e) {
    e.preventDefault();

    let id = $(document).find('#warp_weaver_id').val(),
        win = window.open(`${baseURL}map-warp-weaver-inventory/print-inventory-record&id=${id}`, '_blank');

    if (win) {
        win.focus();
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
        });
    }
});

$(document).on('click', '.addBabeenToWarp', function(e) {
    let documentElement = $(document),
        warpWeaverId = documentElement.find('.warpWeaverDetailsDropdown').val();

    documentElement.find('#mapWarpBabeenWeaverForm [name="MapWarpBabeenWeaver[warp_weaver_id]').closest('.col-md-6').addClass('d-none');
    documentElement.find('#mapWarpBabeenWeaverForm #babeen_provider_id').closest('.col-md-6').removeClass('d-none');
    documentElement.find('#mapWarpBabeenWeaverForm #babeen_provider_id').val('');

    clearModalFieldValues('MapWarpBabeenWeaver');
    documentElement.find('#mapWarpBabeenWeaverModal form input').removeClass('border border-danger');
    documentElement.find('#mapWarpBabeenWeaverModal').modal('show');
    documentElement.find('#mapWarpBabeenWeaverForm [name="MapWarpBabeenWeaver[warp_weaver_id]"]').val(warpWeaverId);
});

$(document).on('click', '.warpWeaverChangeStatus', function(e) {
    let documentElement = $(document),
        warpWeaverId = documentElement.find('#warp_weaver_id').val(),
        optionList = [],
        warpStatus = documentElement.find('.warpStatus .badge').attr('data-status');

    documentElement.find('#warpWeaverChangeStatusForm .select2-selection').removeClass('border border-danger');
    $.getJSON(`${baseURL}map-warp-weaver/movable-warp-list&currentWarpWeaverId=${warpWeaverId}`).done(
        function (data) {
            $.each(data['movableWarpList'], function(key, value) {
                optionList.push('<option value="'+ value['id'] +'">'+ value['text'] +'</option>');
            });
            documentElement.find('[name="MapWarpWeaverInventory[moving_warp_weaver_id]"').html(optionList.join(''));
            documentElement.find('[name="MapWarpWeaverInventory[moving_warp_weaver_id]"').change();
            for (key in data['movableInventoryDetails']) {
                documentElement.find(`[name="MapWarpWeaverInventory[${key}]"`).val(
                    data['movableInventoryDetails'][key]
                );
            }

            documentElement.find(`#warpWeaverChangeStatusModal [name="MapWarpWeaver[status]"] option`).prop("disabled", false);
            documentElement.find('#warpWeaverChangeStatusModal [name="MapWarpWeaver[status]"]').val('');
            documentElement.find(`#warpWeaverChangeStatusModal [name="MapWarpWeaver[status]"] option[value="${warpStatus}"]`).prop("disabled", true);
            documentElement.find('#warpWeaverChangeStatusModal [name="MapWarpWeaver[status]"]').change();
            documentElement.find('#warpWeaverChangeStatusModal').modal('show');
        }
    ).fail(function (data) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
        });
    });
});

$(document).on('click', '.saveMovingMapWarpWeaverInventory', function() {
    let documentElement = $(document),
        warpWeaverId = documentElement.find('#warp_weaver_id').val(),
        formData = documentElement.find('#warpWeaverChangeStatusForm').serializeArray(),
        statusSelect2 = documentElement.find('#warpWeaverChangeStatusForm [aria-labelledby="select2-status-container"]'),
        movableWarpSelect2 = documentElement.find('#warpWeaverChangeStatusForm [aria-labelledby="select2-moving_warp_weaver_id-container"]'),
        status = documentElement.find('#warpWeaverChangeStatusForm [name="MapWarpWeaver[status]"]').val(),
        nextWrapId = documentElement.find('#warpWeaverChangeStatusForm [name="MapWarpWeaverInventory[moving_warp_weaver_id]"]').val(),
        hasError = false, hasInventoryToMove = false;

    for (value of formData) {
        if (
            value['name'].indexOf('MapWarpWeaverInventory') !== -1 
            && value['value'] != "" 
            && value['value'] > 0
        ) {
            hasInventoryToMove = true;
            break;
        }
    }

    statusSelect2.removeClass('border border-danger');
    if (status == '') {
        statusSelect2.addClass('border border-danger');
        hasError = true;
    }
    if (hasInventoryToMove) {
        movableWarpSelect2.removeClass('border border-danger');
        if (status == 6 && nextWrapId == '') {
            movableWarpSelect2.addClass('border border-danger');
            hasError = true;
        }
    } else {
        formData = [
            {
                name: 'MapWarpWeaver[status]', 
                value : documentElement.find('#warpWeaverChangeStatusForm [name="MapWarpWeaver[status]"]').val()
            }
        ];
    }
    
    if (hasError) {
        return false;
    }
    $.post(
        `${baseURL}map-warp-weaver-inventory/move-warp-weaver-inventory&currentWarpWeaverId=${warpWeaverId}`, 
        formData
    ).done(function(response) {
        $('#warpWeaverChangeStatusModal').modal('hide');
        documentElement.find('.warpWeaverDetailsDropdown').change();
    }).fail(function(response) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
        });
    });
});

$(document).on('change', '#warpWeaverChangeStatusModal [name="MapWarpWeaver[status]"]', function() {
    let documentElement = $(document), status = $(this).val();

    documentElement.find('.movingWarpStatusDetails').addClass('d-none');
    if (status == '6') {
        documentElement.find('.movingWarpStatusDetails').removeClass('d-none');
    }
});

$(document).on('change keyup', '#mapWarpWeaverInventoryModal #producedSarees', function() {
    let documentElement = $(document);
        totalSarees = $(this).val(), 
        sareeFee = documentElement.find('.sareesOutWeaverFees').val(),
        totalFee = 0;

    if (parseFloat(totalSarees) > 0 && parseFloat(sareeFee) > 0) {
        totalFee = totalSarees*sareeFee;
    }

    documentElement.find('#mapWarpWeaverInventoryModal .actual_amount').val(totalFee);
});