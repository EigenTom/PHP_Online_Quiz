<?php
    $con= new mysqli('localhost','root','root','quizdb')or die("Could not connect to mysql".mysqli_error($con));
    session_start();
    if (!(isset($_SESSION['email']))) {
        header("location:login.php");
    } else {
        $email = $_SESSION['email'];
        $con= new mysqli('localhost','root','root','quizdb')or die("Could not connect to mysql".mysqli_error($con));
    };

    if(isset($_GET['del'])) {
        deleteQuiz($_GET['del']);
    }

    if (!$_SESSION['isStaff']) {
        header("location:welcome.php");
    }

    function deleteQuiz($qid) {
        $con= new mysqli('localhost','root','root','quizdb')or die("Could not connect to mysql".mysqli_error($con));
        $del = "DELETE FROM Quiz WHERE quiz_id = $qid";
        if (mysqli_query($con, $del)) {
            header("location:management.php");
        }
    }

    if (isset($_GET['c'])) {
        createQuiz();
    }

    function createQuiz() {
        if ($_SESSION['isStaff']) {
                $username = $_SESSION['name'];
            $id = $_SESSION['id'];
            $con= new mysqli('localhost','root','root','quizdb')or die("Could not connect to mysql".mysqli_error($con));
            $query = "INSERT INTO Quiz (quiz_id, quiz_name, quiz_author, author_id, quiz_available, quiz_duration) VALUES (NULL, 'placeholder', '$username', '$id', '0', '0')";
            if (mysqli_query($con, $query)) {
                header("location:management.php");
            }
        } else {
            header("location:management.php");
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
        

        .loginForm {
            position: relative;
            display: flex;
            
            align-items: center;
            justify-content: center;
            
            width: 90%;
            height: 80%;
            background-color: white;
            border-radius: 4px;
            z-index: 0;
            flex-direction: column;
            
        }

        .hello {
            position: absolute;
            left: 5%;
            top: 35%;
            color: #ffcc33;
            font-size: 4.2rem;
            overflow: scroll;
        }

        .quizPermute {
            position: relative;
            border-radius: 5px;
            background-color: #1f1e33;
            width: 85vw;
            height: 150px;
            color: white;
            display: flex;
            flex-direction: row;
            align-items: center;
            float: left;
            margin: 15px;
            
        }

        .quizPermute:hover{
            opacity: 80%;
            transition: .2s;
        }

        .takeTest {
            position: absolute;
            right: 25px;
            
            height: 40px;
            font-size: 1.5rem;
            line-height: 40px;
            align-items: center;
            display: flex;
            justify-content: center;

        }       
    </style>
</head>
<body>

<div id="nav" class="navigator">
        <ul>
            <li>Online Quiz</li>
            <li style="float: right; list-style-type: none; text-decoration: none; font-size:12px;" onclick="self.location='./login.php'">Log out</li>
            <li style="float: right; list-style-type: none; text-decoration: none; font-size:12px;" onclick="self.location='./history.php'">History</li>
            <li style="float: right; list-style-type: none; text-decoration: none; font-size:12px;" onclick="">Management</li>
            <li style="float: right; list-style-type: none; text-decoration: none; font-size:12px;" onclick="self.location='./welcome.php'">All Quizzes</li>
        </ul>
    </div>

    <div class="bg">
    </div>

        <div id="form" class="loginForm">
            
        <h1 style="position: absolute; top: 5px; left: 2.5vw; color: #333; width: 100%;"; >Management</h1>
        <h1 style="position: absolute; top: 5px; right: 1.5vw; color: #333; width: 200px;"; onclick="self.location='./management.php?c=1'">New Quiz</h1>
            <div style="position: absolute; top: 100px; left: 0px; width: 100%; height: 70vh; overflow-y: auto; overflow-x: hidden max"> 

                <?php
                $id = $_SESSION['id'];
                $str = "SELECT * FROM Quiz WHERE author_id='$id'";
                $res = mysqli_query($con, $str);
                //$arr = mysqli_fetch_array($res);

                while ($row = mysqli_fetch_array($res)) {
                    
                    if ($row[4] == 1) {
                        $isAvailable = "True";
                    } else {
                        $isAvailable = "False";
                    }

                    echo ('<div style="position: relative; flex-direction: column; overflow-y: auto; overflow-x: hidden;">
                            <li>
                            <div class="quizPermute">

                                <div>
                                    <div style="position: relative; font-size: 40px; top: 5px; left: 15px;">Quiz Name: '.$row[1].'</div>
                                    
                                    <div style="position: relative; top: 10px; left: 15px; line-height: 15px; color: grey">Quiz Available: '.$isAvailable.'</div>
                                    
                                    <div style="position: relative; left: 15px; color: grey">Quiz Duration: '.$row[5].' min</div>
                                </div>
                                
                                <div class="takeTest">
                                    <div style= "margin-right: 20px" onclick="self.location=`alterTest.php?q='.$row[0].'`">Alter</div>    
                                    <div style="color: red" onclick="self.location=`management.php?del='.$row[0].'`">Delete</div>    
                                </div>
                            </div>
                            </li>
                        </div>');
                }
            ?>
            </div>
        </div>
    </div>
    


</body>
</html>



