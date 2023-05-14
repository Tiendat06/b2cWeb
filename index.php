<?php
    ob_start();
    session_start();
    
    require_once('./database/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href=""> -->
    <link rel="shortcut icon" href="./assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/font/fontawesome-free-6.1.1/css/all.min.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="./assets/css/grid.css">
    <link rel="stylesheet" href="./assets/css/head.css">
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/responsive.css">
    <script src="./assets/js/customer.js"></script>
    <title>Shopping</title>
</head>
<body>
    <!-- head -->
    <?php
        include('./includes/head/head.php');
    ?>

    <!-- content -->
    <?php
        if(isset($_GET['page'])){
            switch($_GET['page']){
                case "user_account": include('./page/customer/user_account.php');
                    break;
                case 'main_page': include('./page/customer/main_page.php');
                    break;
                case 'products': include('./page/customer/products.php');
                    break;
                case 'my_package': include('./page/customer/my_package.php');
                    break;
                case 'my_package_rm': include('./page/customer/package_model/my_package_rm.php');
                    break;
                case 'my_package_order': include('./page/customer/package_model/my_package_order.php');
                    break;
                case 'my_order': include('./page/customer/my_order.php');
                    break;
                case 'describe': include('./page/customer/describe.php');
                    break;
                case 'login': include('./page/login_signup/login.php');
                    break;
                case 'sign_up': include('./page/login_signup/signup.php');
                    break;
                case 'describe_add_package': include('./page/customer/describe_model/describe_add_package.php');
                    break;
                case 'check_goods': include('./page/customer/check_goods.php');
                    break;
                case 'check_goods_contact': include('./page/customer/check_good_model/check_goods_contact.php');
                    break;
                case 'forgot_pass': include('./page/login_signup/forgot_pass.php');
                    break;
                case 'forgot_pass_send_mail': include('./page/login_signup/forgot_pass_model/forgot_pass_send_mail.php');
                    break;
                case 'forgot_pass_change': include('./page/login_signup/forgot_pass_model/forgot_pass_change.php');
                    break;
                case 'vnpay': include('./vnpay_php/index.php');
                    break;
                default:
                    include('./page/customer/products.php');
                    break;
            }
        }else{
            include('./page/customer/products.php');
        }
    ?>
    <!-- footer -->
    <?php
        include('./includes/foot/foot.php');
    ?>  
</body>
</html>