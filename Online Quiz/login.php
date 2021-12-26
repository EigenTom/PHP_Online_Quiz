<?php
    $con= new mysqli('localhost','root','root','quizdb')or die("Could not connect to mysql".mysqli_error($con));
	session_start();

	if(isset($_SESSION["email"])) {
		session_destroy();
	}
	
	$ref=@$_GET['q'];		
	if (isset($_POST['submit'])) {	
		$email = $_POST['email'];
		$email = stripslashes($email);
		$email = addslashes($email);
		$email = mysqli_real_escape_string($con,$email);

        $password = $_POST['password'];
        $password = stripslashes($password); 
		$password = addslashes($password);
		$password = mysqli_real_escape_string($con,$password);					
        
		$str = "SELECT * FROM user WHERE user_id='$email' AND password='$password'";
		$result = mysqli_query($con,$str);
        
		if((mysqli_num_rows($result))!=1) {
            echo "<center><h3><script>alert('Incorrect User Nickname or Password.');</script></h3></center>";
			header("refresh:0.5;url=login.php");
		} else {
            $row=mysqli_fetch_array($result);
			
            $_SESSION['logged']=$email;
			$_SESSION['email']=$row[0];
            $_SESSION['id']=$row[0];
            $_SESSION['name']=$row[1];
            $_SESSION['password']=$row[2];
			$_SESSION['isStaff']=$row[3];
			
            header('location: welcome.php?q=1'); 					
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=390, initial-scale=1">
    <title>Welcome to Online Quiz System</title>
    
    <style>
        body{
				font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
				height: 100vh;
				margin: 0;
				background-color: #333;
				user-select: none;
            	-webkit-user-select: none;
                background-repeat: no-repeat;
                background-size: cover;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0;
			}
        .navigator{
            position: fixed;
            top: 0;
            /*background-color: linear-gradient(to-bottom, black, rgba(0, 0, 0, 0));*/
            background-color: white;
            width: 100%;
            height: 56px;
            z-index:999;
            color: #1f1e33;
            transition: .2s ease;
        }
        .navigator.active{
            background-color: rgb(0, 68, 107, 0.9);
        }

        ul{
            margin: 0;
            padding: 0;
        }
        li{
            list-style-type: none;
            display: inline;
            float: left;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-size: 18px;
            font-weight: 800;
            padding-left: 20px;
            padding-right: 20px;
            line-height: 60px;
            
        }
        li:hover{
            color: rgb(30, 0, 138);
            opacity: 80%;
        }

        .loginForm {
            position: relative;
            display: flex;
            
            align-items: center;
            justify-content: center;
            
            width: 400px;
            height: 500px;
            background-color: white;
            border-radius: 4px;
            z-index: 0;
        }

        .hello {
            position: absolute;
            left: 5%;
            top: 35%;
            color: #ffcc33;
            font-size: 4.2rem;

        }
        .sBtn {
            width:90px;
            height: 35px; 
            font-size:15px; 
            border-radius: 5px;
            color: white;
            display: flex; 
            border: none;
            background-color: #333;
            flex-direction: row-reverse; 
            align-items: center;
            justify-content: center; 
        }
    </style>
</head>
<body>

    <div id="nav" class="navigator">
        <ul>
            <li>Online Quiz</li>
            <li style="float:right; font-size: 12px" onclick="self.location='./login.php'">Log in</li>
            <li style="float:right; font-size: 12px" onclick="self.location='./signup.php'">Sign up</li>
        </ul>
    </div>

    <div class="bg">
    </div>

        <div id="form" class="loginForm">
    
        <h1 style="position: absolute; top: 5px; left: 25px; color: #333"; >Welcome</h1>
    
        <form action="login.php" method="POST" >
            
            <div style="position: absolute; top: 120px; left: 25px; justify-content: center;">
                <div style="padding-bottom: 20px;">User Nickname: </div>
                <div style="padding-bottom: 20px;">Password: </div>
            </div>

            <div style="position: absolute; top: 120px; right: 25px; justify-content: center; line-height: 10px;">
                <div style="padding-bottom: 15px;"><input type = "text" name = "email" required/></div>
                <div style="padding-bottom: 20px;"><input type = "password" name="password" required/></div>
            </div>

    
            <div style="position: absolute; bottom: 20px; right: 35px">  
                <input class="sBtn" type = "submit" name="submit" value = "Login"/>    
            </div>
        </form>
    </div>


    


</body>
</html>



