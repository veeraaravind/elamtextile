<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

?>
<div class="modal fade bd-example-modal-xl" id="userModal" role="dialog" aria-labelledby="userLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="userLabel"><?php echo Yii::t('app', 'User'); ?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='userForm'>
            <div class="userCreationDetails">
                <div class="col-md-12 mb-12">
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <div class="form-row userPersonalDetails">
                                <div class="col-md-4 mb-4">
                                    <input type="text" name="User[user_type_id]" class="form-control mandatoryField d-none" id="user_type_id" value="<?php echo $userTypeId; ?>" required>
                                    <label for="name"><?php echo Yii::t('app', 'Name'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="User[name]" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="mobileNumber"><?php echo Yii::t('app', 'Mobile Number'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="User[mobile_number]" class="form-control" id="mobileNumber" required>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="address"><?php echo Yii::t('app', 'Address'); ?></label>
                                    <textarea type="text" name="User[address]" class="form-control" id="address"></textarea>
                                </div>
                            </div>
                            <hr>
                            <?php if(isset($can_show_loom_details) && $can_show_loom_details): ?>                
                                <h3><?php echo Yii::t('app', 'Loom Details'); ?></h3>
                                <div class="form-row loomDetails">
                                    <div class="col-md-4 mb-4">
                                        <label for="loomCount"><?php echo Yii::t('app', 'Loom Count'); ?></label>
                                        <input type="number" min="0" step="1" max="100" class="form-control" id="loomCount">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <button type="button" class="btn btn-primary generateLoom"><?php echo Yii::t('app', 'Generate Loom'); ?></button>
                                    </div>
                                </div>
                                <div class="generatedLoomDetails d-none">
                                    <label><?php echo Yii::t('app', 'Loom Configuration'); ?></label>
                                    <div class="generatedLoom"></div>
                                    <div class="col-md-4 mb-4">
                                        <button type="button" class="btn btn-primary btn-sm addLoomItem">
                                            <span><i class="fa fa-plus mr-1"></i><?php echo Yii::t('app', 'Add Loom'); ?></span>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                            <?php endif; ?>
                            <h3><?php echo Yii::t('app', 'Bank Details'); ?></h3>
                            <div class="form-row bankDetails">
                                <div class="col-md-4 mb-4">
                                    <label for="bank"><?php echo Yii::t('app', 'Bank'); ?></label>
                                    <?php
                                        echo Select2::widget(
                                            [
                                                'name' => 'User[bank_id]',
                                                'theme' => Select2::THEME_BOOTSTRAP,
                                                'data' => ['' => Yii::t('app', 'Select Bank')] + ArrayHelper::map($bankList, 'id', 'name'),
                                                'options' => ['id' => 'bank_id', 'class' => 'form-control']
                                            ]
                                        );
                                    ?>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="bank_account_number"><?php echo Yii::t('app', 'Bank Account Number'); ?></label>
                                    <input type="text" name="User[bank_account_number]" class="form-control" id="bank_account_number">
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="bank_ifsc_code"><?php echo Yii::t('app', 'Bank IFSC Code'); ?></label>
                                    <input type="text" name="User[bank_ifsc_code]" class="form-control" id="bank_ifsc_code">
                                </div>
                            </div>
                            <hr>
                            <h3><?php echo Yii::t('app', 'Login Credential'); ?></h3>
                            <div class="form-row loginDetails">
                                <div class="col-md-6 mb-3">
                                    <label for="password"><?php echo Yii::t('app', 'Password'); ?></label>
                                    <input type="text" name="User[password]" class="form-control" id="password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary saveData saveUser" data-model='User'><?php echo Yii::t('app', 'Save'); ?></button>
      </div>
    </div>
  </div>
</div>