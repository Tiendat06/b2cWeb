<body>

<?php
    if(isset($_GET['Pr']) && isset($_GET['Or'])){
        if(checkOrderListToCheckGood($_GET['Pr'], $_GET['Or'])){
            $_SESSION['Product_ID'] = $_GET['Pr'];
            $_SESSION['OrderList_ID'] = $_GET['Or'];
            header('location: '.getNewURL().'page=check_goods');
        } else{
            header('location: index.php?page=my_order');
        }
    }else{
        $product_ID = $_SESSION['Product_ID'];
        $OrderList_ID = $_SESSION['OrderList_ID'];
        $dataOD = getOneOrderDetails($product_ID, $OrderList_ID);
        $Quan = $dataOD['Quantities'];
        // $delivery_date = $dataOD['Delivery_Date'];
        $date = new DateTime($dataOD['Delivery_Date']->format('Y-m-d'));
        $delivery_date = $date->format('d-m-Y');
        $total_money = $dataOD['Total_Money'];

    }

    $text_success_confirm = '';
    $text_success_wait = '';
    $text_success_delivery = '';
    $text_success_evaluate = '';

    $bd_success_confirm = '';
    $bd_success_wait = '';
    $bd_success_delivery = '';
    $bd_success_evaluate = '';

    $bg_success_wait = '';
    $bg_success_delivery = '';
    $bg_success_evaluate = '';

    if($delivery_date > date('d-m-Y')){
        $text_success_confirm = 'text-success';
        $bd_success_confirm = 'border-success';
    }
    if($delivery_date == date('d-m-Y')){
        $text_success_confirm = 'text-success';
        $bd_success_confirm = 'border-success';

        $text_success_wait = 'text-success';
        $bd_success_wait = 'border-success';

        $bg_success_wait = 'bg-success';
    }
    if($delivery_date < date('d-m-Y')){
        $text_success_confirm = 'text-success';
        $bd_success_confirm = 'border-success';

        $text_success_wait = 'text-success';
        $bd_success_wait = 'border-success';

        $text_success_delivery = 'text-success';
        $bd_success_delivery = 'border-success';

        $bg_success_delivery = 'bg-success';

    }
    if($delivery_date == date("d-m-Y", strtotime("-3 day"))){
        $text_success_confirm = 'text-success';
        $bd_success_confirm = 'border-success';

        $text_success_wait = 'text-success';
        $bd_success_wait = 'border-success';

        $text_success_delivery = 'text-success';
        $bd_success_delivery = 'border-success';

        $text_success_evaluate = 'text-success';
        $bd_success_evaluate = 'border-success';

        $bg_success_evaluate = 'bg-success';

    }
?>

    <div class="container p-5">
        <div class="row">
            
            <div class="check-goods__content col-l-12 col-md-12 col-sm-12">
                
                <div class="<?= $bd_success_confirm ?> check-goods__items check-goods__content--confirm">
                    <i class="<?= $text_success_confirm ?> check-goods__icon col-l-12 col-md-12 col-sm-12 fa-solid fa-file-lines"></i></br>
                    <span class="<?= $text_success_confirm ?> check-goods__span check-goods__invoice">Invoice has been confirmed</p>
                </div> 

                <div class=" <?= $bg_success_wait ?> check-goods__progress"></div>

                <div class="<?= $bd_success_wait ?> check-goods__items check-goods__content--waiting">
                    <i class="<?= $text_success_wait ?> check-goods__icon col-l-12 col-md-12 col-sm-12 fa-sharp fa-solid fa-truck"></i></br>
                    <span class="<?= $text_success_wait ?> check-goods__span check-goods__waiting">Waiting to pick up</p>
                </div> 

                <div class=" <?= $bg_success_delivery ?> check-goods__progress"></div>


                <div class="<?= $bd_success_delivery ?> check-goods__items check-goods__content--delivery">
                    <i class="<?= $text_success_delivery ?> check-goods__icon col-l-12 col-md-12 col-sm-12 fa-sharp fa-solid fa-truck-fast"></i></br>
                    <span class="<?= $text_success_delivery ?> check-goods__span check-goods__delivery">Item is being shipped</p>
                </div> 

                <div class=" <?= $bg_success_evaluate ?> check-goods__progress"></div>

                <div class="<?= $bd_success_evaluate ?> check-goods__items check-goods__content--delivery">
                    <i class="<?= $text_success_evaluate ?> check-goods__icon col-l-12 col-md-12 col-sm-12 fa-solid fa-star"></i></br>
                    <span class="<?= $text_success_evaluate ?> check-goods__span check-goods__delivery">Evaluate</p>
                </div>

                <?php 
                    if(date('d-m-Y') <= $delivery_date){
                        $dataOL = getOrderList($OrderList_ID);
                        $note = $dataOL['Note'];
                    ?>

                <div class="check-goods__contact col-l-12 col-md-12 col-sm-12">
                    <div class="check-good__contact--info">
                        <!-- <p class="check-goods__contact--title"></p> -->
                        
                        
                        <textarea oninput="onInputNote()" class="check-goods__note" placeholder="Note here before 23h59 <?= $delivery_date ?>" name="" id="note" cols="40" rows="5"><?= $note ?></textarea>
                                
                    </div>
                    
                    <a id="contact_btn" class="check-goods__btn bg-success text-light" href="?page=check_goods_contact&note=">Contact seller</a>
                    <?php
                        }
                    ?>
                </div>
            </div>

        </div>  
    </div>
</body>

<script>
    function onInputNote(){
        let noteVal =document.getElementById('note').value;
        let contact_btn =document.getElementById('contact_btn');
        contact_btn.href = `?page=check_goods_contact&note="${noteVal}"`;
    }
</script>