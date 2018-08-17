<?php


namespace AppClass\Controllers;
use Firebase\JWT\JWT;

class CTasks extends Base
{



private  $user_id;





    /*=============================================
=  Section of the Check your user name and password  =
=============================================*/


    /*=================={Fetch data from the link}================*/




    public function GetAllTasksInfo   ($request,$response)
    {

        /*=================={Bring the user data from a database}================*/


        $sql = "SELECT * FROM tasks ";

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




    public function GetStandardOfTasks   ($request,$response,$args){

     $task_id   = (int)$args['tasks_id'];


    $sql = "SELECT tasks.tasks_id,tasks.tasks_title,standard.standard_id , standard.standard_title FROM standard AS standard
           INNER  JOIN tasks_standard AS ts ON standard.standard_id = ts.standard_id 
           INNER  JOIN tasks AS tasks ON ts.tasks_id = tasks.tasks_id
           WHERE ts.tasks_id = ?";

        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        $stmt->execute([$task_id]);
        $sql_result = $stmt->fetchall();
        // exit Connect
        $db = null;


        return $response->withJson($sql_result,200);



    }











        /*=============================================
        =  Section of the Check your user name and password  =
        =============================================*/


    /*=================={Fetch data from the link}================*/




    public function AddNewTasksInfo   ($request,$response) {


            $userData = $request->getParsedBody();



        /*=================={Bring the user data from a database}================*/


        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();





        $sql = "INSERT INTO tasks (tasks_title,tasks_description) VALUES (:task_name,:task_description)";
        //sql prepare
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':task_name',$userData['tasks_title']);
        $stmt->bindParam(':task_description',$userData['tasks_description']);
        $stmt->execute();
        $lastId = $db->lastInsertId();



        foreach ($userData['standard_id'] as $arrkey){


            $sql2 = "INSERT INTO tasks_standard (tasks_id,standard_id) VALUES (:task_id,:stndr_id)";
            //sql prepare
            $stmt = $db->prepare($sql2);
            $stmt->bindParam(':task_id',$lastId);
            $stmt->bindParam(':stndr_id',$arrkey);
            $sql_result = $stmt->execute();



        }


        // exit Connect
        $db = null;

        return $response->withJson( $sql_result,201);

    }














    /*=============================================
=  Section of the Check your user name and password  =
=============================================*/


    /*=================={Fetch data from the link}================*/




    public function UpdateTasksInfo ($request, $response)
    {




        $userData = $request->getParsedBody();



        /*=================={Bring the user data from a database}================*/

        $sql1 = "UPDATE  tasks SET tasks_title = :task_title,tasks_description = :task_description WHERE tasks_id = :task_id";


        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql1);
        $stmt->bindParam(':task_id',$userData['tasks_id']);
        $stmt->bindParam(':task_title',$userData['tasks_title']);
        $stmt->bindParam(':task_description',$userData['tasks_description']);
        $sql_result = $stmt->execute();





        //sql prepare
        $sql2 = "DELETE FROM tasks_standard WHERE tasks_id = ?";
        $stmt = $db->prepare($sql2);
        $sql_resultofdelaet = $stmt->execute([$userData['tasks_id']]);





        if($sql_resultofdelaet){

        foreach ($userData['standard_id'] as $arrkey) {


            $sql2 = "INSERT INTO tasks_standard (tasks_id,standard_id) VALUES (:task_id,:stndr_id)";
            //sql prepare
            $stmt = $db->prepare($sql2);
            $stmt->bindParam(':task_id', $userData['tasks_id']);
            $stmt->bindParam(':stndr_id', $arrkey);
            $sql_result = $stmt->execute();

        }

        }







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




    public function DeleteTasksInfo ($request, $response)
    {


        $userData = $request->getParsedBody();


        /*=================={Bring the user data from a database}================*/




        $sql = "DELETE FROM tasks WHERE tasks_id = ?";

        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        $sql_result = $stmt->execute([$userData['tasks_id']]);
        // exit Connect
        $db = null;


        return $response->withJson($sql_result , 202);


    }










    }