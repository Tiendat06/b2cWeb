<body>
    <?php
        if(isset($_SESSION['login_user'])){
            $username = $_SESSION['login_user'];
            ?>
            
                <div class="container p-5">
                    <div class="row justify-content-center">
                        <?php
                            if(checkOrder($username)){
                                ?>
                                    <h1 class="text-center p-2 package__title col-l-12 col-md-12 col-sm-12">Your Order</h1>

                                    <!-- <input placeholder="Search On All" type="text" name="" id="search-input" class="my_order__inp"> -->
                                    <div id="products__list" class="order__content col-l-12 col-md-12 col-sm-12">
                                <?php
                                    $count = 0;
                                    foreach(getAllMyOrderDetails($username) as $row){
                                        $OrderList_ID = $row['OrderList_ID'];
                                        $Product_ID = $row['Product_ID'];
                    
                                        $date = new DateTime($row['Date_Created_OrderList']->format('d-m-Y'));
                                        $Date_Created = $date->format('d-m-Y');
                                        
                                        // echo $row['Date_Created_OrderLIst'];
                                        $Note = $row['Note'];
                                        $Quan = $row['Quantities'];
                                        
                                        // $delivery_date = $row['Delivery_Date'];
                                        $date = new DateTime($row['Delivery_Date']->format('Y-m-d'));
                                        $delivery_date = $date->format('d-m-Y');

                                        $total_money = $row['Total_Money'];
                                        $Product_Name = $row['Product_Name'];
                                        $Unit = $row['Unit'];
                                        $Price = $row['Price'];
                                        $Product_Img = $row['Image_Product'];
                                        $type_Name = $row['TypeProductName'];
                                        ?>
                                        
                                                <a href="?page=check_goods&Pr=<?= $Product_ID ?>&Or=<?= $OrderList_ID ?>" class="products__items order__content--inner">
                                                    <div class="order__content--img col-l-2 col-md-2 col-sm-2">
                                                        <img class="order__img w-100" src="./assets/img/<?= $Product_Img ?>" alt="" srcset="">
                                                    </div>

                                                    <div class="order__content--info col-l-7 col-md-7 col-sm-7">
                                                        <p class="order__content--title"><?= $Product_Name ?></p>
                                                        <span class="order__content--date"><strong>Date Created:</strong> <?= $Date_Created ?></span></br>
                                                        <span class="order__content--date"><strong>Delivery Date:</strong> <?= $delivery_date ?></span></br>
                                                        <span class="order__content--type"><strong>Type:</strong> <?= $type_Name ?></span></br>
                                                        <span class="order__content--quan"><strong>x <?= $Quan ?></strong></span>

                                                    </div>
                                                
                                                
                                                    <div class="order__content--price col-l-3 col-md-3 col-sm-3">
                                                        <p class="order__content--money"><?= number_format($total_money) ?> <?= $Unit ?></p>
                                                    </div>
                                                </a>
                                                <?php
                                                $count++;
                                        }
                                    ?>

                                    <?php
                                        $dataCus = getCustomerByUsername($username);
                                        $Cus_Level = $dataCus['Customer_Level'];
                                        if($count > 10 && $Cus_Level < 2) updateCusLevel($username, 2);
                                        if($count > 20 && $Cus_Level < 3) updateCusLevel($username, 3);
                                    ?>
                                    </div>
                                    
                                    <script>
                                        searchItems();
                                    </script>
                                <?php
                            }
                            else{
                            ?>
                                <h1 class="text-center p-3 package__title col-l-12 col-md-12 col-sm-12">Your Order</h1>
                                <img class=" col-l-8 col-md-8 col-sm-8" src="./assets/img/no_package.png" alt="" srcset="">
                                <p style="font-weight: bold;" class="text-center p-3 mb-0 package__para col-l-12 col-md-12 col-sm-12">You don't have any products in your order yet</p>
                            <?php
                            }
                        ?>
                    </div>
                </div>
            <?php
        }else{
            header('location: index.php?page=login');
        }
    ?>
</body>