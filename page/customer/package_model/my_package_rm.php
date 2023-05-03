<?php
    if(isset($_GET['OrL']) && isset($_GET['Product'])){
        if(checkProductOrderLIstDetails($_GET['OrL'], $_GET['Product'])){
            $orderList_ID = $_GET['OrL'];
            $Product_ID = $_GET['Product'];
            deleteOrderDetailsProduct($orderList_ID, $Product_ID);
            header('location: ?page=my_package');
        }else{
            header('location: ?page=my_package');
        }
    }else{
        header('location: ?page=my_package');
    }
?>