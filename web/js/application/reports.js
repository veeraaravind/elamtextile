$(document).on('change', '.weaverLoomDropdown', function(e) {
    let weaverLoomId = $(this).val(), documentElement = $(document),
        warpWeaverElement = documentElement.find('#warp_weaver_id'),
        krajeeOptions = warpWeaverElement.data('s2-options'),
        dataSelect = {"theme":"bootstrap","width":"100%","language":"en_US"};

    warpWeaverElement.find('option').not(':first').remove();
    if (weaverLoomId > 0) {
        $.getJSON(
            `${baseURL}map-warp-weaver/get-weaver-loom-warp&weaverLoomId=${weaverLoomId}`,
        ).done(function(data) {
            dataSelect['data'] = data;
            if (warpWeaverElement.data('select2')) {
                warpWeaverElement.select2('destroy'); 
            }
            $.when(warpWeaverElement.select2(dataSelect)).done(initS2Loading("warp_weaver_id", krajeeOptions));
            warpWeaverElement.trigger('change');
            warpWeaverDetailsDropdown(0);
        });
    } else {
        warpWeaverElement.trigger('change');
        warpWeaverDetailsDropdown(0);
    }
});


$(document).on('click', '.searchWarpDetails', function(e) {
    let warpWeaverId = $(document).find('#warp_weaver_id').val();

    warpWeaverDetailsDropdown(warpWeaverId);
});

$(document).on('click', '.searchWeaverAmountDetails', function(e) {
    let weaverId = $(document).find('#weaver_id').val(),
        startDate = $(document).find('#start_date').val(),
        endDate = $(document).find('#end_date').val();

    $('.amountInitialText, .weaverAmountRecords').addClass('d-none');
    $('.spinnerClass').addClass('spinner-border');
    if (startDate.length > 0 && endDate.length > 0) {
        $.post(
            `${baseURL}user/weaver-amount-report`,
            {weaver_id:weaverId, start_date:startDate, end_date:endDate}
        ).done(function(response) {
            $('.weaverAmountRecords').html(response);
            $('.weaverAmountRecords #weaverAmountRecordsTable').DataTable();
        }).always(function() {
            $('.spinnerClass').removeClass('spinner-border');
            $('.weaverAmountRecords').removeClass('d-none');
        });
    } else {
        $('.warpInitialText').removeClass('d-none');
        $('.spinnerClass').removeClass('spinner-border');
    }
});

$(document).on('click', '.searchWeaverInventoryDetails', function(e) {
    let weaverId = $(document).find('#weaver_id').val(),
        startDate = $(document).find('#start_date').val(),
        endDate = $(document).find('#end_date').val();

    $('.amountInitialText, .weaverInventoryRecords').addClass('d-none');
    $('.spinnerClass').addClass('spinner-border');
    if (startDate.length > 0 && endDate.length > 0) {
        $.post(
            `${baseURL}user/weaver-inventory-report`,
            {weaver_id:weaverId, start_date:startDate, end_date:endDate}
        ).done(function(response) {
            $('.weaverInventoryRecords').html(response);
            $('.weaverInventoryRecords #weaverInventoryRecordsTable').DataTable();
        }).always(function() {
            $('.spinnerClass').removeClass('spinner-border');
            $('.weaverInventoryRecords').removeClass('d-none');
        });
    } else {
        $('.warpInitialText').removeClass('d-none');
        $('.spinnerClass').removeClass('spinner-border');
    }
});