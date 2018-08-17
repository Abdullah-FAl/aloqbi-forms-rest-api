<?php


namespace AppClass\Controllers;


class CUsers extends Base{

/**
 * 
 * 
 * 
 * 
 */


public function addUser($request,$response){

/*

get the new user dete 
*/

$user =  $request->getParsedBody();

if(trim($user['user_name']) == '' ||  trim($user['user_password']) == '' ){
    $result = array(
        'messageEN'=> 'Error!! No text to process',
        'messageAR'=> 'خطأ!! لايوجد نص لمعالجته ',
        'Properties'=> $user ,
        'code'=> 400,

            );

 return $response->withJson( $result,$result['code']);



}else if($this->checkUserExists($user)) {

    $result = array(
        'messageEN'=> 'Error!! Username already exists ',
        'messageAR'=> 'خطأ!! اسم المستخدم موجود بالفعل ',
        'Properties'=> 'user_name',
        'code'=> 409

            );

return $response->withJson( $result,$result['code']);


}//end if


else{

    // Get DB Object
    $db = $this->db;
    // Connect
   $db = $db->connect();

 $hes = password_hash($user['user_password'],PASSWORD_DEFAULT);





 //sql strign
    $sql = "INSERT INTO users (user_name,user_password)
            VALUES (:u_name,:u_password)";
    //sql prepare
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':u_name',$user['user_name'] );
    $stmt->bindParam(':u_password', $hes );
    $stmt->execute();

     // //query sql 
     $user_name1 = $user['user_name'];
    $sql = "SELECT user_id , user_name FROM users WHERE user_name =   ?  ";
    $stmt = $db->query($sql);
    $stmt->execute([$user_name1]);
    $sql_result = $stmt->fetchall();
     // exit Connect
    $stmt = null;
    $db = null;







$result = array(
    'messageEN'=> 'Operation Success: The new user data was added',
    'massageAR'=> 'العملية نجاحة :تمت إضافة  بيانات المستخدم الجديد',
    'data'=> $sql_result,
    'code'=> 201

        );

return $response->withJson( $result,$result['code']);





}






}


/**
 * 
 * 
 * 
 * 
 */




// $vavl = '';
// var_dump($vavl);
// die();

public function updateUser($request,$response,$args){

    $user =   $request->getParsedBody();
    $hes = password_hash($user['user_password'],PASSWORD_DEFAULT);


    // Get DB Object
    $db = $this->db;
    // Connect
    $db = $db->connect();
    //sql strign
    $sql = 'UPDATE users SET user_name = :u_name ,user_password = :u_password  WHERE user_id  = :u_id';
    //sql prepare
    $stmt = $db->prepare($sql);
    //user id for SQL WHERE
    $sql_user_id = $args['user_id'];
    $stmt->bindParam(':u_id',$sql_user_id);
    $stmt->bindParam(':u_name',$user['user_name'] );
    $stmt->bindParam(':u_password',$hes);
    $stmt->execute();
 
    //

    $sql2 = "SELECT user_name , user_id FROM users WHERE user_id  = ?";
    //sql prepare
    $stmt = $db->prepare($sql2);
    $stmt->execute([$sql_user_id]);
   //sql result of query
   $sql_result2 = $stmt->fetch();
    // exit Connect
    $stmt = null;
    $db   = null;



$result = array(
    'messageEN'=> 'Operation Success: User data was updaete',
    'massageAR'=> 'العملية نجاحة :تم تحديث  بيانات المستخدم ',
    'data'=>   $sql_result2,
    'code'=> 200

        );

return $response->withJson( $result,$result['code']);


}





/**
 * 
 * 
 * 
 * 
 */


public function deleteUser($request,$response,$args){


    // Get DB Object
     $db = $this->db;
     // Connect
    $db = $db->connect();
    //sql strign
    $sql = "DELETE  FROM users WHERE user_id  = ?";
    //user id for SQL WHERE
    $sql_user_id = $args['user_id'];
    //sql prepare
    $stmt = $db->prepare($sql);
   $sql_result2 =  $stmt->execute([$sql_user_id]);
     // exit Connect
     $stmt = null;
     $db   = null;

    $result = array(
        'messageEN'=> 'Operation Success: User data was updaete',
        'massageAR'=> 'العملية نجاحة :تم حذف  بيانات المستخدم ',
        'isdelete'=>   $sql_result2,
        'code'=> 200
    
            );
    
    return $response->withJson( $result,$result['code']);
    


}













public function getUserById($request,$response,$args){

   

    if($this->checkUserExists($args)) {

        $result = array(
            'messageEN'=> 'Error!! ID of Username Not exists ',
            'messageAR'=> 'خطأ!! معرف اسم المستخدم غير موجود ',
            'Properties'=> 'user_id',
            'code'=> 404
    
                );
    
    return $response->withJson( $result,$result['code']);
            }


            else  {  


       $sql = 'SELECT user_id, user_name FROM users WHERE user_id  = :u_id';
    
        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        //user id for SQL WHERE
        $user_id = $args['user_id'];
        $stmt->execute(['u_id' => $user_id]);
        //sql result of query
        $sql_result = $stmt->fetch();
        // exit Connect
        $stmt = null;
        $db   = null;
    
    

    $result = array(
        'messageEN'=> 'Operation Success: User data was found',
        'massageAR'=> 'العملية نجاحة :تم إيجاد  بيانات المستخدم المطلوب',
        'data'=> $sql_result,
        'code'=> 200
    
            );
    
    return $response->withJson( $result,$result['code']);

        }
    
    
    
    
    }






    public function getAllUsers($request,$response){

   
           $sql = 'SELECT user_id,user_name,user_jobname,user_level,user_levelname FROM users';
        
            // Get DB Object
            $db = $this->db;
            // Connect
            $db = $db->connect();
            //sql prepare
            $stmt = $db->prepare($sql);
            $stmt->execute();
            //sql result of query
            $sql_result = $stmt->fetchall();
            // exit Connect
            $stmt = null;
            $db   = null;
        
        
    
        $result = array(
            'messageEN'=> 'Operation Success: User data was found',
            'massageAR'=> 'العملية نجاحة :تم إيجاد  بيانات المستخدم المطلوب',
            'data'=> $sql_result,
            'code'=> 200
        
                );
        
        return $response->withJson( $result,$result['code']);
    
            
        
        
        
        
        }
        









    public function checkUserExists($userdata){


    
        if($userdata){
        
        
        
        $sql = "SELECT user_name FROM users WHERE user_name  = :u_name OR user_id = :u_id";
        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        //user name for SQL WHERE
        $sql_name = $userdata['user_name'];
        $user_id = $userdata['user_id'];
        $stmt->execute(['u_name' => $sql_name,'u_id' => $user_id]);
        //sql result of query
        $sql_result = $stmt->fetch();
        // exit Connect
        $stmt = null;
        $db   = null;


           $sql1 = $sql_result->user_name;
           $sql2 = $userdata['user_name'];
        

        
        return ($sql1 == $sql2)? true : false ;
        
        }else{
        
            return  false ;
        
        }
        
        
        
        
        }
        
        
        







}