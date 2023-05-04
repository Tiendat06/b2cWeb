<?php
    if(!empty($_SESSION['cus_ID'])){
        $acc_ID = $_SESSION['cus_ID'];
    ?>
        <body>
            <!-- <div class="bg--outside"> -->
                <form action="" method="post">
                
                    <div class="container change-pass__container p-5">
                        <div class="row">
                            <h1 class="change-pass__title">Change Password</h1>
            
                            <div class="change-pass__content">
                                <div class="change-pass__outter">
                                    <p class="change-pass__para">New Password</p>
                                    <input type="password" class="change-pass__input" name="change-pass__input" id="">
                                </div>
                                
                                <div class="change-pass__outter">
                                    <p class="change-pass__para">Re-type New Password</p>
                                    <input type="password" class="change-pass__input" name="change-pass__re-input" id="">
                                </div>
    
                            </div>

                            <?php
                                if(isset($_POST['change-pass__btn'])){
                                    if(!empty($_POST['change-pass__input']) && !empty($_POST['change-pass__re-input'])){
                                        $newPass = $_POST['change-pass__input'];
                                        $reNewPass = $_POST['change-pass__re-input'];
                                        if($newPass == $reNewPass){
                                            updatePassWord(md5($newPass), $acc_ID);
                                            echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Your change has been saved !</p>";
                                            unset($_SESSION['cus_ID']);
                                            unset($_SESSION['email']);
                                            updateAccCodeForgotAgain(null, $acc_ID);
                                            // sleep(5);
                                            header('location: ?page=login');
                                        }else{
                                            echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>New Password and Re-type New Password are not the same !</p>";
                                        }
                                    }else{
                                        echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Please enter full informations !</p>";
                                    }
                                }
                            ?>
                            
                            <button name="change-pass__btn" class="bg-success change-pass__btn">Change</button>
    
                        </div>
                    </div>

                    <div class="container">

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
                
                </form>
            <!-- </div> -->
        </body>
        
    <?php
    }else{
        header('location: login_signup.php');
    }
?>
