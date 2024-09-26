
<body>
    <?php
    if(isset($_SESSION['login_user'])){
        $cus_Name = $_SESSION['login_user'];
        deleteCodeForgotOutOfDay($cus_Name);
    }
    // else{
    //     // header('location: index.php?page=login');
    // }
    ?>
    <form action="" method="post">
        <header class="header">
            <nav class="container header__navbar">
            
                <div class="row header__list">
    
                    <!-- <a href="?page=main_page" class="header__items">
                        <img class="header__img" src="./assets/img/logo.png" alt="" srcset="">
                    </a> -->
    
                    <a href="?page=products" class="header__items">
                        <p class="header__items--para">Products</p>
                    </a>
    
                    <a href="?page=my_package" class="header__items">
                        <p class="header__items--para">My Package</p>
                    </a>
    
                    <a href="?page=my_order" class="header__items">
                        <p class="header__items--para">My Order</p>
                    </a>
    
                    <div class="header__items header__items--login-signup">
                        <?php
                            if(!isset($_SESSION['login_user']) && !isset($_SESSION['login_pass'])){
                                ?>
                                
                                <a href="?page=login" class="header__items header__items--login-signup--inner">
                                    <p class="header__items--para">Login</p>
                                </a>
                                
                                <p class="header__items--para">/</p>
                
                                <a href="?page=sign_up" class="header__items header__items--login-signup--inner">
                                    <p class="header__items--para">Signup</p>
                                </a>
                                <?php
                            }else{
                                ?>
                                
                                <a href="?page=user_account" class="header__items header__items--login-signup--inner">
                                    <p class="header__items--para">
                                        <?= getName($cus_Name) ?>
                                    </p>
                                </a>
                                
                                <p class="header__items--para">/</p>
                                
                                <button name="logout__btn" class="header__items header__items--login-signup--inner">
                                    <p class="header__items--para">Logout</p>
                                </button>
    
                                <?php
                                if(isset($_POST['logout__btn'])){
                                    // unset($_SESSION['login_user']);
                                    // unset($_SESSION['login_pass']);
                                    session_unset();
                                    session_destroy();
                                    header('location: index.php?page=login');
                                }
                            }
                        ?>
                    </div>
                    
                </div>
            </nav>
        </header>
    
        <header class="header__bottom">
            <div class="container header__container">
                <div class="row header__content">
                    <a href="?page=products" class="header__content--img col-l-1 col-md-2 col-sm-2">
                        <img class="header__img" src="./assets/img/logo.png" alt="" srcset="">
                    </a>
                    <div class="header__content--search col-l-8 col-md-7 col-sm-7">
                        <input class="header__content--input" type="text" name="" placeholder="Search products" id="search-input">
                        <i class="header__content--search-icon fa-solid fa-magnifying-glass"></i>
                    </div>
                    <div class="header__content--delivery col-l-3 col-md-3 col-sm-3">
                        <i class="header__content--delivery-icon fa-solid fa-truck-fast"></i>
                        <p class="header__content--delivery-para">Delivery within 3 days</p>
                    </div>
                </div>
            </div>
        </header>
        
    
    </form>
</body>
