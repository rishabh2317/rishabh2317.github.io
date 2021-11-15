<?php
session_start();
ob_start();


require_once 'api.php';


$accesskey = 'ak_live_32xEwQT0COE8t81XvBBD76WzJ2juj2mV7hcz';
$secretkey = 'sk_live_8zC9y3L1Zl4zOk2XDKvJ932fpLVUxEu5gWhv';



$fullname = $_POST['name'];
$mobile_number = $_POST['mobile_number'];
$email = $_POST['email'];
$type = "virtual";
$used_as ="collection_tool";
$create_vpa = true;
$state_code = 'KA';
$city = 'Bangalore';
$postal_code = 683101;
$business_category = 'agri_business';
$business_type = 'individual';
$pan = 'EQKPM7093F';
$metadata = $_POST['metada'];



$data = [
                'name' => $fullname,
                'mobile_number' => $mobile_number,
                'email'  => $email,
                'type' => $type,
                'used_as' => $used_as,
                'create_vpa' => $create_vpa,
	'metadata' => $metadata,
                'kyc' => [
                'state_code' => $state_code,
                'business_category' => $business_category,
                'city' => $city,
				'business_type' => $business_type,
                'postal_code' => $postal_code,
                'pan' => $pan
                  ],
         ];




//main logic

$api = new Api($accesskey,$secretkey);
$response_data = $api->create_account($data);
   


?>

<script type="text/javascript">

function getbalance(self) {

	//console.log($(self).data('accountsId'))
	var id = $(self).data('accountsId')
	
	$.ajax({  
				type: "POST",  
				url: "api.php?get_balance=true",  
				data: {
					"_token": "{{ csrf_token() }}",
					'id':id,
					
				},  
				success: function(datas) 
				{ 
					

					var response=JSON.parse(datas);
					$("#balance").html(response.amount);
					

					
				}
			});

}


 </script>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ZWITCH ACCOUNTS</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script src="<?php echo $remote_script; ?>"></script>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" >

</head>
<style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

button {
    box-sizing: border-box;
    min-height: 40px;
    min-width: 115px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    padding: 0 35px;
    border: none;
    cursor: pointer;
    background: #4236ff 0 0 no-repeat padding-box;
    box-shadow: 0 0 20px 0 rgb(0 0 0 / 20%);
    color: #fff;
    margin: auto;
    display: inherit;
}

input[type=button]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  background-color: #000000;
  padding: 20px;
}
label{
	color: #c7c7c7
}

body{
  font-family: sans-serif;
}

strong{
	color: #4236ff;
	min-width: 200px;
	display: inline-block;
}

h3{
	color: #c7c7c7
}

</style>
<body>
<div style="width: 600px;margin: auto;">
<h3> <center> Virtual Account Demo </span> </center></h3>

	<div class="dv">
		<label> <strong> Type: </strong> <?php echo $response_data['type']; ?></label>
	</div>

	<div class="dv">
		<label> <strong>Name: </strong> <?php echo $data['name']; ?></label>
	</div>
	<div class="dv">
		<label> <strong> E-mail: </strong> <?php echo $data['email']; ?></label>
	</div>

	<div class="dv">
		<label> <strong> Mobile Number: </strong><?php echo $data['mobile_number']; ?></label>
	</div>

	<div class="dv">
		<label> <strong> Bank Name: </strong> <?php echo $response_data['bank_name']; ?></label>
	</div>

	<div class="dv">
		<label> <strong> Account Number: </strong> <?php echo $response_data['account_number']; ?></label>
	</div>

	<div class="dv">
		<label> <strong> IFSC Code: </strong> <?php echo $response_data['ifsc_code']; ?></label>
	</div>

	<div class="dv">
		<label> <strong>  VPA: </strong> <?php echo $response_data['vpa']; ?></label>
	</div>

    <div class="dv">
    	<label> <strong>  QR: </strong></label>
		<img src="qr.png" style="    width: 10%;
    position: relative;">
	</div>
	

	
	<div class="dv">
		<label> <strong> Account Balance: </strong> <span id="balance"> 0 </span>  </label> 
	</div>

	
	<div class='dv'><button id="get_balance_btn" type='button' onclick='getbalance(this)' data-accounts-id=<?= $response_data['id']?> >Update Balance</button></div>

	
</div>
</body>
</html>

