<body>
    <form action="" method="post">
        <div class="container">
            <div class="row login__row signup__row">
                <div class="login__content">
                    <h1 class="login__title">Sign up</h1>

                    <div class="login__items">
                        <p class="login__password login__content--para">Full Name</p>
                        <input type="text" class="login__items--inp" name="name" id="name">
                    </div>

                    <div class="login__items">
                        <p class="login__password login__content--para">Address</p>
                        <input type="text" class="login__items--inp" name="address" id="address">
                    </div>

                    <div class="login__items">
                        <p class="login__password login__content--para">Email</p>
                        <input type="email" class="login__items--inp" name="email" id="email">
                    </div>

                    <div class="login__items">
                        <p class="login__password login__content--para">Phone number</p>
                        <input type="text" class="login__items--inp" name="phone" id="phone">
                    </div>

                    <div class="login__items">
                        <p class="login__username login__content--para">Username</p>
                        <input type="text" class="login__items--inp" name="username" id="username">
                    </div>

                    <div class="login__items">
                        <p class="login__password login__content--para">Password</p>
                        <input type="password" class="login__items--inp" name="password" id="password">
                    </div>

                    <div class="login__items">
                        <p class="login__DOB login__content--para">DOB</p>
                        <input type="date" class="login__items--inp" name="DOB" id="DOB">
                    </div>

                    <div class="login__items">
                        <p class="login__gender login__content--para">Gender</p>
                        
                        <div class="signup__content--gender">
                            <label for="Male" class="signup__content--male login__content--para">
                                <input type="radio" class="login__items--inp signup__content--inp" name="gender" id="Male" value="Male">
                                Male
                            </label>
                            <label for="Female" class="signup__content--female login__content--para">
                                <input type="radio" class="login__items--inp signup__content--inp" name="gender" id="Female" value="Female">
                                Female
                            </label>
                        </div>

                    </div>

                    <div class="login__more">
                        <label for="remember" class="login__remember">
                            <input type="checkbox" name="" class="login__more--inp" id="remember" required>
                            I have read term of use
                        </label>

                        <a href="?page=login" class="login__more--forgot">Having account?Login now</a>
                    </div>

                    <?php
                        if(isset($_POST['login__btn'])){
                            if(!empty($_POST['name']) && !empty($_POST['DOB'])
                            && !empty($_POST['gender']) && !empty($_POST['address'])
                            && !empty($_POST['email']) && !empty($_POST['phone'])
                            && !empty($_POST['username']) && !empty($_POST['password'])){
                                if(checkUserName($_POST['username'])){
                                    echo '<p style="text-align: center; color: red; font-weight:bold;" id="info">Username has been used</p>';
                                }else if(checkEmail($_POST['email'])){
                                    echo '<p style="text-align: center; color: red; font-weight:bold;" id="info">Email has been used</p>';
                                }else if(checkPhone($_POST['phone'])){
                                    echo '<p style="text-align: center; color: red; font-weight:bold;" id="info">Phone number has been used</p>';
                                }else{

                                    $name = $_POST['name'];
                                    $DOB = $_POST['DOB'];
                                    $gender = $_POST['gender'];
                                    $address = $_POST['address'];
                                    $email = $_POST['email'];
                                    $phone = $_POST['phone'];
                                    $username = $_POST['username'];
                                    $password = $_POST['password'];

                                    signUp($name, $DOB, $gender, $address, $email, $phone, $username, md5($password));
                                    echo '<p style="text-align: center; color: red; font-weight:bold;" id="info">Register successfully</p>';
                                }

                            }else{
                                echo '<p style="text-align: center; color: red; font-weight:bold;" id="info">Please enter full informations</p>';

                            }
                        }
                        ?>
                    
                    

                    <button id="login__btn" class="login__btn" name="login__btn">
                        Register
                    </button>
                </div>
            </div>
        </div>
    </form>
</body>

<script>
    
</script>