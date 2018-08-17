<?php


namespace AppClass\Controllers;


/**
 * 
 * 
 * 
 * 
 */

class CRoleBasedAccess extends Base{





/**
 * 
 * 
 * 
 * 
 */
public function getuserPermission($request,$response){


   $userid = $request->getParsedBody();





    $sql = 'SELECT * FROM permissions WHERE ';
        
    // Get DB Object
    $db = $this->db;
    // Connect
    $db = $db->connect();
    //sql prepare
    $stmt = $db->prepare($sql);
    $stmt->execute([]);
    //sql result of query
    $sql_result = $stmt->fetchall();
    // exit Connect
    $db = null;



$result = array(
    'messageEN'=> 'Operation Success: User data was found',
    'massageAR'=> 'العملية نجاحة :تم إيجاد  بيانات المستخدم المطلوب',
    'data'=> $sql_result,
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
public function addPermission(){


    // Get DB Object
    $db = $this->db;
    // Connect
    $db = $db->connect();
    //sql strign
    $sql = "INSERT INTO users (user_name,user_password)
            VALUES (:u_name,:u_password)";
    //sql prepare
    $stmt = $db->prepare($sql);
   // $stmt->bindParam(':u_name',$user['user_name'] );
    $stmt->execute();

     // //query sql 
     $user_name1 = $user['user_name'];
    $sql = "SELECT user_id , user_name FROM users WHERE  user_name =   '$user_name1'  ";
    $stmt = $db->query($sql);

    $sql_result = $stmt->fetchall();
     // exit Connect
    $db = null;



}







}