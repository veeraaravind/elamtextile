<?php if(!Yii::$app->user->getIsGuest()): ?>
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
    <div class="container-fluid">
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <div class="btn-group language-switch" role="group">
                        <button type="button" class="btn btn-sm btn-secondary <?php echo Yii::$app->language == 'en_US' ? 'btn-warning active' : ''?>" data-value='en_US'>English</button>
                        <button type="button" class="btn btn-sm btn-secondary <?php echo Yii::$app->language == 'ta_IN' ? 'btn-warning active' : ''?>" data-value='ta_IN'>தமிழ்</button>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">notifications</i>
                    <span class="notification">5</span>
                    <p class="d-lg-none d-md-block">
                        Some Actions
                    </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Mike John responded to your email</a>
                        <a class="dropdown-item" href="#">You have 5 new tasks</a>
                        <a class="dropdown-item" href="#">You're now friend with Andrew</a>
                        <a class="dropdown-item" href="#">Another Notification</a>
                        <a class="dropdown-item" href="#">Another One</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">person</i>
                    <p class="d-lg-none d-md-block">
                        Account
                    </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                        <a class="dropdown-item logout" data-href='<?php echo Yii::$app->urlManager->createUrl(['/site/logout']); ?>'>Log out</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php endif; ?>