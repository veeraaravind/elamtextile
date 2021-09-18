$('#sameForRightBabeen').on('click', function(e) {
    if ($(this).is(':checked')) {
        let yelaiDetails = $(document).find('#mapWarpBabeenWeaverModal .yelaiDetails');

        yelaiDetails.find('input[name="MapWarpBabeenWeaver[right_babeen_yelai]"]').val(
            yelaiDetails.find('input[name="MapWarpBabeenWeaver[left_babeen_yelai]"]').val()
        );
        yelaiDetails.find('input[name="MapWarpBabeenWeaver[right_babeen_length]"]').val(
            yelaiDetails.find('input[name="MapWarpBabeenWeaver[left_babeen_length]"]').val()
        );
    }
});