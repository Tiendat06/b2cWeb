<body>
    <form action="" method="post">

        <div class="container">
            <div class="row">
                <div class="forgot-pass">
                    <h1 class="forgot-pass__title">Forgot pass</h1>
    
                    <div class="forgot-pass__content">
                        <p class="forgot-pass__content--para">Please enter your registered email in the form below, we will send the code to your email.</p>
                        <input type="email" class="forgot-pass__mail" name="forgot-pass__email" id="">
    
                        <?php
                            if(isset($_POST['forgot-pass__btn'])){
                                if(!empty($_POST['forgot-pass__email'])) {
                                    if(checkEmail($_POST['forgot-pass__email'])){
                                        $email = $_POST['forgot-pass__email'];
                                        $_SESSION['email'] = $email;
                                        header('location: ?page=forgot_pass_send_mail&email='.$email);
                                    }else{
                                        ?>
                                    <p style="color: red; text-align:center; font-weight:bold;" class="col-l-12 col-md-12 col-sm-12" >Invalid Email</p>
                                    <?php
                                    }
                                }else{
                                    ?>
                                    <p style="color: red; text-align:center; font-weight:bold;" class="col-l-12 col-md-12 col-sm-12">Email cannot be blanked</p>
                                    <?php
                                }
                            }
                        ?>
    
                        <button name="forgot-pass__btn" class="bg-success forgot-pass__btn">SEND</button>
                    </div>
                </div>
    
                <div class="describe__more col-l-12 col-md-12 col-sm-12">
                    <h3 class="describe__more--title col-l-12 col-md-12 col-sm-12">Suggestions for you</h3>
                
                    <div class="describe__more--list col-l-12 col-md-12 col-sm-12">
                    
                        <?php
                        $count = 0;
                        foreach(getProductsLimitSix() as $row){
                            if($count == 6) break;
                            $product_ID = $row['Product_ID'];
                            $product_Name = $row['Product_Name'];
                            $type_Product = $row['TypeProduct_ID'];
                            $product_supplier_ID = $row['Supplier_ID'];
                            $product_Unit = $row['Unit'];
                            $product_Price = $row['Price'];
                            $product_Quan = $row['Product_Quantities'];
                            $product_img = $row['Image_Product'];
                            ?>
                            
                            <a href="?page=describe&productID=<?= $product_ID ?>" class="products__items col-l-2-4 col-md-3 col-sm-6">
                                <div class="products__items--inner">
                                    <img class="products__img" src="./assets/img/<?= $product_img ?>" alt="" srcset="">
                                    <div class="products_info">
                                        <h4 class="products__title"><?= $product_Name ?></h4>
                                        <p class="products__para"><?= number_format(($product_Price)*(110/100)) ?><span class="products__unit"> <?= $product_Unit ?></span></p>
                                        <div class="products__remaining">
                                            <p class="products__para">Remaining:</p>
                                            <p class="products__para"><?= $product_Quan ?></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php
                            $count++;
                            
                        }
                    ?>
                    </div>
    
                    <a class="descibe__btn" href="?page=products">More products</a>
                </div>
            </div>
        </div>
    </form>
</body>