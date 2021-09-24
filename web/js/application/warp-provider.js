$('.paymentWarp').on('click', function(e) {
    let warpRecords = $('#pjax-grid-view #w0').yiiGridView('getSelectedRows'),
        paymentWarpModal = $('#paymentWarpModal');

    $.post(
        baseURL+'map-warp-weaver/payment-capture', 
        {warpRecords : warpRecords}
    ).done(function(response) {
        paymentWarpModal.find('.modal-body').html(response);
        paymentWarpModal.modal('show');
        $('.paymentWarpConfirmation').prop('disabled', false);
    }).fail(function() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
        });
    });
});

$(document).on('change keyup', '#paymentWarpModal .warpPaymentRecords input', function() {
    let totalAmount = 0;
    $(this).closest('.warpPaymentRecords').find('input').each(function(i,n){
        totalAmount += $.isNumeric(n.value) ? parseFloat(n.value) : 0; 
    });

    $(document).find('.warpPaymentRecords .warpPaymentTotalAmount').text(totalAmount);
});

$(document).on('click', '#paymentWarpModal .warpPaymentRecords .deleteWarpPaymentRecord', function() {
    let index = 1, totalWarpRows, documentElement;

    $(this).closest('tr').remove();
    documentElement = $(document);
    totalWarpRows = documentElement.find('.warpPaymentRecords tbody tr:not(.totalCalulcation)');
    if (totalWarpRows.length) {
        totalWarpRows.each(function(i, element){
            let elementToManipulate = $(element);
            $(elementToManipulate).find('td:eq(0)').text(index);
            index++; 
        });
    } else {
        $('.paymentWarpConfirmation').prop('disabled', true);
    }
    documentElement.find('#paymentWarpModal .warpPaymentRecords input').change();
});

function updateColourName(elementName, colour) {
    let elementId = {
            'MapWarpWeaver[body_colour]':'bodyColour-source',
            'MapWarpWeaver[pettu_colour]':'pettuColour-source' 
        }, changedColour = $(`#${elementId[elementName]}`).spectrum('get'),
        changedColourCode = changedColour.toName() !== false ? changedColour.toName() : changedColour.toHexString(),
        colourName = getKeyByValue(colourList, changedColourCode);
    $(`input[name="${elementName}"]`).val(colourName);
}