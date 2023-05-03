<?php
    if(isset($_SESSION['login_user'])){
        $username = $_SESSION['login_user'];
        $dataCus = getCustomerByUsername($username);
        $Cus_Level = $dataCus['Customer_Level'];
        switch($Cus_Level){
            case "1": $Cus_Discount = 0;
                break;
            case "2": $Cus_Discount = 2/100;
                break;
            case "3": $Cus_Discount = 4/100;
                break;
        }
        $_SESSION['cus_Discount'] = $Cus_Discount;
    }else{
        $Cus_Level = "";
        $Cus_Discount = 0;
    }
?>
<body>
    <div class="slide-show__container">

    <div class=" slide-show__main">
        
        <div class="slide-show--click">

                    
            <img class="slide-show__img fade" src="./assets/img/slider1.jpg">
            <img class="slide-show__img d-none fade" src="./assets/img/slider2.jpg">
            <img class="slide-show__img d-none fade" src="./assets/img/slider3.jpg">
            <img class="slide-show__img d-none fade" src="./assets/img/slider4.jpg">
            <img class="slide-show__img d-none fade" src="./assets/img/slider5.jpg">
            <img class="slide-show__img d-none fade" src="./assets/img/slider6.jpg">
            <img class="slide-show__img d-none fade" src="./assets/img/slider7.jpg">
            <img class="slide-show__img d-none fade" src="./assets/img/slider8.jpg">
            <img class="slide-show__img d-none fade" src="./assets/img/slider9.jpg">
            <img class="slide-show__img d-none fade" src="./assets/img/slider10.jpg">

            <!-- <img class="slide-show__img d-none fade" src="/assets/img/demon-slider.jpg">
            <img class="slide-show__img d-none fade" src="/assets/img/creed-slider.jpg">
            <img class="slide-show__img d-none fade" src="/assets/img/songsot-slider.jpg"> -->
            <a class="slider-prev" onclick="backImg()">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
            <a class="slider-next" onclick="nextImg()">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>

    </div>
    </div>

    <div class="bg--outside">
        <div class="container">
            <div class="row">
                <!-- <input type="text" class="products__input col-l-4 col-md-4 col-sm-4" placeholder="Search on all" name="" id="search-input"> -->
    
                <div id="products__list" class="products__list col-l-12 col-md-12 col-sm-12">

                    <?php
                        foreach(getProducts() as $row){
                            $product_ID = $row['Product_ID'];
                            $product_Name = $row['Product_Name'];
                            $type_Product = $row['TypeProduct_ID'];
                            $product_supplier_ID = $row['Supplier_ID'];
                            $product_Unit = $row['Unit'];
                            $product_Price = $row['Price'];
                            $product_Quan = $row['Product_Quantities'];
                            $product_img = $row['Image_Product'];
                            ?>
                            
                            <a title="Member level <?= $Cus_Level ?> has been discount <?= $Cus_Discount ?>" href="?page=describe&productID=<?= $product_ID ?>" id="products__items" class="products__items col-l-2-4 col-md-3 col-sm-6">
                                <div class="products__items--inner">
                                    <img class="products__img" src="./assets/img/<?= $product_img ?>" alt="" srcset="">
                                    <div class="products_info">
                                        <h4 class="products__title"><?= $product_Name ?></h4>
                                        <p class="products__para"><?= number_format(intval($product_Price)*((110/100) - $Cus_Discount)) ?><span class="products__unit"> <?= $product_Unit ?></span></p>
                                        <?php
                                            if(isset($_SESSION['login_user'])){
                                                ?>
                                                
                                                <p style="text-decoration:line-through; font-style:italic;" class="text-muted products__para"><?= number_format(floatval($product_Price)*(110/100)) ?><span class="products__unit"> <?= $product_Unit ?></span></p>
                                                <?php
                                            }
                                        ?>
                                        <div class="products__remaining">
                                            <p class="products__para">Remaining:</p>
                                            <p class="products__para"><?= $product_Quan ?></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<script>searchItems(); setIntervalSlider()</script>