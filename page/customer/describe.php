<body>
    <?php
        
        if(isset($_GET['productID'])){
            $productID = $_GET['productID'];
            $_SESSION['productID'] = $productID;
            header('location: '.deleteOneURL());
        }else{
            if(!isset($_SESSION['productID'])){
                header('location: index.php');
            }
            $productID = $_SESSION['productID'];
        }
        if(isset($_SESSION['cus_Discount'])){
            $Cus_Discount = $_SESSION['cus_Discount'];
        }else{
            $Cus_Discount = 0;
        }

        $dataProduct = getProductByProductID($productID);
        $product_Name = $dataProduct['Product_Name'];
        $type_Product = $dataProduct['TypeProduct_ID'];
        $product_supplier_ID = $dataProduct['Supplier_ID'];
        $product_Unit = $dataProduct['Unit'];
        $product_Price = (int)$dataProduct['Price'];
        $product_Quan = $dataProduct['Product_Quantities'];
        $product_img = $dataProduct['Image_Product'];
        
    ?>
    <div class="bg--outside">
        <div class="container">
            <div class="row">
                <h1 class="describe__title col-l-12 col-md-12 col-sm-12"><?= $product_Name ?></h1>

                <div class="describe__info col-l-12 col-md-12 col-sm-12">
                    <img class="describe__img col-l-6 col-md-6 col-sm-12" src="./assets/img/<?= $product_img ?>" alt="" srcset="">
                    
                    <!-- <span class="col-l-6 col-md-6 col-sm-12">a</span> -->
                    <!-- <div class="describe__info--inner">hi</div> -->

                    <div class="describe__info--inner col-l-6 col-md-6 col-sm-12">
                        <div class="describe__info--price">
                            <p class="describe__info--money">
                                <?= number_format(intval($product_Price)*((110/100) - $Cus_Discount)) ?>
                                <span class="describe__info--unit">
                                    <?= $product_Unit ?> <span class="describe__info--VAT">| Price includes 10% VAT</span>
                                </span> 
                            </p> 
                        </div>

                        <div class="describe__info--freeship">
                            <i class="describe__info--freeship-icon fa-solid fa-truck"></i>
                            <p class="describe__info--freeship-details describe__info--para">Delivery within 72 hours</p>
                        </div>

                        <input type="hidden" name="" id="cus_discount" value="<?= $Cus_Discount ?>">
                        <input type="hidden" name="" id="product_unit" value="<?= $product_Unit ?>">
                        <?php
                            if(isset($_SESSION['login_user']) && isset($_SESSION['login_pass'])){
                                $btn_path = "";
                            }else{
                                $btn_path = "?page=login";
                            }
                        ?>

                        <div class="describe__info--inp">
                            <p class="describe__info--inp-para">Quantity</p>
                            <input oninput="onInputAddToPackage(id)" type="text" name="" class="describe__inp--quan" id="<?= $product_Price ?>">
                        </div>
                        
                        <div class="describe__btn">
                            <a id="describe__add-package" href="<?= $btn_path ?>" class="describe__btn--add"><i class="describe__info--icon fa-sharp fa-solid fa-cart-plus"></i>Add to your package</a>
                        </div>
                    </div>


                </div>

                <div class="describe__more col-l-12 col-md-12 col-sm-12">
                    <h3 class="describe__more--title col-l-12 col-md-12 col-sm-12">Order products</h3>
                    <!-- <input type="text" placeholder="Search on all" name="" class="describe__more--input col-l-6 col-md-6 col-sm-12" id="search-input"> -->
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
                            if($productID == $product_ID) continue;
                            else{
                                $count++;
                            ?>
                            
                            <a href="?page=describe&productID=<?= $product_ID ?>" class="products__items col-l-2-4 col-md-3 col-sm-6">
                                <div class="products__items--inner">
                                    <img class="products__img" src="./assets/img/<?= $product_img ?>" alt="" srcset="">
                                    <div class="products_info">
                                        <h4 class="products__title"><?= $product_Name ?></h4>
                                        <p class="products__para"><?= floatval($product_Price)*(110/100) ?><span class="products__unit"> <?= $product_Unit ?></span></p>
                                        <div class="products__remaining">
                                            <p class="products__para">Remaining:</p>
                                            <p class="products__para"><?= $product_Quan ?></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php
                                
                            }
                        }
                    ?>
                    </div>

                    <a class="descibe__btn" href="?page=products">More products</a>
                </div>
                
            </div>
        </div>
    </div>
</body>

<script>
    function onInputAddToPackage(product_price){
        let quan =document.getElementById(product_price).value;
        // let product_Price_val =document.getElementById('product_price').value;
        let product_unit_val =document.getElementById('product_unit').value;
        let add_Package = document.getElementById('describe__add-package');
        let cus_discount =document.getElementById('cus_discount').value;

        add_Package.href = `?page=describe_add_package&Quan=${quan}&Price=${product_price*((110/100) - cus_discount)}&Unit=${product_unit_val}`;
    }

</script>