<?php


namespace AppClass\Controllers;


class CEmployee extends Base
{






    /*=============================================
=  Section of the Check your user name and password  =
=============================================*/


    /*=================={Fetch data from the link}================*/




    public function GetAllEmployeeInfo   ($request,$response){

        /*=================={Bring the user data from a database}================*/


        $SERVER_path = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . "$_SERVER[CONTEXT_PREFIX]";
        $ifnull= "";

$sql2 = "SELECT TEpm.employee_id,
                TEpm.employee_name ,
                TEpm.employee_number,
                TEpm.employee_job_name,
                TEpm.employee_email,
                TEpm.employee_phone_number, 
                LOWER(CONCAT('$SERVER_path',COALESCE(TEpmF.file_path, '')))  AS file_path FROM employee AS TEpm 
                LEFT  JOIN employee_files AS TEpmF ON TEpmF.employee_id = TEpm.employee_id  
               
                GROUP BY  TEpm.employee_id";

        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql2);
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




    public function GetEmployeeTasks   ($request,$response,$args)
    {

        $employee_id   = (int)$args['employee_id'];
        /*=================={Bring the user data from a database}================*/


        $sql = "SELECT * FROM tasks  AS TTsk INNER JOIN  employee_tasks AS TEpmTsk 
              ON TTsk.tasks_id = TEpmTsk.tasks_id 
              WHERE TEpmTsk.employee_id = ?";

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




    public function GetEmployeeInfo   ($request,$response){

    }













        /*=============================================
        =  Section of the Check your user name and password  =
        =============================================*/


    /*=================={Fetch data from the link}================*/




    public function AddNewEmployeeInfo   ($request,$response) {


         $uploadedFiles = $request->getUploadedFiles();
         $parsedBody = $request->getParsedBody();
         

        /*=================={Bring the user data from a database}================*/



        $sql = "INSERT INTO employee 
                (employee_name,employee_number,employee_job_name,employee_email,employee_phone_number)
                VALUES (:emp_name,:emp_number,:emp_job_name,:emp_email,:emp_phone_number)";


        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':emp_name',$parsedBody['employee_name']);
        $stmt->bindParam(':emp_number',$parsedBody['employee_number']);
        $stmt->bindParam(':emp_job_name',$parsedBody['employee_job_name']);
        $stmt->bindParam(':emp_email',$parsedBody['employee_email']);
        $stmt->bindParam(':emp_phone_number',$parsedBody['employee_phone_number']);
        $sql_result1 = $stmt->execute();
        $epmID = $db->lastInsertId();
        // exit Connect
        $db = null;


        if($sql_result1) {

           $afteraddfiles = $this->addEmployeeFiles($uploadedFiles,$epmID);
           if (!empty($parsedBody['employee_tasks_ids']) ){

               foreach ($parsedBody['employee_tasks_ids'] as $Taskid) {

                   $sql = "INSERT INTO employee_tasks 
                                   (employee_id,tasks_id)
                            VALUES (:emp_id,:tsk_id)";


                   // Get DB Object
                   $db = $this->db;
                   // Connect
                   $db = $db->connect();
                   //sql prepare
                   $stmt = $db->prepare($sql);
                   $stmt->bindParam(':emp_id', $epmID);
                   $stmt->bindParam(':tsk_id', $Taskid);
                   $sql_result2 = $stmt->execute();


               }


           }


        }
        // exit Connect
        $db = null;
        return $response->withJson($sql_result2,201);

    }














    /*=============================================
=  Section of the Check your user name and password  =
=============================================*/


    /*=================={Fetch data from the link}================*/




    public function UpdateEmployeeInfo ($request, $response)
    {



                        $uploadedFiles = $request->getUploadedFiles();
                        $parsedBody = $request->getParsedBody();
                        $epmID      =  (int)$parsedBody['employee_id'];

                    

                    /*=================={Bring the user data from a database}================*/


                    $sql = "UPDATE  employee 
                    SET employee_name      = :emp_name, 
                    employee_number        = :emp_number,
                    employee_job_name      = :emp_job_name,
                    employee_email         = :emp_email,
                    employee_phone_number  = :emp_phone_number
                    WHERE employee_id      = :emp_id";


                    // Get DB Object
                    $db = $this->db;
                    // Connect
                    $db = $db->connect();
                    //sql prepare
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':emp_id',$epmID);
                    $stmt->bindParam(':emp_name',$parsedBody['employee_name']);
                    $stmt->bindParam(':emp_number',$parsedBody['employee_number']);
                    $stmt->bindParam(':emp_job_name',$parsedBody['employee_job_name']);
                    $stmt->bindParam(':emp_email',$parsedBody['employee_email']);
                    $stmt->bindParam(':emp_phone_number',$parsedBody['employee_phone_number']);
                    $sql_result1 = $stmt->execute();
                    // exit Connect
                    $db = null;


