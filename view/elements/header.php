<?php $this->cssList[] = 'header.css' ?>
<?php $this->cssList[] = 'darkmode.css' ?>

<?php $this->jsList[] = 'darkmode.js' ?>
<?php $this->jsList[] = 'headerPhone.js' ?>


<header class="header">

    <!--    SEARCH-->

    <div class="nav_search">

        <div class="container_logo"><img src="img/logo.png" class="logo"></div>

        <div class="container_search"><input type="text" class="search"></div>

    </div>


    <!--SIDENAV-->

    <div class="area"></div>

    <nav class="main-menu">
        <ul>
            <li>
                <a href="http://justinfarrow.com">
                    <i class="fa fab fa-home fa-2x"></i>
                    <span class="nav-text">
                            NEWSFEED
                        </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="#">
                    <i class="fa fas fa-search fa-2x"></i>
                    <span class="nav-text">
                            EXPLORE
                        </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="#">
                    <i class="fa fas fa-star fa-2x"></i>
                    <span class="nav-text">
                            POPULAR POST
                        </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="#">
                    <i class="fa fas fa-heart fa-2x"></i>
                    <span class="nav-text">
                            ABONNEMENTS
                        </span>
                </a>

            </li>
            <li>
                <a href="#">
                    <i class="fa fas fa-user fa-2x"></i>
                    <span class="nav-text">
                            PROFIL
                        </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fas fa-comments fa-2x"></i>
                    <span class="nav-text">
                           MESSAGES
                        </span>
                </a>
            </li>
        </ul>

        <ul class="logout">
            <li>
                <a href="#">
                    <i class="fa fas fa-cog fa-2x"></i>
                    <span class="nav-text">
                            SETTINGS
                        </span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-power-off fa-2x"></i>
                    <span class="nav-text">
                           DECONNEXION
                        </span>
                </a>
            </li>

        </ul>
    </nav>

    <!--DARKMODE-->

    <div class="content">
        <div class="theme-toggle theme-toggle-js">
            <span class="moon"></span>
            <span class="sun"></span>
            <small class="sun__ray"></small>
            <small class="sun__ray"></small>
            <small class="sun__ray"></small>
            <small class="sun__ray"></small>
            <small class="sun__ray"></small>
            <small class="sun__ray"></small>
        </div>
    </div>

<!--    BOTTOM NAV VERSION MOBILE-->

    <div class="container_bottomnav">
        <nav class="bottom-nav">
            <div class="bottom-nav-item active">
                <div class="bottom-nav-link">
                    <i class="fa fab fa-home fa-2x"></i>
                </div>
            </div>
            <div class="bottom-nav-item">
                <div class="bottom-nav-link">
                    <i class="fa fas fa-search fa-2x"></i>
                </div>
            </div>
            <div class="bottom-nav-item">
                <div class="bottom-nav-link">
                    <i class="fa fas fa-plus-circle fa-2x"></i>
                </div>
            </div>
            <div class="bottom-nav-item">
                <div class="bottom-nav-link">
                    <i class="fa fas fa-comments fa-2x"></i>
                </div>
            </div>

            <div class="bottom-nav-item">
                <div class="bottom-nav-link">
                    <i class="fa fas fa-user fa-2x"></i>
                </div>
            </div>
        </nav>
    </div>

</header>

