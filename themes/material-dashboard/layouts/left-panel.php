<?php if(!Yii::$app->user->getIsGuest()): ?>
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
        <div class="logo">
            <a href="javascript:;" class="simple-text logo-normal">
                Natraj Kumar Textiles
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php?r=user-type/index">
                    <i class="material-icons">groups</i>
                    <p><?php echo Yii::t('app', 'User Type'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./index.php?r=bank/index">
                    <i class="material-icons">account_balance</i>
                    <p><?php echo Yii::t('app', 'Bank'); ?></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./index.php?r=saree-type/index">
                    <i class="material-icons">dashboard</i>
                    <p><?php echo Yii::t('app', 'Saree Type'); ?></p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./index.php?r=user/index&UserSearch[user_type_id]=3">
                    <i class="material-icons">person</i>
                    <p><?php echo Yii::t('app', 'Weaver'); ?></p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./tables.html">
                    <i class="material-icons">content_paste</i>
                    <p>Table List</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./typography.html">
                    <i class="material-icons">library_books</i>
                    <p>Typography</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./icons.html">
                    <i class="material-icons">bubble_chart</i>
                    <p>Icons</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./map.html">
                    <i class="material-icons">location_ons</i>
                    <p>Maps</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./notifications.html">
                    <i class="material-icons">notifications</i>
                    <p>Notifications</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./rtl.html">
                    <i class="material-icons">language</i>
                    <p>RTL Support</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
<?php endif; ?>