                    if($sql_result1) {


                        $afteraddfiles = $this->UpdeatEmployeeFiles($uploadedFiles,$epmID);

                        if (!empty($parsedBody['employee_tasks_ids']) ){


                            $sql = "DELETE FROM employee_tasks WHERE employee_id = ?";
                                
                                    // Get DB Object
                                    $db = $this->db;
                                    // Connect
                                    $db = $db->connect();
                                    //sql prepare
                                    $stmt = $db->prepare($sql);
                                    $sql_result2 = $stmt->execute([$epmID]);

                                            if ($sql_result2) {
                                                foreach ($parsedBody['employee_tasks_ids'] as $Taskid) {
                                                    $sql = "INSERT INTO employee_tasks 
                                                                            (employee_id,tasks_id)
                                                                    VALUES (:emp_id,:tsk_id)";

                                                    //sql prepare
                                                    $stmt = $db->prepare($sql);
                                                    $stmt->bindParam(':emp_id', $epmID);
                                                    $stmt->bindParam(':tsk_id', $Taskid);
                                                    $sql_result2 = $stmt->execute();

                                                }
                                                    // exit Connect
                                                    $db = null;
                                            }
                        
                        
        
             }

       }




        // $responsedata = array([

        //     'cod'  => 200,
        //     'data' => $sql_result2

        // ]);

