<?php

?>
<div class="container translationPage">
    <div class="card">
        <form class="mt-2 ml-2 mb-2 mr-2" method="post">
            <h1><?php echo Yii::t('app', 'Tamil Translation'); ?></h1>
            <div class="translationContent">
                <?php 
                    $index = 0;
                    foreach ($translations as $english=>$tamil): ?>
                    <div class="form-row mt-1 mr-1 ml-1 eachTranslation">
                        <div class="col-md-4">
                            <input type="text" name="translation[english][]" class="form-control" value="<?php echo $english; ?>">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="translation[tamil][]" class="form-control" value="<?php echo $tamil; ?>">
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-small btn-primary addTranslation"><i class="fa fa-plus"></i></a>
                            <a class="btn btn-small btn-danger <?php if ($index == 0) { echo 'd-none'; } ?> deleteTranslation"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                <?php $index++; endforeach; ?>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 2rem; margin-left: 25rem;"><?php echo Yii::t('app', 'Save'); ?></button>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){ 
        let isSaved = '<?php echo $isSaved; ?>';
        if (isSaved == '1') {
            Swal.fire({
                icon: 'success',
                title: 'Saved!',
                text: 'Translation saved successfully.',
            });
        }
    }, false);
</script>