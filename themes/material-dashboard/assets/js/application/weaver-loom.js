$(document).on('click', '.generateLoom', function() {
    let loomCount = $('#loomCount').val(),
        generateLoomElement = $('.generatedLoom');
        template = `
            <div class="row loomItem">
                <div class="col-4">
                    <input type="text" class="form-control" name="MapWeaverLoom[#INDEX#][loom_name]">
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" name="MapWeaverLoom[#INDEX#][saree_type_id]>
                </div>
                <div class="col-4">
                    <button type="button" class="btn btn-danger btn-small"><i class="material-icons">delete</i></button>
                </div>
            </div>
        `;
    
    generateLoomElement.html('');
    if(loomCount > 0) {
        let tempIndex = 0, tempTemplate;
        for(; tempIndex < loomCount; loomCount++) {
            tempTemplate = template.replace('#INDEX#', tempIndex);
            generateLoomElement.append(tempTemplate);
        }
    }
});