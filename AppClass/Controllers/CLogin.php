<?php


namespace AppClass\Controllers;
use Firebase\JWT\JWT;

class CLogin extends Base{



public function loginON($request,$response){


/*=============================================
=  Section of the Check your user name and password  =
=============================================*/


 /*=================={Fetch data from the link}================*/


 $user_name0     = $request->getParam('user_name');
 $user_password = $request->getParam('user_password');



 if( !$this->isemty( $user_name0,$user_password )){
    $result = array(
        'messageEN'=> 'Error!! No text to process',
        'messageAR'=> 'خطأ!! لايوجد نص لمعالجته ',
        'Properties'=> 'user_name,user_password',
        'code'=> 400,

            );

return $response->withJson( $result,$result['code']);
 }else

 $user = $this->getuserdata($user_name0);

if($user === false){

    $result = array(
        'messageEN'=> 'Error!! This user is not found! ',
        'messageAR'=> 'خطأ!! هذا المستخدم غير موجد ',
        'Properties'=> 'user_name',
        'code'=> 404

            );

return $response->withJson( $result,$result['code']);


}else if($this->passwordverify($user_password ,$user) === false){


    $result = array(
        'messageEN'=> 'Error !! Password not valid ',
        'messageAR'=> 'خطأ !! كلمة المرور ليست صالحة ',
        'Properties'=> 'user_password',

        'code'=> 406,

            );

return $response->withJson( $result,$result['code']);


}else{


    $result = array(
        'messageEN'=> 'Operation Success: Access Allowed',
        'messageAR'=> 'العملية نجاحة :الوصول مسموح',
        'token'=> $this->getnewToken($user),
        'code'=> 200,



    );



return $response->withJson(  $result,$result['code']);



}





}

public function loginOFF(){


return 'off';

}








protected function isemty($valu,$user_password){

/*=================={Make sure the data is not empty}================*/

$ciks = $valu;

if($ciks !== null || empty($ciks))
$ciks = $user_password;
if($ciks !== null || empty($ciks))

return $ciks;
   


   }







   protected function getuserdata($user_name){


/*=================={Bring the user data from a database}================*/


$sql = "SELECT * FROM users WHERE user_name  = ?";

      

    // Get DB Object
    $db = $this->db;
    // Connect
    $db = $db->connect();
    //sql prepare
    $stmt = $db->prepare($sql);
    $stmt->execute([$user_name]);
    $sql_result = $stmt->fetchall();
    // exit Connect
    $db = null;





if( $sql_result[0]->user_name !== $user_name){
    
    return $sql_result = false;
}else{
    return $sql_result;
}



}











 protected function passwordverify($password,$hash_pwd){

/*======{Check the password in the database => $hash_pwd ـ/ $user_password0 }===========*/

    $hash_pss  = $hash_pwd[0]->user_password;
    
  return password_verify($password,$hash_pss);


}








protected function getnewToken($userdata){

$user=array(
    'user_id'=>   $userdata[0]->user_id,
    'user_name'=> $userdata[0]->user_name,
    'user_fullname'=> $userdata[0]->user_fullname,
    'user_levelname'=> $userdata[0]->user_levelname,


);


/*=================={token}================*/      
            // Get your service account's email address and private key from the JSON key file  
            $key = $_ENV["tokenapi"];

            $alg ='HS512';
            $service_account_email = "abdullahfal@aloqbi.com";
            $Audience_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            date_default_timezone_set('Asia/Riyadh');
			$time_now_seconds = time();
            
            // aud: "https://contoso.onmicrosoft.com/scratchservice",
            // iss: "https://sts.windows.net/b9411234-09af-49c2-b0c3-653adc1f376e/",
            // iat: 1416968588,
            // nbf: 1416968588,
            // exp: 1416972488,




                    $expdata =   date('Y-m-d g:i a',$time_now_seconds + (60*60));
                    $tokdata =  date('Y-m-d g:i a',$time_now_seconds );

                    $ip = 'ip=>'.$this->getRealIpAddr();

			$payload = array (
                    'iss' => $_SERVER['HTTP_HOST'],///The issuer of the token // Configures the issuer (iss claim)                
                    'aud' => $Audience_link,        /// The audience of the token // Configures the audience (aud claim)
                    'iat' => (int) date($time_now_seconds), // Time when token was created 	Issued-at time // Configures the time that the token was issue (iat claim)
                    'nbf'=> $time_now_seconds,
                    'exp' => $time_now_seconds + (60*60),  // Expiration time (+1 hour) // Maximum expiration time is one hour 	Expiration time
                    'tokdata'=> $tokdata,
                    'expdata' => $expdata,// Configures the expiration time of the token (exp claim)
                    'tid'=> hash('ripemd160',$ip) ,
                    'userId' =>  $user['user_id'],///The unique identifier
                    'sub' => $_ENV["appname"] .'.login',///	The subject of the token // Configures the time that the token was issue (iat claim)
                    'roles'=>array ('admin') ,
                    'data' => array ( // Aditional data
					'user' => $user
                    )
			);





$jwt= JWT::encode ($payload,$key);



return $jwt;


}







private function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}






}