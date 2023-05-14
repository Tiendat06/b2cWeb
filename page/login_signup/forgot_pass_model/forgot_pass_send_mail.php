<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    if(!empty($_SESSION['email'])){
        
        if(isset($_GET['email'])){
            $email = $_GET['email'];
            $_SESSION['email'] = $email;

            $email = $_SESSION['email'];

            $dataCus = getCusByEmail($email);

            $cus_ID = $dataCus['Customer_ID'];
            $cus_Name = $dataCus['Customer_Name'];

            require './Library/PHPMailer/src/Exception.php';
            require './Library/PHPMailer/src/PHPMailer.php';
            require './Library/PHPMailer/src/SMTP.php';
            echo 'hi';

            // die();
            
            sendMail($email, $cus_Name, $cus_ID);
            header('location: '.deleteURL('email'));
            
        }else{
            $email = $_SESSION['email'];
            // echo $email;
            $dataCus = getCusByEmail($email);

            $cus_ID = $dataCus['Customer_ID'];
            $cus_Name = $dataCus['Customer_Name'];
            $_SESSION['cus_ID'] = $cus_ID;
            // echo $cus_ID;
        }
    
?>
    <body>
        <form action="" method="post">
            <div class="bg--outside">
                <div class="container p-5 send-mail__container">
                    <div class="row text-light">
                        <h1 class="send-mail__title text-center  col-l-12 col-md-12 col-sm-12">Account Verification</h1>

                        <div class="send-mail__content col-l-12 col-md-12 col-sm-12 text-center">
                            <p class="send-mail__content--para">Please enter the verification code sent via email</p>
                            <input type="text" class="send-mail__inp" name="send-mail__inp" id="">

                            <?php
                                if(isset($_POST['send-mail__btn--verify'])){
                                    if(!empty($_POST['send-mail__inp'])){
                                        $code = $_POST['send-mail__inp'];
                                        if(checkAccCodeForgot($code, $cus_ID)){
                                            // 
                                            header('location: index.php?page=forgot_pass_change');
                                        }else{
                                            echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Invalid code !</p>";
                                        }

                                    }else{
                                        echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>Please enter your code !</p>";
                                    }

                                }else if(isset($_POST['send-mail__btn--resend'])){
                                    echo "<p class='col-l-12 col-md-12 col-sm-12' style='color: red; font-weight: bold; text-align:center;'>New code has been resent !</p>";
                                    header('location: index.php?page=forgot_pass_send_mail&email='.$email);
                                }
                            ?>

                            <div class="send-mail__btn">
                                <button name="send-mail__btn--verify" class="bg-success send-mail__btn--verify">Verify</button>
                                <a href="?page=forgot_pass_send_mail&email=<?= $email ?>" name="send-mail__btn--resend" class="bg-success send-mail__btn--resend">Resend</a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="container">

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
        </form>
    </body>
<?php
    }else{
        header('location: ?page=products');
    }
?>

<?php
    function sendMail($email, $cus_Name, $cus_ID){
        //Create an instance; passing true enables exceptions
        $mail = new PHPMailer(true);
            
        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'tiendat79197@gmail.com';                     //SMTP username
            $mail->Password   = 'aoweoeqwqvxdnppy';                               //SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587; // TCP port to connect to
            $mail->CharSet = 'UTF-8';
            $mail->ContentType = 'text/plain'; 
        
            //Recipients
            $mail->setFrom('tiendat79197@gmail.com', 'Gr10_CNPM_send');
            $mail->addAddress($email, $cus_Name);     //Add a recipient
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML

            $random_code = createRandomCode(8);
            $date = date('Y-m-d');
            updateAccCodeForgot($random_code, $cus_ID, $date);
            $mail->Subject = 'Forgot Pasword Code';
            $mail->Body    = '<b>Your code: </b>'.$random_code;
        
            $mail->send();
            // echo 'Message has been sent';
            // header();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

?>