        //  return $response->withJson($responsedata,200);


    }














    /*=============================================
=  Section of the Check your user name and password  =
=============================================*/


    /*=================={Fetch data from the link}================*/




    public function DeleteEmployeeInfo ($request, $response)
    {


        $userData = $request->getParsedBody();
        $epmID = (int) $userData['employee_id'];

        /*=================={Bring the user data from a database}================*/



        $sql = "DELETE FROM employee WHERE employee_id = ?";


        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        $sql_result = $stmt->execute([$epmID]);
        // exit Connect
        $db = null;

        $this->deleteEmployeeFiles($epmID);


        return $response->withJson($sql_result , 202);


    }















    //// add epm img !!!
    ///

    private  function   addEmployeeFiles($uploadedFilesarry,$epmID){



        if (!empty($uploadedFilesarry['employeeimgfile'])) {

                // handle single input with multiple file uploads
                foreach ($uploadedFilesarry['employeeimgfile'] as $uploadedfile) {
                            
                    if ($uploadedfile->getError() === UPLOAD_ERR_OK) {

                        $md5Hash = md5($epmID.time());
                        $directory = $this->upload_directory;
                        $file_name = $uploadedfile->getClientFilename();
                        $parts     = explode('.', $file_name);
                        $file_ext  = end($parts);
                        $uploadedfile->moveTo(  realpath($directory). '/employee/img/' . $md5Hash . $epmID .'.'.$file_ext);
                        $file_type = $uploadedfile->getClientMediaType();
                        $directoryroot = "/uploads/employee/img/";
                        $file_path = $directoryroot . $md5Hash . $epmID .'.'.$file_ext;

                            
                        // Get DB Object
                        $db = $this->db;
                        // Connect
                        $db = $db->connect();

                        $sql4 = "INSERT INTO employee_files (employee_id,file_name,file_type,file_path)
                                VALUES (:emp_id,:f_name,:f_type,:f_path)";


                        //sql prepare
                        $stmt = $db->prepare($sql4);
                        $stmt->bindParam(':emp_id', $epmID);
                        $stmt->bindParam(':f_name', $file_name);
                        $stmt->bindParam(':f_type', $file_type);
                        $stmt->bindParam(':f_path', $file_path);
                        $sql_result = $stmt->execute();



                    }}

        }else {

            $sql_result = false;
        }




                $db = null;

        return $sql_result;
    }




 //// updeat epm img
    ///

    private  function   UpdeatEmployeeFiles($uploadedFilesarry,$epmID){



        if (!empty($uploadedFilesarry['employeeimgfile'])) {

                // Get DB Object
                $db = $this->db;
                // Connect
                $db = $db->connect();

            $sql1 = "SELECT file_path FROM employee_files WHERE employee_id = ?";
                //sql prepare
                $stmt = $db->prepare($sql1);
                $stmt->execute([$epmID]);
               $sql_result4 = $stmt->fetch();
           
                if ($sql_result4) {
                    $parts     = explode('/', $sql_result4->file_path);
                    $file_name  = end($parts);
                    $directory = $this->upload_directory;
                    $file_for_delete =  realpath($directory). '/employee/img/'. $file_name;
     
                 

                 
                    if (file_exists($file_for_delete)) {
                        if (unlink($file_for_delete)) {



            // handle single input with multiple file uploads
                            foreach ($uploadedFilesarry['employeeimgfile'] as $uploadedfile) {
                                if ($uploadedfile->getError() === UPLOAD_ERR_OK) {
                                    $md5Hash = md5($epmID.time());
                                    $directory = $this->upload_directory;
                                    $file_name = $uploadedfile->getClientFilename();
                                    $parts     = explode('.', $file_name);
                                    $file_ext  = end($parts);
                                    $uploadedfile->moveTo(  realpath($directory. '/employee/img/' . $md5Hash . $epmID .'.'.$file_ext));
                                    $file_type = $uploadedfile->getClientMediaType();
                                    $directoryroot = "/uploads/employee/img/";
                                    $file_path = $directoryroot . $md5Hash . $epmID .'.'.$file_ext;
                
                                    $sql2 = "UPDATE  employee_files 
                                                SET 
                                                file_name              = :f_name, 
                                                file_type              = :f_type,
                                                file_path              = :f_path
                                                WHERE employee_id      = :emp_id";




                                                //sql prepare
                                                $stmt = $db->prepare($sql2);
                                                $stmt->bindParam(':emp_id', $epmID);
                                                $stmt->bindParam(':f_name', $file_name);
                                                $stmt->bindParam(':f_type', $file_type);
                                                $stmt->bindParam(':f_path', $file_path);
                                                $sql_result = $stmt->execute();
                                }
                            }
                        }
                    } else {
                      
                    }
                }else{
                  
                        // handle single input with multiple file uploads
                        foreach ($uploadedFilesarry['employeeimgfile'] as $uploadedfile) {
            
                            if ($uploadedfile->getError() === UPLOAD_ERR_OK) {
            
                                $md5Hash = md5($epmID.time());
                                $directory = $this->upload_directory;
                                $file_name = $uploadedfile->getClientFilename();
                                $parts     = explode('.', $file_name);
                                $file_ext  = end($parts);
                                $uploadedfile->moveTo(  realpath($directory). '/employee/img/' . $md5Hash . $epmID .'.'.$file_ext);
                                $file_type = $uploadedfile->getClientMediaType();
                                $directoryroot = "/uploads/employee/img/";
                                $file_path = $directoryroot . $md5Hash . $epmID .'.'.$file_ext;
            
            
            
                                $sql4 = "INSERT INTO employee_files (employee_id,file_name,file_type,file_path)
                                          VALUES (:emp_id,:f_name,:f_type,:f_path)";
            
                                //sql prepare
                                $stmt = $db->prepare($sql4);
                                $stmt->bindParam(':emp_id', $epmID);
                                $stmt->bindParam(':f_name', $file_name);
                                $stmt->bindParam(':f_type', $file_type);
                                $stmt->bindParam(':f_path', $file_path);
                                $sql_result = $stmt->execute();
            
            
            
                            }}




                }
           





        }else {
          
            $sql_result = false;
        }


       
                $db = null;
          

        return $sql_result;
    }









 //// updeat epm img
    ///

    private  function   deleteEmployeeFiles($epmID){


               // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();

        $sql1 = "SELECT file_path FROM employee_files WHERE employee_id = ?";
        //sql prepare
        $stmt = $db->prepare($sql1);
        $stmt->execute([$epmID]);
        $sql_result4 = $stmt->fetch();
          
        if ($sql_result4) {
            $parts     = explode('/', $sql_result4->file_path);
            $file_name  = end($parts);
            $directory = $this->upload_directory;
            $file_for_delete =  realpath($directory). '/employee/img/'. $file_name;


            if (file_exists($file_for_delete)) {
                if (unlink($file_for_delete)) {
                   
                    $sql2 = "DELETE  FROM employee_files WHERE employee_id = ?";
                    //sql prepare
                    $stmt = $db->prepare($sql2);
                    $res =  $stmt->execute([$epmID]);

                    $sql3 = "DELETE  FROM employee_tasks WHERE employee_id = ?";
                    //sql prepare
                    $stmt = $db->prepare($sql3);
                    $res =  $stmt->execute([$epmID]);
                    $db = null;
                }
            }




        }
    
       
        return $res;
    }










    }