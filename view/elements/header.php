<?php $this->cssList[] = 'header.css' ?>
<?php $this->cssList[] = 'darkmode.css' ?>

<?php //$this->jsList[] = 'darkmode.js' ?>
<?php //$this->jsList[] = 'headerPhone.js' ?>


<header class="header">

    <!--    SEARCH-->

    <div class="nav_search">


        <div class="container_search"><input type="text" class="search"></div>

        <div class="container_buttonProfile">
        <button>
            <i class="fas fa-comment"></i>
        </button>

        <button>
            <i class="fas fa-cog"></i>
        </button>

            <div class="container_imgUser"><img src="storage/header/user.jpg" class="user_nav"></div>


        </div>

    </div>


    <!--SIDENAV-->

    <nav class="side_nav">


       <img src="storage/header/logo.png" class="logo">



        <button >
            <i class="fas fa-home"></i>Home

        </button>

        <button>
            <i class="fas fa-hashtag"></i> Abonnements
        </button>

        <button>
            <i class="fas fa-search"></i> Explorer
        </button>

        <button>
            <i class="fas fa-star"></i> Popular posts
        </button><br><br><br><br><br>

        <button>
            <i class="fas fa-star"></i> Popular posts
        </button>

        <button>
            <i class="fas fa-star"></i> Popular posts
        </button>

<!--        <button>-->
<!--            <i class="fas fa-comment"></i> Messages-->
<!--        </button>-->




<!--        <div class="nav_profile">-->
<!---->
<!---->
<!--            <div class="container_name_nav"><button><h1 class="name_nav">PIERRE RICHARD</h1></button></div>-->
<!--        </div>-->


    </nav>

    <!--DARKMODE-->

    <div class="container_darkmode">
        <div class="header_darkmode">
            <img class="sun" src="storage/header/sun.png">
            <img class="moon hide" src="storage/header/moon.png">

        </div>

    </div>

<!--    </div>-->

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

<script src="assets/js/darkmode.js"></script>


