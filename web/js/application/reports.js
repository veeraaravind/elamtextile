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