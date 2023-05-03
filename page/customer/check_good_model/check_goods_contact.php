<?php
    if(isset($_GET['note']) && !empty($_GET['note'])){
        $note = substr($_GET['note'], 1, -1);
        $OrderList_ID = $_SESSION['OrderList_ID'];
        updateOrderListNote($OrderList_ID, $note);
        header('location: index.php?page=check_goods');
    }else{
        header('location: index.php?page=check_goods');
    }
?>