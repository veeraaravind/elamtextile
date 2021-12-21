let loomDetailstemplate = `
    <div class="form-row loomItem">
        <div class="col-md-4 mb-4">
            <input type="text" class="form-control d-none" value="#LOOMID#" name="MapWeaverLoom[#INDEX#][id]">
            <input type="text" class="form-control loomName" value="#LOOMNAME#" name="MapWeaverLoom[#INDEX#][loom_name]">
        </div>
        <div class="col-md-4 mb-4">
            <select class="custom-select form-control loomSareeType" name="MapWeaverLoom[#INDEX#][saree_type_id]">
                <option value="">Select Saree Type</option>
                #OPTIONS#
            </select>
        </div>
        <div class="col-md-4 mb-4">
            <button type="button" class="btn btn-danger btn-sm deleteLoomItem"><i class="fa fa-trash-alt"></i></button>
        </div>
    </div>
`;

function buildOption(optionObject, selectedValue = null) {
    let options = '', selected;
    for(key in optionObject) {
        selected = key == selectedValue ? 'selected="selected"' : '';
        options += `<option value="${key}" ${selected}>${optionObject[key]}</option>`
    }

    return options;
}

function updateLoomDetails(viewResponse) {
    if ('loomData' in viewResponse) {
        let loomCount = viewResponse['loomData'].length,
            documentElement = $(document), tempIndex = 0, tempDetails,
            options;

        documentElement.find('.generatedLoom').html('');
        if (loomCount > 0) {
            documentElement.find('#loomCount').val(loomCount);
            for(; tempIndex < loomCount; tempIndex++) {
                tempTemplate = loomDetailstemplate;
                tempDetails = viewResponse['loomData'][tempIndex];
                options = buildOption(sareeTypeList, tempDetails['saree_type_id']);
                tempTemplate = tempTemplate.replaceAll('#LOOMID#', `${tempDetails['id']}`);
                tempTemplate = tempTemplate.replaceAll('#LOOMNAME#', `${tempDetails['loom_name']}`);
                tempTemplate = tempTemplate.replaceAll('#INDEX#', tempDetails['id']);
                tempTemplate = tempTemplate.replaceAll('#OPTIONS#', options);
                documentElement.find('.generatedLoom').append(tempTemplate);
            }
            documentElement.find('.generatedLoomDetails').removeClass('d-none');
            documentElement.find('.generatedLoom .loomItem select').select2({
                theme:"bootstrap",
                dropdownParent: $('#userModal'),
                width: '100%'
            });
        }
    }
}

$(document).on('click', '.generateLoom', function() {
    let loomCount = $('#loomCount').val(),
        generateLoomElement = $('.generatedLoom'),
        options = buildOption(sareeTypeList);
    
    generateLoomElement.html('');
    if(loomCount > 0) {
        let tempIndex = 0, tempTemplate;
        for(; tempIndex < loomCount; tempIndex++) {
            tempTemplate = loomDetailstemplate;
            tempTemplate = tempTemplate.replaceAll('#LOOMID#', '');
            tempTemplate = tempTemplate.replaceAll('#LOOMNAME#', `Loom${tempIndex+1}`);
            tempTemplate = tempTemplate.replaceAll('#INDEX#', tempIndex);
            tempTemplate = tempTemplate.replaceAll('#OPTIONS#', options);
            generateLoomElement.append(tempTemplate);
        }
        generateLoomElement.closest('.generatedLoomDetails').removeClass('d-none');
        generateLoomElement.find('.loomItem select').select2({
            theme:"bootstrap",
            dropdownParent: $('#userModal'),
            width: '100%'
        });
        generateLoomElement.find('.loomItem:eq(0) .loomName').focus();
    }
});

$('.addLoomItem').on('click', function() {
    let tempIndex = $(document).find('.loomItem').length,
        generateLoomElement = $('.generatedLoom'),
        options = buildOption(sareeTypeList), 
        tempTemplate = loomDetailstemplate; 

        tempTemplate = tempTemplate.replaceAll('#LOOMID#', '');
        tempTemplate = tempTemplate.replaceAll('#LOOMNAME#', `Loom${tempIndex+1}`);
        tempTemplate = tempTemplate.replaceAll('#INDEX#', tempIndex);
        tempTemplate = tempTemplate.replaceAll('#OPTIONS#', options);
        generateLoomElement.append(tempTemplate);

        generateLoomElement.find('.loomItem:last select').select2({
            theme:"bootstrap",
            dropdownParent: $('#userModal')
        });
});

$(document).on('click', '.deleteLoomItem', function(){
    $(this).closest('.loomItem').remove();
});
