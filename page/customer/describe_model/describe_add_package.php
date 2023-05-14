<body>
    <?php
    if(isset($_SESSION['login_user'])){

        if(isset($_GET['Quan']) 
        && isset($_GET['Price']) 
        && isset($_GET['Unit'])){
            if(!is_numeric($_GET['Quan']) || $_GET['Quan'] == '0' || !is_numeric($_GET['Price']) || empty($_GET['Quan'])){
                header('location: index.php?page=describe');
            }
            
            $productID = $_SESSION['productID'];
            $Quan = $_GET['Quan'];
            $Price = $_GET['Price'];
            $Unit = $_GET['Unit'];
            $username = $_SESSION['login_user'];

            if(checkProductInOrderDetails($productID, $username)){
                updateOrderDetailsForDuplicateProduct($productID, $username, $Quan, $Price);
            }else{
                insertOrderList($username, $productID, $Quan, floatval($Price)*floatval($Quan));
            }
            
            
            unset($_SESSION['productID']);
            header('location: index.php?page=my_package');
        }
        
    }else{

        header('location: index.php?page=login');

    }
    ?>
</body>