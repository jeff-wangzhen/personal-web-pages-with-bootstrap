
<nav class="top nav nav-list" id="nav">
<!--导航项可以拖动位置-->
<div class="navbar navbar-fixed-top navbar-inner" style="top: 0;">
    <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="nav-collapse collapse">
            <ul id="nav-list" class="nav">
                <li class="list-group-item navbar-text">
                    <a href="introduction.php">基本信息</a>
                </li>
                <li class="list-group-item navbar-text">
                    <a href="Messages.php" class="toleavemessage">留言功能</a>
                </li>
                <?php
                if ($user_flag) {
                    echo "<li class='greet list-group-item navbar-text'>欢迎您！<img alt='头像' title='头像' id='loginportrait' src='clientportrait/" . $_SESSION["user_portrait"] . "'>" . $_SESSION["username"] . "<form action='SessionDestroy.php' id='formdestroy' name='formdestroy'>
                                <input type=\"submit\" id=\"destroy\" value=\"退出\"></form></li>";
                } else {
                    ?>
                    <li class="list-group-item navbar-text"><a href="SignIn.html">登录</a></li>
                    <li class="list-group-item navbar-text"><a href="SignUp.html">注册</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

</div>
</nav>