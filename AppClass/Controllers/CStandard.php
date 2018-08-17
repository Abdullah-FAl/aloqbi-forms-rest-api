<?php


namespace AppClass\Controllers;
use Firebase\JWT\JWT;

class CStandard extends Base
{



private  $user_id;





    /*=============================================
=  Section of the Check your user name and password  =
=============================================*/


    /*=================={Fetch data from the link}================*/




    public function GetAllStandardInfo   ($request,$response)
    {

        /*=================={Bring the user data from a database}================*/


        $sql = "SELECT * FROM standard ";

        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $sql_result = $stmt->fetchall();
        // exit Connect
        $db = null;


        return $response->withJson($sql_result,200);

    }













    /*=============================================
=  Section of the Check your user name and password  =
=============================================*/


    /*=================={Fetch data from the link}================*/




    public function GetStandardInfo   ($request,$response){


        

    }











        /*=============================================
        =  Section of the Check your user name and password  =
        =============================================*/


    /*=================={Fetch data from the link}================*/




    public function AddNewStandardInfo   ($request,$response) {


            $userData = $request->getParsedBody();



        /*=================={Bring the user data from a database}================*/


        $sql = "INSERT INTO standard (standard_title,standard_description) VALUES (:stnrd_name,:stnrd_description)";


        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':stnrd_name',$userData['standard_title']);
        $stmt->bindParam(':stnrd_description',$userData['standard_description']);
        $stmt->execute();
        $sql_result = 'تمت الإضافة';
        // exit Connect
        $db = null;

        return $response->withJson($sql_result,201);

    }














    /*=============================================
=  Section of the Check your user name and password  =
=============================================*/


    /*=================={Fetch data from the link}================*/




    public function UpdateStandardInfo ($request, $response)
    {




        $userData = $request->getParsedBody();



        /*=================={Bring the user data from a database}================*/


        $sql = "UPDATE  standard SET standard_title = :stnrd_title,standard_description = :stnrd_description
                WHERE standard_id = :stnrd_id";


        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':stnrd_id',$userData['standard_id']);
        $stmt->bindParam(':stnrd_title',$userData['standard_title']);
        $stmt->bindParam(':stnrd_description',$userData['standard_description']);
        $sql_result = $stmt->execute();
        // exit Connect
        $db = null;



        $responsedata = array([

            'cod'  => 200,
            'data' =>$sql_result

        ]);

        return $response->withJson($responsedata,200);


    }














    /*=============================================
=  Section of the Check your user name and password  =
=============================================*/


    /*=================={Fetch data from the link}================*/




    public function DeleteStandardInfo ($request, $response)
    {


        $userData = $request->getParsedBody();


        /*=================={Bring the user data from a database}================*/



        $sql = "DELETE FROM standard WHERE standard_id = ?";


        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        $sql_result = $stmt->execute([$userData['standard_id']]);
        // exit Connect
        $db = null;


        return $response->withJson($sql_result , 202);


    }



    }