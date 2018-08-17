<?php


namespace AppClass\Controllers;
use Firebase\JWT\JWT;

class CEmployee extends Base
{






    /*=============================================
=  Section of the Check your user name and password  =
=============================================*/


    /*=================={Fetch data from the link}================*/




    public function GetAllEmployeeInfo   ($request,$response)
    {

        /*=================={Bring the user data from a database}================*/


//        employee_id": null,
//        "employee_name": "مهند صبيح",
//        "employee_number": "0",
//        "employee_job_name": "",
//        "employee_email": "",
//        "employee_phone_number": "0",
//        "file_id": null,
//        "file_name": null,
//        "file_type": null,
//        "file_path": null
//

$sql = "SELECT TEpm.employee_id,TEpm.employee_name ,TEpm.employee_number,TEpm.employee_job_name,
            TEpm.employee_email,TEpm.employee_phone_number, IFNULL(TEpmF.file_path,'') AS file_path
                FROM employee AS TEpm 
                  LEFT OUTER JOIN employee_files AS TEpmF ON TEpm.employee_id = TEpmF.employee_id  
                 GROUP BY  TEpm.employee_id";

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

//        employeeimgfile
//        employee_id
//        employee_name
//        employee_number
//        employee_job_name
//        employee_tasks_id
//        employee_email
//        employee_phone_number
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




        $userData = $request->getParsedBody();



        /*=================={Bring the user data from a database}================*/


        $sql = "UPDATE  employee SET employee_name = :emp_name WHERE employee_id = :emp_id";


        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':emp_id',$userData['employee_id']);
        $stmt->bindParam(':emp_name',$userData['employee_name']);
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




    public function DeleteEmployeeInfo ($request, $response)
    {


        $userData = $request->getParsedBody();


        /*=================={Bring the user data from a database}================*/



        $sql = "DELETE FROM employee WHERE employee_id = ?";


        // Get DB Object
        $db = $this->db;
        // Connect
        $db = $db->connect();
        //sql prepare
        $stmt = $db->prepare($sql);
        $sql_result = $stmt->execute([$userData['employee_id']]);
        // exit Connect
        $db = null;


        return $response->withJson($sql_result , 202);


    }















    //// add epm img
    ///

    private  function   addEmployeeFiles($uploadedFilesarry,$epmID){

      //  var_dump($uploadedFilesarry,$epmID);

        if (!empty($uploadedFilesarry['employeeimgfile'])) {

            //     ["file"]=>  string(36)
//     ["name":protected]=>   string(10) "sheikh.png"
//     ["type":protected]=>   string(9) "image/png"
//     ["size":protected]=>   int(2458892)
//     ["error":protected]=>  int(0)
//     ["sapi":protected]=>   bool(true)
//     ["stream":protected]=> NULL
//     ["moved":protected]=>  bool(false)

// getStream()
// getSize()
// getError()
// getClientFilename()
// getClientMediaType()




            // handle single input with multiple file uploads
            foreach ($uploadedFilesarry['employeeimgfile'] as $uploadedfile) {

                if ($uploadedfile->getError() === UPLOAD_ERR_OK) {

                    $md5Hash = md5(time());
                    $directory = $this->upload_directory;
                    $file_name = $uploadedfile->getClientFilename();
                    $parts     = explode('.', $file_name);
                    $file_ext  = end($parts);
                    $uploadedfile->moveTo($directory . '/employee/img/' . $md5Hash . $epmID .'.'.$file_ext);
                    $file_type = $uploadedfile->getClientMediaType();
                    $SERVER_path = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/uploads/employee/img/";
                    $file_path = $SERVER_path . $md5Hash . $epmID .'.'.$file_ext;


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



                }

            }

        }else {

            $sql_result = false;
        }




                $db = null;

        return $sql_result;
    }









    }