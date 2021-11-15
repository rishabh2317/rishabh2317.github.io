<?php

$accesskey = 'ak_live_32xEwQT0COE8t81XvBBD76WzJ2juj2mV7hcz';
$secretkey = 'sk_live_8zC9y3L1Zl4zOk2XDKvJ932fpLVUxEu5gWhv';


 if(isset($_POST['id'])){

                      
  $api = new Api($accesskey,$secretkey);
  $balance_data = $api->get_balance($_POST['id']);
  print_r($balance_data);

                      
}

Class Api{

    const BASE_URL_UAT = "https://api.zwitch.io/v1";

    public function __construct($access_key,$secret_key){

        $this->access_key = $access_key;
        $this->secret_key = $secret_key;
    }

    public function create_account($data){

        try {
           
           
           if( $data['kyc']['state_code'] != NULL){
            $request_data = array(
            'name'   			=> (!empty($data['name']))? $data['name'] : NULL,
            'mobile_number' 	=> (!empty($data['mobile_number']))? $data['mobile_number'] : NULL,
            'email'     			=> (!empty($data['email']))? $data['email'] : NULL,
            'type' 			=> (!empty($data['type']))? $data['type'] : NULL,
            'used_as' 	=> (!empty($data['used_as']))?  $data['used_as'] : NULL,
            'create_vpa' 	=> (!empty($data['create_vpa']))?  $data['create_vpa'] : NULL,
		   'metadata' =>  (object)array(
            (!empty($data['metadata']['metadata']))?  $data['metadata']['metadata'] : NULL,),
            'kyc'   => (object)array(
            'business_type' =>  (!empty($data['kyc']['business_type']))?  $data['kyc']['business_type'] : NULL,
            'state_code' =>  (!empty($data['kyc']['state_code']))?  $data['kyc']['state_code'] : NULL,
            'business_category' =>  (!empty($data['kyc']['business_category']))?  $data['kyc']['business_category'] : NULL,
            'city' => (!empty($data['kyc']['city']))?  $data['kyc']['city'] : NULL,
            'postal_code' => (!empty($data['kyc']['postal_code']))?  $data['kyc']['postal_code'] : NULL,
            'pan' => (!empty($data['kyc']['pan']))?  $data['kyc']['pan'] : NULL,
              ),  

            );
        }else{

            $request_data = array(
            'name'              => (!empty($data['name']))? $data['name'] : NULL,
            'mobile_number'     => (!empty($data['mobile_number']))? $data['mobile_number'] : NULL,
            'email'                 => (!empty($data['email']))? $data['email'] : NULL,
            'type'          => (!empty($data['type']))? $data['type'] : NULL,
            'used_as'   => (!empty($data['used_as']))?  $data['used_as'] : NULL,
		'metadata' =>  (object)array(
            (!empty($data['metadata']['metadata']))?  $data['metadata']['metadata'] : NULL,),		    
            'kyc'   => (object)array(
                'business_category' =>  (!empty($data['kyc']['business_category']))?  $data['kyc']['business_category'] : NULL,
            ),  
        );


        }

            $accounts_response = $this->http_post($request_data,"accounts");

            return $accounts_response;
        } catch (Exception $e){			
            return [
                'error' => $e->getMessage()
            ];

        } catch (Throwable $e){
			
			return [
                'error' => $e->getMessage()
            ];
        }
    }


    public function get_balance($data){

        try {
           

            $balance_response = $this->get_accounts_balance("accounts/".$data."/balance");
            return $balance_response;
        } catch (Exception $e){         
            return [
                'error' => $e->getMessage()
            ];

        } catch (Throwable $e){
            
            return [
                'error' => $e->getMessage()
            ];
        }
    }







    
    function build_auth(){

        return array(                       
            'Content-Type: application/json',                                 
            'Authorization: Bearer '.$this->access_key.':'.$this->secret_key            
        );

    }


    function http_post($data,$route){

        $data = array_filter($data);

        // foreach (@$data as $key=>$value){

        //     if(empty($data[$key])){

        //         unset($data[$key]);
        //     }
        // }
 
        $url = self::BASE_URL_UAT."/".$route;
       
        $header = $this->build_auth();
        
        try
        {
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode($data),
              CURLOPT_HTTPHEADER =>$header,
            ));

            $response = curl_exec($curl);
            
            curl_close($curl);
            
            return json_decode($response,true);
        }
        catch(Exception $e)
        {
            return [
                "error" => "Http Post failed.",
                "error_data" => $e->getMessage(),
            ];
        }           
        
    }



    function get_accounts_balance($route){

     
        $url = self::BASE_URL_UAT."/".$route;
       
        $header = $this->build_auth();
        
        try
        {
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER =>$header,
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // $curlerr = curl_error($curl);
        
            
            // if($curlerr != '')
            // {
            //     return [
            //         "error" => "Http Post failed.",
            //         "error_data" => $curlerr,
            //     ];
            // }
            return $response;
        }
        catch(Exception $e)
        {
            return [
                "error" => "Http Post failed.",
                "error_data" => $e->getMessage(),
            ];
        }           
        
    }

   
}
