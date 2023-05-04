<?php
    if(isset($_GET['PM'])){
        if(checkPayMentID($_GET['PM'])){
            $payment_ID = $_GET['PM'];
            $username = $_SESSION['login_user'];
            $orderList_ID = $_SESSION['OrderList_ID'];
            $Remain_Quan = -1;

            foreach(getProductInOrderListDetails($username) as $row){
                $product_ID = $row['Product_ID'];
                $Quan = $row['Quantities'];
                $Product_Quan = $row['Product_Quantities'];
                $Remain_Quan = $Product_Quan - $Quan;
                if($Remain_Quan < 0){
                    header('location: index.php?page=my_package');
                    break;
                }else{
                    updateOrderDetailsList($orderList_ID, $product_ID, $Quan);
                }
                
                
            }
            if($Remain_Quan < 0){
                header('location: index.php?page=my_package');
            }else{
                insertInvoice($orderList_ID, $payment_ID);
                updateOrderListDate($username);
                unset($_SESSION['OrderList_ID']);
                header('location: index.php?page=my_order');
            }
        }else{
            header('location: index.php?page=my_package');
        }
    }else{
        header('location: index.php?page=my_package');
    }
?>