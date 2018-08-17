<?php


namespace AppClass\Controllers;


/**
 * 
 * 
 * 
 * 
 */

class CUserGroup extends Base{







/**
 * 
 * 
 * 
 * 
 */
public function getallGroup($request,$response){


    $gnmae = $request->getParsedBody();

    $sql = 'SELECT * FROM usersgroup ';
    
        
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
        'messageEN'=> 'Operation Success: The new user data was added',
        'massageAR'=> 'العملية نجاحة :  كافة بيانات المجموعات ',
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
public function getGroupByID($request,$response,$args){


    $gnmae = $args;

    // Get DB Object
    $db = $this->db;
    // Connect
    $db = $db->connect();
    // sql strign query
    $sql = 'SELECT * FROM usersgroup  WHERE group_id = ?';
    //sql prepare
    $stmt = $db->prepare($sql);
    $stmt->execute([$gnmae['group_id']]);
    //sql result of query
    $sql_result = $stmt->fetchall();
    // exit Connect
    $stmt = null;
    $db   = null;



    $result = array(
        'messageEN'=> 'Operation Success: The new user data was added',
        'massageAR'=> 'العملية نجاحة :  كافة بيانات المجموعة ',
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
public function addGroup($request,$response){


$gnmae = $request->getParsedBody();



// var_dump($headerValueString);
// die();


   // Get DB Object
   $db = $this->db;
   // Connect
  $db = $db->connect();
   //sql strign
   $sql = "INSERT INTO usersgroup (group_name)
           VALUES (:g_name)";
   //sql prepare
   $stmt = $db->prepare($sql);
   $stmt->bindParam(':g_name',$gnmae['group_name'] );
   $sql_result = $stmt->execute();

   $stmt = null;
   $db   = null;


   $result = array(
    'messageEN'=> 'Operation Success: The new user data was added',
    'massageAR'=> 'العملية نجاحة :تمت إضافة  بيانات المجموعة الجديد',
    'data'=> $sql_result,
    'code'=> 201

        );

return $response->withJson( $result,$result['code']);


}




/**
 * 
 * 
 * 
 * 
 */
public function addToGroup($request,$response){




}





}