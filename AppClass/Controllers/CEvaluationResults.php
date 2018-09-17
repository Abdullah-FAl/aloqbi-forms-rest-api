<?php


namespace AppClass\Controllers;
use Firebase\JWT\JWT;

class CEvaluationResults extends Base
{







    /*=============================================
=  Section of the Check your user name and password  =
=============================================*/


    /*=================={Fetch data from the link}================*/




    public function GetQuickEvaluationEmployee   ($request,$response,$args)
    {

        /*=================={Bring the user data from a database}================*/



        $employee_id   = (int)$args['employee_id'];



        $sql = "SELECT Emp.employee_id,	employee_name,employee_number,employee_job_name,  count(e_results) as count_results, e_results ,
        evaluation_date,DATE_FORMAT(evaluation_date, \"%Y-%m\") as evaluation_dateMon   FROM quick_evaluation_results AS quick 
           INNER JOIN employee AS Emp  ON Emp.employee_id = quick.employee_id
           WHERE Emp.employee_id = ? 
           GROUP BY  quick.e_results";

        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        $stmt->execute([$employee_id]);
        $sql_result = $stmt->fetchall();
        // exit Connect
        $db = null;


        return $response->withJson($sql_result,200);

    }















    /*=============================================
=  Section of the Check your user name and password  =
=============================================*/


    /*=================={Fetch data from the link}================*/




    public function GetEvaluationEmployeeTasksStandard   ($request,$response,$args)
    {

        /*=================={Bring the user data from a database}================*/



        $employee_id   = (int)$args['employee_id'];
        $tasks_id   = (int)$args['tasks_id'];


        $sql = "SELECT EResults.tasks_id, EResults.e_deta, EResults.e_results, strd.standard_id ,strd.standard_title FROM standard AS strd 
           INNER JOIN evaluation_results AS EResults  ON EResults.standard_id = strd.standard_id
           WHERE EResults.employee_id = :em and EResults.tasks_id = :tsk
           GROUP BY  strd.standard_id";

        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        $stmt->execute([ ':em'=>  $employee_id , ':tsk'=> $tasks_id ]);
        $sql_result = $stmt->fetchall();
        // exit Connect
        $db = null;


        return $response->withJson($sql_result,200);

    }













    /*=============================================
=  Section of the Check your user name and password  =
=============================================*/


    /*=================={Fetch data from the link}================*/




    public function GetEvaluationEmployeeTasks ($request,$response,$args){

     $employee_id   = (int)$args['employee_id'];


    $sql = "SELECT EResults.e_deta, AVG(EResults.e_results) as avg_results , task.tasks_id ,task.tasks_title FROM tasks AS task 
           INNER JOIN evaluation_results AS EResults  ON EResults.tasks_id = task.tasks_id
           WHERE EResults.employee_id = ?
           GROUP BY  task.tasks_id";

        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        $stmt->execute([   $employee_id]);
        $sql_result = $stmt->fetchall();
        // exit Connect
        $db = null;


        return $response->withJson($sql_result,200);



    }











        /*=============================================
        =  Section of the Check your user name and password  =
        =============================================*/


    /*=================={Fetch data from the link}================*/




    public function AddNewEvaluationResultsData   ($request,$response) {


            $userData = $request->getParsedBody();



//
//        employee_id
//        tasks_id
//        e_results
//



        /*=================={Bring the user data from a database}================*/


        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();



        $E_R = $userData['e_results'];
        $employee_id = $userData['employee_id'];
        $tasks_id   = $userData['tasks_id'];

        foreach ($E_R as $arrkey){



            $sql2 = "INSERT INTO evaluation_results (employee_id,tasks_id,standard_id,e_results) 
                    VALUES (:emp_id,:tsk_id,:stadr_id,:rslt)";
            //sql prepare
            $stmt = $db->prepare($sql2);

            $stmt->bindParam(':emp_id',$employee_id);
            $stmt->bindParam(':tsk_id',$tasks_id);
            $stmt->bindParam(':stadr_id',$arrkey['standard_id']);
            $stmt->bindParam(':rslt', $arrkey['standard_results']);
            $sql_result = $stmt->execute();
            


        }


        // exit Connect
        $db = null;


        return $response->withJson( $userData ,201);

    }










    public function AddNewQuickEvaluationResultsData   ($request,$response) {


        $userData = $request->getParsedBody();
        $E_R = $userData['qe_results'];
        $employee_id = $userData['employee_id'];

//
//        employee_id
//        e_results
//


        /*=================={Bring the user data from a database}================*/


        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();





            $sql = "INSERT INTO quick_evaluation_results (employee_id,e_results)
                     VALUES (:emp_id,:rslt)";
            //sql prepare
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':emp_id',$employee_id);
            $stmt->bindParam(':rslt',  $E_R);
            $sql_result = $stmt->execute();

            // exit Connect
            $db = null;


        return $response->withJson( $userData ,201);

    }














    }