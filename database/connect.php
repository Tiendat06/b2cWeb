<?php
    define('severName', '(local)');
    define('Database', 'FINAL_SE');
    define('Uid', 'sa');
    define('PWD', '123456');

    function open_Database(){
        $connectionInfo = [
            "Database" => Database,
            // "Uid" => Uid,
            // "PWD" => PWD
        ];
        $conn = sqlsrv_connect(severName, $connectionInfo);
        if (!$conn) {
            die(print_r(sqlsrv_errors(), true));
        }
        return $conn;
    }
    
    function getProducts(): array{
        $conn = open_Database();
        $data = array();
        $query = "select * from MOBILE_PRODUCT";
        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data[] = $row;
        }
        sqlsrv_close($conn);
        return $data;
    }

    function signUp($Cus_Name, $Cus_DOB, $Cus_Gender, $Cus_Address, $Cus_Email, $Cus_Phone,
    $username, $Cus_Pass){
        $conn = open_Database();
        $query = "select max(Customer_ID) as max_id from CUSTOMER";
        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        $prev_id = $row['max_id'];

        if ($prev_id) {
            $stt = (int) substr($prev_id, 1) + 1;
        } else {
            $stt = 1;
        }

        $Cus_ID = sprintf("C%09d", $stt);

        $query = "insert into CUSTOMER values('$Cus_ID', '$Cus_Name', '$Cus_DOB', '$Cus_Gender', '$Cus_Address', '$Cus_Email', '$Cus_Phone')";
        sqlsrv_query($conn, $query);

        $query = "insert into CUSTOMER_ACCOUNT values('$username', '$Cus_ID', '$Cus_Pass', '1', null, null)";
        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);
    }

    function checkUserName($username): bool{
        $conn = open_Database();
        $query = "select * from CUSTOMER_ACCOUNT where UserName = '$username'";

        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        if($row){
            return true;
        }
        sqlsrv_close($conn);
        return false;
    }

    function checkEmail($email): bool{
        $conn = open_Database();
        $query = "select * from CUSTOMER where Customer_Email = '$email'";

        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        if($row){
            return true;
        }
        sqlsrv_close($conn);
        return false;
    }

    function checkPhone($phone): bool{
        $conn = open_Database();
        $query = "select * from CUSTOMER where Customer_Phone = '$phone'";

        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        if($row){
            return true;
        }
        sqlsrv_close($conn);
        return false;
    }

    // check
    function getProductsLimitSix(): array{
        $conn = open_Database();
        $data = array();
        $query = "select * from MOBILE_PRODUCT ORDER BY RAND() OFFSET 5 ROWS FETCH NEXT 7 ROWS ONLY";
        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data[] = $row;
        }
        sqlsrv_close($conn);
        return $data;
    }

    function getProductByProductID($product_ID): array{
        $conn = open_Database();
        $data = array();
        $query = "select * from MOBILE_PRODUCT where Product_ID = '$product_ID'";
        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data = $row;
        }
        sqlsrv_close($conn);
        return $data;
    }

    function checkLogin($username, $pass): bool {
        $conn = open_Database();
    
        $query = "SELECT * FROM CUSTOMER_ACCOUNT WHERE UserName = ? AND Account_Password = ?";
        $params = array($username, $pass);
        $stmt = sqlsrv_prepare($conn, $query, $params);
    
        if(sqlsrv_execute($stmt)) {
            if($row = sqlsrv_fetch_array($stmt)) {
                return true;
            }
        }
        sqlsrv_close($conn);
        return false;
    }

    function checkAccCodeForgot($code, $Cus_ID):bool{
        $conn = open_Database();
        $query = "select * from CUSTOMER_ACCOUNT
        where code_forgot_pass = '$code'
        and Customer_ID = '$Cus_ID'";

        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        if($row){
            return true;
        }
        sqlsrv_close($conn);
        return false;
    }

    function updateAccCodeForgot($code, $Cus_ID, $date){
        $conn = open_Database();
        $query = "update CUSTOMER_ACCOUNT
        set code_forgot_pass = '$code',
        Date_Create_Code_Forgot = '$date'
        where Customer_ID = '$Cus_ID'";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);
    }

    function getUser($username): array{
        $conn = open_Database();
        $data = array();
        $query = "select * from CUSTOMER, CUSTOMER_ACCOUNT
        where CUSTOMER.Customer_ID = CUSTOMER_ACCOUNT.Customer_ID
        and CUSTOMER_ACCOUNT.UserName = '$username'";
        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data = $row;
        }
        sqlsrv_close($conn);
        return $data;
    }

    function getCusByEmail($email){
        $conn = open_Database();
        $query = "select * from CUSTOMER, CUSTOMER_ACCOUNT 
        where Customer_Email = '$email' and
        CUSTOMER.Customer_ID = CUSTOMER_ACCOUNT.Customer_ID";
        $data = array();

        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data = $row;
        }
        
        sqlsrv_close($conn);
        return $data;
    }

    function updatePassWord($pass, $Cus_ID){
        $conn = open_Database();
        $query = "update CUSTOMER_ACCOUNT
        set Account_Password = '$pass'
        where Customer_ID = '$Cus_ID'";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);
    }

    function getCusIDByUserName($username):string{
        $conn = open_Database();
        $query = "select * from CUSTOMER_ACCOUNT
        where UserName = '$username'";
        $data = array();
        
        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data = $row;
        }
        sqlsrv_close($conn);
        return $data['Customer_ID'];
    }

    function checkPass($pass, $username): bool{
        $conn = open_Database();
        $query = "select * from CUSTOMER_ACCOUNT
        where Account_Password = '$pass' and UserName = '$username'";
        $data = array();
        
        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        while($row){
            return true;
        }
        sqlsrv_close($conn);
        return false;
    }

    function updateInfor($username, $name, $dob, $gender, $address, $email, $phone, $pass){
        $conn = open_Database();
        $cus_ID = getCusIDByUserName($username);
        // echo $cus_ID;
        $query = "update CUSTOMER
        set Customer_Name = '$name',
        CUSTOMER.Customer_Birth = '$dob',
        CUSTOMER.Customer_Gender = '$gender',
        CUSTOMER.Customer_Address = '$address',
        CUSTOMER.Customer_Email = '$email',
        CUSTOMER.Customer_Phone = '$phone'
        where CUSTOMER.Customer_ID= '$cus_ID'";

        sqlsrv_query($conn, $query);
        if($pass != null){
            $query = "update CUSTOMER_ACCOUNT
            set Account_Password = '$pass'
            where Customer_ID = '$cus_ID'";
            sqlsrv_query($conn, $query);
        }
        sqlsrv_close($conn);

    }

    function updateAccCodeForgotAgain($code, $Cus_ID){
        $conn = open_Database();
        $query = "update CUSTOMER_ACCOUNT
        set code_forgot_pass = '$code'
        where Customer_ID = '$Cus_ID'";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);
    }

    function checkCodeForgotIsEmpty($username): bool{
        $conn = open_Database();
        $query = "select * from CUSTOMER_ACCOUNT
        where code_forgot_pass is null 
        and UserName = '$username'";
        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        if($row){
            return true;
        }
        sqlsrv_close($conn);
        return false;
    }

    function deleteCodeForgotOutOfDay($username){
        if(!checkCodeForgotIsEmpty($username)){
            $conn = open_Database();
            $date = date('Y-m-d', strtotime("+1 day"));
            $query = "update CUSTOMER_ACCOUNT
            set code_forgot_pass = null
            where Date_Create_Code_Forgot = '$date'
            and UserName = '$username' ";
            sqlsrv_query($conn, $query);
            sqlsrv_close($conn);
        }
    }

    function updateCusLevel($username, $level){
        $conn = open_Database();
        $query = "update CUSTOMER_ACCOUNT
        set Customer_Level = '$level'
        where UserName = '$username'";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);
    }
    
    function getName($username): string{
        $conn = open_Database();
        $data = array();
        $query = "select * from CUSTOMER, CUSTOMER_ACCOUNT WHERE 
        CUSTOMER.Customer_ID = CUSTOMER_ACCOUNT.Customer_ID
        and CUSTOMER_ACCOUNT.UserName = '$username'";

        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data = $row;
        }
        sqlsrv_close($conn);
        return $data['Customer_Name'];
    }

    // ===============================<<important>>===============================

    function checkDateofMaxOrderListID($username): bool{
        $conn = open_Database();
        $max_order_list_id = getMaxOrderListID($username);
        $query = "select * from ORDER_LIST
        where Date_Created_OrderList is null 
        and UserName_Customer = '$username'
        and ORDER_LIST.OrderList_ID = '$max_order_list_id'";

        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        sqlsrv_close($conn);

        if($row){
            return true;
        }
        return false;
    }

    function getMaxOrderListID($username){
        $conn = open_Database();
        $query = "select max(OrderList_ID) as max_id from ORDER_LIST
        where Date_Created_OrderList is null 
        and UserName_Customer = '$username'";

        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data[] = $row;
        }
        sqlsrv_close($conn);
        return $data[0]['max_id'];
    }

    function deleteOrderListID($username){
        if(checkDateofMaxOrderListID($username)){
            $conn = open_Database();
            $max_order_list_id = getMaxOrderListID($username);
            $query = "delete from ORDER_LIST
            where UserName_Customer = '$username'
            and OrderList_ID = '$max_order_list_id'
            and Date_Created_OrderList is null";
    
            // echo $username;
            sqlsrv_query($conn, $query);
            sqlsrv_close($conn);
        }
    }

    function insertOrderList($username, $product_ID, $Quan, $total_money){
        if(!checkDateofMaxOrderListID($username)){
            $conn = open_Database();
            $query = "select max(OrderList_ID) as max_id from ORDER_LIST";
            $result = sqlsrv_query($conn, $query);
            $row = sqlsrv_fetch_array($result);
            $prev_id = $row['max_id'];

            if ($prev_id) {
                $stt = (int) substr($prev_id, 2) + 1;
            } else {
                $stt = 1;
            }

            $OrderList_ID = sprintf("OR%08d", $stt);
            
            $query = "insert into ORDER_LIST values('$OrderList_ID', null, '$username', null, null, null)";
            sqlsrv_query($conn, $query);
            sqlsrv_close($conn);

        }

        $OrderList_ID = getMaxOrderListID($username);
        insertOrderDetails($product_ID, $OrderList_ID, $Quan, $total_money);
        
    }

    function insertOrderDetails($product_ID, $OrderList_ID, $Quan, $total_money){
        $conn = open_Database();
        $query = "insert into ORDER_LIST_DETAILS values('$product_ID', '$OrderList_ID', '$Quan', null, '$total_money', null)";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);
    }

    function deleteOrderDetailsProduct($OrderList_ID, $product_ID){
        $conn = open_Database();
        $query = "delete from ORDER_LIST_DETAILS
        where OrderList_ID = '$OrderList_ID'
        and Product_ID = '$product_ID'";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);
    }

    function checkCusOrderDetails($username): bool{
        $conn = open_Database();

        $query = "select * from ORDER_LIST, ORDER_LIST_DETAILS
        where ORDER_LIST.OrderList_ID = ORDER_LIST_DETAILS.OrderList_ID
        and ORDER_LIST.UserName_Customer = '$username' 
        and ORDER_LIST.Date_Created_OrderList is null";

        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        if($row){
            return true;
        }

        return false;
    }  

    // ====================<<Order Confirm>>=====================

    function getProductInOrderListDetails($username):array{
        $conn = open_Database();
        $max_order_list_id = getMaxOrderListID($username);
        $query = "select * from ORDER_LIST_DETAILS, ORDER_LIST, MOBILE_PRODUCT
        where ORDER_LIST_DETAILS.OrderList_ID = ORDER_LIST.OrderList_ID
        and ORDER_LIST_DETAILS.Product_ID = MOBILE_PRODUCT.Product_ID
        and ORDER_LIST.Date_Created_OrderList is null
        and ORDER_LIST.UserName_Customer = '$username'
        and ORDER_LIST.OrderList_ID = '$max_order_list_id'";
        $data = array();

        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data[] = $row;
        }
        sqlsrv_close($conn);
        return $data;
    }

    function getProdutQuantity($product_ID): string{
        $conn = open_Database();
        $query = "select * from MOBILE_PRODUCT
        where Product_ID = '$product_ID'";
        $data = array();

        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data[] = $row;
        }
        sqlsrv_close($conn);
        return $data[0]['Product_Quantities'];
    }

    function getRemainProduct($product_ID, $Quan): string{
        $product_Quan = getProdutQuantity($product_ID);
        $remain_Quan = floatval($product_Quan) - floatval($Quan);
        return $remain_Quan;
    }

    // 1
    function updateMobileProduct($product_ID, $remain_Quan){
        $conn = open_Database();
        $query = "update MOBILE_PRODUCT
        set Product_Quantities = '$remain_Quan'
        where Product_ID = '$product_ID'";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);
    }

    // 2 (1, 2)
    function updateOrderDetailsList($order_ID, $product_ID, $Quan){
        $conn = open_Database();
        $remain_quan = intval(getRemainProduct($product_ID, $Quan));
        $delivery_date = date("Y-m-d", strtotime("+1 day"));
        $query = "update ORDER_LIST_DETAILS
        set Delivery_Date = '$delivery_date',
        Remain_Quantities = '$remain_quan'
        where OrderList_ID = '$order_ID'
        and Product_ID = '$product_ID'";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);

        updateMobileProduct($product_ID, $remain_quan);
    }

    // 3 (3, 4, 5)
    function insertInvoice($orderList_ID, $payment_ID){
        $conn = open_Database();
        $query = "select max(Invoice_ID) as max_id from INVOICE";
        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        $prev_id = $row['max_id'];
        $date_created = date('Y-m-d');

        if ($prev_id) {
            $stt = (int) substr($prev_id, 2) + 1;
        } else {
            $stt = 1;
        }

        $Invoice_ID = sprintf("IV%08d", $stt);

        $query = "insert into INVOICE 
        values('$Invoice_ID', '$orderList_ID', '$date_created', 'Completed')";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);

        insertTransaction($Invoice_ID, $payment_ID, $orderList_ID);
    }

    // 4
    function insertTransaction($Invoice_ID, $payment_ID, $orderList_ID){
        $conn = open_Database();
        $query = "select max(Transaction_ID) as max_id from [TRANSACTION]";
        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        $prev_id = $row['max_id'];
        $date_created = date('Y-m-d');

        if ($prev_id) {
            $stt = (int) substr($prev_id, 2) + 1;
        } else {
            $stt = 1;
        }

        $transaction_ID = sprintf("TR%08d", $stt);

        $query = "insert into [TRANSACTION] 
        values('$transaction_ID', '$payment_ID', '$date_created', 'Finished', '$Invoice_ID')";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);

        insertGoodDelivery($transaction_ID, $orderList_ID);
    }

    // 5
    function insertGoodDelivery($transaction_ID, $orderList_ID){
        $conn = open_Database();
        $query = "select max(Good_Delivery_ID) as max_id from [GOOD_DELIVERY]";
        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        $prev_id = $row['max_id'];
        $date_created = date('Y-m-d');

        if ($prev_id) {
            $stt = (int) substr($prev_id, 2) + 1;
        } else {
            $stt = 1;
        }

        $good_delivery_ID = sprintf("GD%08d", $stt);

        $query = "insert into [GOOD_DELIVERY] 
        values('$good_delivery_ID', '$transaction_ID', null, '$orderList_ID', '$date_created')";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);
    }

    // 6
    function updateOrderListDate($username){
        $conn = open_Database();
        $max_Order_ID = getMaxOrderListID($username);
        $date = date('Y-m-d');
        $query = "update ORDER_LIST
        set Date_Created_OrderList = '$date'
        
        where OrderList_ID = '$max_Order_ID'";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);
    }

    // ====================================================

    function updateOrderListNote($OrderList_ID, $Note){
        $conn = open_Database();
        $query = "update ORDER_LIST
        set Note = '$Note'
        
        where OrderList_ID = '$OrderList_ID'";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);
    }

    function getOrderList($orderList_ID):array{
        $conn = open_Database();
        $query = "select * from ORDER_LIST
        where OrderList_ID = '$orderList_ID'";

        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data = $row;
        }

        sqlsrv_close($conn);
        return $data;
    }

    function getOneOrderDetails($product_ID, $orderList_ID): array{
        $conn = open_Database();
        $query = "select * from ORDER_LIST_DETAILS
        where Product_ID = '$product_ID'
        and OrderList_ID = '$orderList_ID'";

        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data = $row;
        }

        sqlsrv_close($conn);
        return $data;
    }

    function checkOrderListToCheckGood($product_ID, $orderList_ID): bool{
        $conn = open_Database();
        $query = "select * from ORDER_LIST_DETAILS
        where Product_ID = '$product_ID'
        and OrderList_ID = '$orderList_ID'";

        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);

        if($row){
            return true;
        }

        sqlsrv_close($conn);
        return false;
    }

    function checkPayMentID($payment_ID): bool{
        $conn = open_Database();
        $query = "select * from PAYMENT_METHOD WHERE PaymentMethod_ID = ?";
        $params = array($payment_ID);
        $stmt = sqlsrv_prepare($conn, $query, $params);
    
        if(sqlsrv_execute($stmt)) {
            if($row = sqlsrv_fetch_array($stmt)) {
                return true;
            }
        }
        sqlsrv_close($conn);
        return false;
    }

    function checkOrder($username): bool{
        $conn = open_Database();

        $query = "select * from ORDER_LIST, ORDER_LIST_DETAILS
        where ORDER_LIST.OrderList_ID = ORDER_LIST_DETAILS.OrderList_ID
        and ORDER_LIST.UserName_Customer = '$username' 
        and ORDER_LIST.Date_Created_OrderList is not null";

        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        if($row){
            return true;
        }
        sqlsrv_close($conn);
        return false;
    }

    function getAllMyOrderDetails($username): array{
        $conn = open_Database();
        $data = array();
        $query = "select * from ORDER_LIST, ORDER_LIST_DETAILS, MOBILE_PRODUCT, TYPE_PRODUCT
        where ORDER_LIST.OrderList_ID = ORDER_LIST_DETAILS.OrderList_ID
        and ORDER_LIST.UserName_Customer = '$username'
        and ORDER_LIST.Date_Created_OrderList is not null
        and MOBILE_PRODUCT.Product_ID = ORDER_LIST_DETAILS.Product_ID
        and TYPE_PRODUCT.TypeProduct_ID = MOBILE_PRODUCT.TypeProduct_ID";

        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data[] = $row;
        }
        sqlsrv_close(($conn));
        return $data;
    }

    function checkProductOrderLIstDetails($orderList_ID, $product_ID): bool{
        $conn = open_Database();
        $query = "select * from ORDER_LIST_DETAILS 
        where OrderList_ID = '$orderList_ID'
        and Product_ID = '$product_ID'";
        $result = sqlsrv_query($conn, $query);
        $row = sqlsrv_fetch_array($result);
        sqlsrv_close($conn);
        if($row){
            return true;
        }
        return false;
    }

    function getPaymentMethod($payment_Name):string{
        $conn = open_Database();
        $query = "select * from PAYMENT_METHOD WHERE Method_Name = '$payment_Name'";

        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data[] = $row;
        }
        sqlsrv_close($conn);
        return $data[0]['PaymentMethod_ID'];
    }
    function getCustomerByUsername($username): array{
        $conn = open_Database();
        $data = array();
        $query = "select * from CUSTOMER, CUSTOMER_ACCOUNT WHERE 
        CUSTOMER.Customer_ID = CUSTOMER_ACCOUNT.Customer_ID
        and CUSTOMER_ACCOUNT.UserName = '$username'";

        $result = sqlsrv_query($conn, $query);
        while($row = sqlsrv_fetch_array($result)){
            $data = $row;
        }
        sqlsrv_close($conn);
        return $data;
    }

    function checkUserInPackage($username): bool{
        $conn = open_Database();
        $data = array();
        $query = "select * from ORDER_LIST where UserName_Customer = '$username'";
        $result = sqlsrv_query($conn, $query);
        if($row = sqlsrv_fetch_array($result)){
            return true;
        }
        sqlsrv_close($conn);
        return false;
    }


    function deleteOneURL(): string{
        $current_url = "http";
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $current_url .= "s";
        $current_url .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // echo $current_url;
        $url = $current_url;

        // Phân tích URL và chuỗi query
        $url_parts = parse_url($url);
        parse_str($url_parts['query'], $query_parts);
        unset($query_parts['productID']);

        $new_query_string = http_build_query($query_parts);

        // Tạo URL mới
        $new_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $new_query_string;
        return $new_url;
    }

    function deleteURL($name): string{
        $current_url = "http";
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $current_url .= "s";
        $current_url .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // echo $current_url;
        $url = $current_url;

        // Phân tích URL và chuỗi query
        $url_parts = parse_url($url);
        parse_str($url_parts['query'], $query_parts);
        unset($query_parts[$name]);

        $new_query_string = http_build_query($query_parts);

        // Tạo URL mới
        $new_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $new_query_string;
        return $new_url;
    }

    function createRandomCode($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $code;
    }
    

    function checkProductInOrderDetails($product_ID, $username):bool{
        $conn = open_Database();
        $max_Order_List_ID = getMaxOrderListID($username);
        $query = "select * from ORDER_LIST_DETAILS where 
        Product_ID = '$product_ID' and OrderList_ID = '$max_Order_List_ID'";

        $result = sqlsrv_query($conn, $query);

        $row = sqlsrv_fetch_array($result);
        if($row){
            return true;
        }
        sqlsrv_close($conn);

        return false;
    }


    function updateOrderDetailsForDuplicateProduct($product_ID, $username, $Quan, $Price){
        $conn = open_Database();
        $max_order_list_id = getMaxOrderListID($username);
        $order_list_details = getOneOrderDetails($product_ID, $max_order_list_id);
        // $Mobile_Product = getMobileProduct($product_ID);
        $order_list_price = $order_list_details["Total_Money"];
        

        $order_list_Quan = $order_list_details["Quantities"];
        $total = intval($order_list_Quan) + intval($Quan);
        
        $total_Money = floatval($order_list_price) + floatval($Price + $Quan);
        $query = "update ORDER_LIST_DETAILS
        set Quantities = '$total',
        Total_Money = '$total_Money'
        where Product_ID = '$product_ID'
        and OrderList_ID = '$max_order_list_id'";

        sqlsrv_query($conn, $query);
        sqlsrv_close($conn);
    }

    

    function getNewURL(): string{
        $current_url = "http";
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $current_url .= "s";
        $current_url .= "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // echo $current_url;
        $url = $current_url;

        // Phân tích URL và chuỗi query
        $url_parts = parse_url($url);
        // echo $url_parts;
        parse_str($url_parts['query'], $query_parts);

        // Xóa tất cả các phần tử trong mảng query
        foreach ($query_parts as $key => $value) {
            unset($query_parts[$key]);
        }

        // Tạo lại chuỗi query mới
        $new_query = http_build_query($query_parts);

        // Tạo lại URL với chuỗi query mới
        $new_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $new_query;
        return $new_url;
    }


    // function updateDB($username, $pass){
    //     $pass = md5($pass);
    //     $conn = open_Database();
    //     $query = "update CUSTOMER_ACCOUNT
    //     set Account_Password = '$pass' 
    //     where UserName = '$username'";

    //     sqlsrv_query($conn, $query);
    //     sqlsrv_close($conn);
    // }
    // updateDB('anhthy06', 'anhthy@123');
    // updateDB('phong2202', 'phong@123');
    // updateDB('tiendat09', 'dat@123');
    // Tiendat06, 123456
    // [code_forgot_pass]
    // ,[Date_Create_Code_Forgot]


?>

