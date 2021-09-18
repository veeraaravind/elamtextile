<?php if(!Yii::$app->user->getIsGuest()): ?>
    <nav id="main-nav">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li>
            <a href="#">Services</a>
            <ul>
                <li>
                <a href="#">Hosting</a>
                <ul>
                    <li><a href="#">Private Server</a></li>
                    <li><a href="#">Managed Hosting</a></li>
                </ul>
                </li>
                <li><a href="#">Domains</a></li>
                <li><a href="#">Websites</a></li>
            </ul>
            </li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>
<?php endif; ?>

