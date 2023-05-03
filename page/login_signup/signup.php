<body>
    <form action="" method="post">
        <div class="container">
            <div class="row login__row signup__row">
                <div class="login__content">
                    <h1 class="login__title">Sign up</h1>

                    <div class="login__items">
                        <p class="login__password login__content--para">Full Name</p>
                        <input type="text" class="login__items--inp" name="name" id="">
                    </div>

                    <div class="login__items">
                        <p class="login__DOB login__content--para">DOB</p>
                        <input type="date" class="login__items--inp" name="DOB" id="">
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

                    <div class="login__items">
                        <p class="login__password login__content--para">Address</p>
                        <input type="text" class="login__items--inp" name="address" id="">
                    </div>

                    <div class="login__items">
                        <p class="login__password login__content--para">Email</p>
                        <input type="email" class="login__items--inp" name="email" id="">
                    </div>

                    <div class="login__items">
                        <p class="login__password login__content--para">Phone</p>
                        <input type="text" class="login__items--inp" name="phone" id="">
                    </div>

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
                            <input type="checkbox" name="" class="login__more--inp" id="remember">
                            I have read term of use
                        </label>

                        <a href="?page=login" class="login__more--forgot">Having account?Login now</a>
                    </div>
                    

                    <button class="login__btn" name="login__btn">
                        Register
                    </button>
                </div>
            </div>
        </div>
    </form>
</body>