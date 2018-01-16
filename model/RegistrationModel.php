<?php
	/**
	 * @author - Thilak ramu
	 * @description - save users 
	 *
	 */    
    require "../App.php";
    
    if(isset($_POST['submit'])) {
        try {            
            $username=htmlentities($_POST['uname']);
            $password=htmlentities($_POST['password']);
            $email=htmlentities($_POST['email']);
            $mobile=htmlentities($_POST['mobile']);
            $user_role=$_POST['user_role'];
            $roleAccess = ROLE_FLAG;
            $roleDenied = 'false';
            //validation            
			if ($email == "") {
                $_SESSION['error']="Email cannot be empty";
                header('Location:../signup.php');return;
            }
            if (!preg_match('/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/',$email)) {
                $_SESSION['error']="Invalid Email";
                header('Location:../signup.php');return;
            }
            if ($mobile == "") {
                $_SESSION['error']="Mobile number cannot be empty";
                header('Location:../signup.php');return;
            }
			$len = strlen($mobile);
			if ($len != 10) {
                $_SESSION['error']="Mobile number should be 10 digits";
                header('Location:../signup.php');return;
            }
            
            if ($username == "") {
                $_SESSION['error']="User Name cannot be empty";
                header('Location:../signup.php');return;
            }            
            if ($password == "") {
                $_SESSION['error']="Password cannot be empty";
                header('Location:../signup.php');return;
            }         
            if($user_role == "") {                
                $_SESSION['error']="User Role must be Selected";
                header('Location:../signup.php');return;    
            }
            //print_r($user_role);die;
            //connection & insertion
            $rs=array();
            $conn = App::getConnection();
            $exist = oci_parse($conn, "SELECT * FROM USERS WHERE USERNAME=:username");
			oci_bind_by_name($exist, ':username' , $username);
            oci_execute($exist);            
            $c = oci_num_rows($exist);            
            if ($c  == 0 ) {
                $state = oci_parse($conn, 'INSERT INTO USERS (EMAIL,MOBILE,USERNAME,PASSWORD,REVIEWER,PROOF_READER,PROOF_ADMIN) VALUES (:email , :mobile, :uname , :pass  , :reviewer, :pfreader, :pfadmin)');
                oci_bind_by_name($state, ':uname' , $username);
                oci_bind_by_name($state, ':pass' , $password);
                oci_bind_by_name($state, ':email' , $email);
                oci_bind_by_name($state, ':mobile' , $mobile);
                oci_bind_by_name($state, ':reviewer' ,  $roleDenied);
                oci_bind_by_name($state, ':pfreader' ,  $roleDenied);
                oci_bind_by_name($state, ':pfadmin' ,  $roleDenied);
                
                foreach($user_role as $role) {                  
                   
                   if($role == 'Reviewer') {                       
                       oci_bind_by_name($state, ':reviewer' ,  $roleAccess);                       
                   }
                   else if($role == 'Proof Reader') {                       
                       oci_bind_by_name($state, ':pfreader' ,  $roleAccess);                       
                   }
                   else if($role == 'Proof Admin') {                       
                       oci_bind_by_name($state, ':pfadmin' ,  $roleAccess);                       
                   }
                    
                }                   
               
                $res = oci_execute($state);
                if(!$res) {
                     $_SESSION['error']="Registration failed! Enter valid values";
                    header('Location:../signup.php');return; 
                }else{
					$_SESSION['success'] = 'User Registered Successfully';
                    header('Location:../login.php');return;    
                }    
            }
            
            else {
               $_SESSION['error']="User Name already exists!";
                header('Location:../signup.php');return;
            }
            
            App::closeConnection($conn, $state);
        }
        catch(Exception $ex){
            echo 'Occured Exception -', $ex->getMessage(), "\n";
        }
    }