<?php
    if(isset($_SESSION['login_user']) && $_SESSION['login_pass']){
        header('location: index.php?page=products');
    }
?>
<body>
    <form action="" method="post">
        <div class="container">
            <div class="row login__row">
                <div class="login__content">
                    <h1 class="login__title">Login</h1>
                    <div class="login__items">
                        <p class="login__username login__content--para">Username</p>
                        <input type="text" class="login__items--inp" name="username" id="">
                    </div>

                    <div class="login__items">
                        <p class="login__password login__content--para">Password</p>
                        <input type="password" class="login__items--inp" name="password" id="">
                    </div>

                    <div class="login__more">
                        <label for="remember" class="login__remember">
                            <input type="checkbox" name="" class="login__more--inp" id="remember" required>
                            Remember me
                        </label>

                        <a href="?page=forgot_pass" class="login__more--forgot">Forgot password?</a>
                    </div>
                    <?php
                        if(isset($_POST['login__btn'])){
                            if(!empty($_POST['username']) && !empty($_POST['password'])){
                                $username = $_POST['username'];
                                $pass = $_POST['password'];
                                if(checkLogin($username, md5($pass))){
                                    $_SESSION['login_user'] = $username;
                                    $_SESSION['login_pass'] = md5($pass);
                                    header('location: index.php?page=products');
                                }else{
                                    echo '<p style="color: red; text-align:center; font-weight: bold;" >Invalid login !</p>';
                                }
                            }else{
                                echo '<p style="color: red; text-align:center; font-weight: bold;" >Please enter full informations</p>';
                            }
                        }
                    ?>

                    <button class="login__btn" name="login__btn">
                        Login
                    </button>
                </div>
            </div>
        </div>
    </form>
</body>