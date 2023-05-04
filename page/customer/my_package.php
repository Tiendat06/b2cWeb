<body>
    <?php
    if(isset($_SESSION['login_user'])){
        $username = $_SESSION['login_user'];
        if(checkCusOrderDetails($username)){
            $dataCus = getCustomerByUsername($username);
            $cus_Name = $dataCus['Customer_Name'];
            $cus_DOB = $dataCus['Customer_Birth'];
            $cus_Gender = $dataCus['Customer_Gender'];
            $cus_Address = $dataCus['Customer_Address'];
            $cus_Email = $dataCus['Customer_Email'];
            $cus_Phone = $dataCus['Customer_Phone'];
            ?>
            <div class="container p-5">
                <div class="row">
                    <div class="package__content col-l-6 col-md-6 col-sm-12">
            
                <?php
                    foreach(getProductInOrderListDetails($username) as $row){
                        $product_ID = $row['Product_ID'];
                        $Orderlist_ID = $row['OrderList_ID'];
                        $Quan = $row['Quantities'];
                        $total_money = $row['Total_Money'];
                        $Product_Name = $row['Product_Name'];
                        $Remaining_Quan = $row['Remain_Quantities'];
                        // echo $Remaining_Quan;
                        // $_SESSION[$Quan] = $Quan;
                        $_SESSION['OrderList_ID'] = $Orderlist_ID;
                        $Unit = $row['Unit'];
                        $Product_Img = $row['Image_Product'];
                        ?>
                    
                    <div class="package__content--inner col-l-12 col-md-12 col-sm-12">
                        <img class="package__content--img w-100" src="./assets/img/<?= $Product_Img ?>" alt="" srcset="">
                        <p class="package__content--para"><?= $Product_Name ?></p>
                        <p class="package__content--para">Quantity: <?= $Quan ?></p>
                        <p class="package__content--para">Remain Quantity: <?php echo intval(getProdutQuantity($product_ID)) ?></p>
                        <p class="package__content--para package__content--para-price">
                            <?= number_format($total_money) ?> <span class="package__content--unit"><?= $Unit ?></span>
                        </p>
                        
                        <a style="color: red;" href="?page=my_package_rm&OrL=<?= $Orderlist_ID ?>&Product=<?= $product_ID ?>" class="package__content--del d-flex align-items-center justify-content-center">
                            <span class="package__content--para"> Remove</span>
                            <i style="font-size: 1.2rem; text-decoration: none;" class="fa-solid fa-circle-minus pt-1 pl-2"></i>
                        </a>
                    </div>
                    <?php

                    }
                ?>
                    </div>

                        <div class="package__payment col-l-6 col-md-6 col-sm-12">
                            <h1 class="package__payment--title">Order info</h1>

                            <div class="package__payment--info">
                                <input class="package__payment--inp" placeholder="Your name *" type="text" value="<?= $cus_Name ?>" name="" id="">
                            </div>

                            <div class="package__payment--info">
                                <input class="package__payment--inp" placeholder="Your phone *" type="text" value="<?= $cus_Phone ?>" name="" id="">
                            </div>

                            <div class="package__payment--info">
                                <input class="package__payment--inp" placeholder="Your email*" type="text" value="<?= $cus_Email ?>" name="" id="">
                            </div>

                            <div class="package__payment--info">
                                <p class="package__payment--para">Delivery location</p>
                                <input class="package__payment--inp" placeholder="Your delivery location*" type="text" value="<?= $cus_Address ?>" name="" id="">
                            </div>

                            <div class="package__payment--info">
                                <p class="package__payment--para">Payment method</p>
                                <div class="package__payment--inp package__payment--method">
                                    <label onclick="onClickCash(id)" for="Cash" id="<?= getPaymentMethod('Cash') ?>" class="package__payment--method-check">
                                        <input value="Cash" type="radio" value="" name="payment-method" id="Cash" required>
                                        Cash
                                        <img class="w-25" src="./assets/img/cash-payment.jpg" alt="" srcset="">
                                    </label>

                                    <label for="vnpay" id="<?= getPaymentMethod('VNPay') ?>" class="package__payment--method-check">
                                        <input value="VNPay" type="radio" value="" name="payment-method" id="vnpay" required>
                                        VNPay
                                        <img class="w-25" src="./assets/img/vnpay-payment.jpg" alt="" srcset="">
                                    </label>
                                </div>
                            </div>

                            <!-- <div class="package__payment--info">
                                <p class="package__payment--para">Notes</p>
                                <textarea class="package__payment--inp" name="" id="" cols="30" rows="5"></textarea>
                            </div> -->

                            <div class="package__payment--info package__payment--checkbox">
                                <input type="checkbox" name="" id="com-invoice">
                                <label for="com-invoice" class="package__payment--para">Request a company invoice (Please enter your email to receive a VAT invoice)</label>
                            </div>

                            <a id="package__payment--btn" class="w-75 package__payment--btn">Order confirmation</a>

                        </div>
                        

                    </div>
                </div>

                <script>
                    function onClickCash(payment_id){
                        let payment_btn = document.getElementById('package__payment--btn');
                        payment_btn.href = `?page=my_package_order&PM=${payment_id}`;
                    }
                </script>
                <?php 

        }else{
            deleteOrderListID($username);
            ?>
            
            <div class="container p-5">
                <div class="row justify-content-center">
                    <h1 class="text-center p-3 package__title col-l-12 col-md-12 col-sm-12">Your Package</h1>
                    <img class=" col-l-8 col-md-8 col-sm-8" src="./assets/img/no_package.png" alt="" srcset="">
                    <p style="font-weight: bold;" class="text-center p-3 mb-0 package__para col-l-12 col-md-12 col-sm-12">You don't have any products in your cart yet</p>

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
            <?php
        }
    }else{
        header('location: index.php?page=login');
    }
    ?>
</body>