<body>
    <?php
    if(isset($_SESSION['login_user'])){
        $username = $_SESSION['login_user'];
        $dataUser = getUser($username);
        $cus_Name = $dataUser['Customer_Name'];
        // $cus_DOB = $dataUser['Customer_Birth'];
        $date = new DateTime($dataUser['Customer_Birth']->format('Y-m-d'));
        $cus_DOB = $date->format('Y-m-d');

        $cus_Gender = $dataUser['Customer_Gender'];
        $cus_Address = $dataUser['Customer_Email'];
        $cus_Email = $dataUser['Customer_Email'];
        $cus_Phone = $dataUser['Customer_Phone'];
        
        ?>
    <div class="user--bg">
        <form action="" method="post">

            <div class="container p-5">
                <div class="row">
                    <h1 class="text-center w-100 text-white">USER ACCOUNT</h1>
        
                    <div class="form-group col-l-12 col-md-12 col-sm-12">
                        <p style="font-weight:bold;">Name</p>
                        <input class="w-100 p-3 user__inp" type="text" name="name" id="" value="<?= $cus_Name ?>">
                    </div>
        
                    <div class="form-group col-l-12 col-md-12 col-sm-12">
                        <p style="font-weight:bold;">DOB</p>
                        <input class="w-100 p-3 user__inp" type="date" name="dob" id="" value="<?= $cus_DOB ?>">
                    </div>
        
                    <div class="form-group col-l-12 col-md-12 col-sm-12">
                        <p style="font-weight:bold;">Gender(Male or Female)</p>
                        <input class="w-100 p-3 user__inp" type="text" name="gender" id="" value="<?= $cus_Gender ?>">
                    </div>
        
                    <div class="form-group col-l-12 col-md-12 col-sm-12">
                        <p style="font-weight:bold;">Address</p>
                        <input class="w-100 p-3 user__inp" type="text" name="address" id="" value="<?= $cus_Address ?>">
                    </div>
        
                    <div class="form-group col-l-12 col-md-12 col-sm-12">
                        <p style="font-weight:bold;">Email</p>
                        <input class="w-100 p-3 user__inp" type="text" name="email" id="" value="<?= $cus_Email ?>">
                    </div>
        
                    <div class="form-group col-l-12 col-md-12 col-sm-12">
                        <p style="font-weight:bold;">Phone number</p>
                        <input class="w-100 p-3 user__inp" type="text" name="phone" id="" value="<?= $cus_Phone ?>">
                    </div>

                    <div class="form-group col-l-12 col-md-12 col-sm-12">
                        <p style="font-weight:bold;">Current Password</p>
                        <input class="w-100 p-3 user__inp" type="text" name="c_pass" id="" value="">
                    </div>

                    <div id="change_pass" onclick="changePassClick()" class=" form-group col-l-12 col-md-12 col-sm-12">
                        <p style="border-radius: 10px; font-size:1.3rem; font-weight:bold; color:#000;cursor:pointer;" class="">Change password?</p>
                    </div>

                    <div id="change_content" class="d-none col-l-12 col-md-12 col-sm-12">
                        
                        <div class="form-group">
                            <p style="font-weight:bold;">New Password</p>
                            <input class="w-100 p-3 user__inp" type="text" name="n_pass" id="" value="">
                        </div>
    
                        <div class="form-group">
                            <p style="font-weight:bold;">Re-enter Password</p>
                            <input class="w-100 p-3 user__inp" type="text" name="r_pass" id="" value="">
                        </div>
                    </div>

                    <?php
                    
                        if(isset($_POST['btn_save'])){
                            
                            $gender = strtolower($_POST['gender']);
                            if(!checkPass(md5($_POST['c_pass']), $username)){
                                ?>
                                    <p style="font-weight: bold;" class="text-danger text-center w-100">Please enter current password correctly</p>
                                <?php
                            }

                            else if($gender != 'male' && $gender != 'female'){
                                ?>
                                    <p style="font-weight: bold;" class="text-danger text-center w-100">Please enter gender information correctly</p>
                                <?php
                            }
                            
                            else if(!empty($_POST['name']) && !empty($_POST['dob']) 
                            && !empty($_POST['gender']) && !empty($_POST['address']) 
                            && !empty($_POST['email']) && !empty($_POST['phone'])
                            && !empty($_POST['c_pass']) && !empty($_POST['n_pass'])
                            && !empty($_POST['r_pass'])){
                                if($_POST['n_pass'] != $_POST['r_pass']){
                                    ?>
                                        <p style="font-weight: bold;" class="text-danger text-center w-100">Please enter new password correctly</p>
                                    <?php
                                }else{
                                    $name = $_POST['name'];
                                    $dob = $_POST['dob'];
                                    $gender = ucwords($_POST['gender']);
                                    $address = $_POST['address'];
                                    $email = $_POST['email'];
                                    $phone = $_POST['phone'];
                                    $pass = $_POST['n_pass'];
                                    updateInfor($username, $name, $dob, $gender, $address, $email, $phone, md5($pass));
                                    ?>
                                        <p style="font-weight: bold;" class="text-success text-center w-100">Update information completely</p>
                                    
                                    <?php
                                }
                            } 
                            else if(!empty($_POST['name']) && !empty($_POST['dob']) 
                            && !empty($_POST['gender']) && !empty($_POST['address']) 
                            && !empty($_POST['email']) && !empty($_POST['phone'])
                            && !empty($_POST['c_pass'])){
                                
                                $name = $_POST['name'];
                                $dob = $_POST['dob'];
                                $gender = ucwords($_POST['gender']);
                                $address = $_POST['address'];
                                $email = $_POST['email'];
                                $phone = $_POST['phone'];
                                updateInfor($username, $name, $dob, $gender, $address, $email, $phone, null);
                                ?>
                                    <p style="font-weight: bold;" class="text-success text-center w-100">Update information completely</p>
                                
                                <?php

                            }
                            
                            else{
                                ?>
                                    <p style="font-weight: bold;" class="text-danger text-center w-100">Please enter full informations</p>
                                <?php
                            }
                        }
                        
                    ?>
        
                    <div class="form-group col-l-12 col-md-12 col-sm-12 mt-5 text-center">
                        <button name="btn_save" style="font-size: 1.5rem; border-radius: 10px;" class="btn btn-success p-3 w-25" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
        <?php
    }
    ?>
    
</body>

<script>
    function changePassClick(){
        let change_btn = document.getElementById('change_pass');
        let change_content =document.getElementById('change_content');

        if(change_content.classList.contains('d-none')){
            change_content.classList.remove('d-none');
        }else if(!change_content.classList.contains('d-none')){
            change_content.classList.add('d-none');
        }
    }
</script>