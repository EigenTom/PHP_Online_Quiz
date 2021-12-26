<?php
    $con= new mysqli('localhost','root','root','quizdb')or die("Could not connect to mysql".mysqli_error($con));
    session_start();
    if(!(isset($_SESSION['email'])))
    {
        header("location:login.php");
    }
    else
    {
        $email = $_SESSION['email'];
        $con= new mysqli('localhost','root','root','quizdb')or die("Could not connect to mysql".mysqli_error($con));
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=390, initial-scale=1">
    <title>Welcome to Online Quiz System</title>
    <script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
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

        .questionPermute {
            position: relative;
            border-radius: 5px;
            background-color: #1f1e33;
            width: 85vw;
            
            color: white;
            flex-direction: row;
            align-items: center;
            float: left;
            margin: 15px;
            
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

        .radio {
            margin: 0.5rem;
            line-height: 50px;
            align-items: center;
            justify-content: center;
        }
        .radio input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 40px;
            height: 40px;
            left: 18px;
            z-index: 1;

        }
        .radio input[type="checkbox"] + .radio-label:before {
            content: '';
            background: #f4f4f4;
            border-radius: 100%;
            border: 1px solid #b4b4b4;
            display: inline-block;
            width: 1.4em;
            height: 1.4em;
            position: relative;
            top: 0.6em;
            margin-right: 1em;
            vertical-align: top;
            cursor: pointer;
            text-align: center;
            -webkit-transition: all 250ms ease;
            transition: all 250ms ease;
        }
        .radio input[type="checkbox"]:checked + .radio-label:before {
            background-color: #1f1e33;
            box-shadow: inset 0 0 0 4px #f4f4f4;
        }
        .radio input[type="checkbox"]:focus + .radio-label:before {
            outline: none;
            border-color: #1f1e33;
        }
        .radio input[type="checkbox"]:disabled + .radio-label:before {
            box-shadow: inset 0 0 0 4px #f4f4f4;
            border-color: #b4b4b4;
            background: #b4b4b4;
        }
        .radio input[type="checkbox"] + .radio-label:empty:before {
            margin-right: 0;
        }
        .radioContainer {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            flex-direction: column;
            margin-left: 20px;
        }

    </style>
</head>
<body>

    <div id="nav" class="navigator">
        <ul>
            <li>Online Quiz</li>
            <li style="float: right; list-style-type: none; text-decoration: none; font-size:12px;" onclick="self.location='./login.php'">Log out</li>
            <li style="float: right; list-style-type: none; text-decoration: none; font-size:12px;" onclick="self.location='./history.php'">History</li>
            <li style="float: right; list-style-type: none; text-decoration: none; font-size:12px;" onclick="self.location='./management.php'">Management</li>
            <li style="float: right; list-style-type: none; text-decoration: none; font-size:12px;" onclick="self.location='./welcome.php'">All Quizzes</li>
        </ul>
    </div>

    <div class="bg">
    </div>

        <div id="form" class="loginForm">

            <div style="position: relative; top: 5px; left: 2.5vw; margin-bottom: 30px; color: #333; width: 100%; flex-direction: row; display: flex;">
                <h1>Take Quiz</h1>
            </div>

            <div class="questions" style="position: relative; display: flex; align-items: center; flex-direction: column; overflow-y: auto; overflow-x: hidden">

            <?php
                $test_id = $_GET['q'];
                $query_question = "SELECT quiz_id, question_id, question_context, solution FROM Questions WHERE quiz_id='$test_id'";
                $res_question = mysqli_query($con, $query_question);

                while ($row_q = mysqli_fetch_array($res_question)) {
                    echo ("<div class='questionPermute' name='$row_q[1]' id='$test_id'>
                            <div>
                                <div style='text-transform: capitalize; position: relative; font-size: 20px; top: 5px; left: 15px; line-height: 55px;'>$row_q[1]. $row_q[2]</div>
                            <div>");
                    

                    $query_option = "SELECT option_id, option_context, option_mark FROM Options WHERE quiz_id='$test_id' AND question_id='$row_q[1]'";
                    $res_option = mysqli_query($con, $query_option);
                    
                    while ($row_opt = mysqli_fetch_array($res_option)) {
                        echo("
                        <div class='radioContainer' id='[$row_q[1],$row_opt[0]]'>
                            <div class='radio' id='[$row_q[1],$row_opt[0]]'>
                                <input class='CheckBox', id='[$row_q[1],$row_opt[0]]' name='$row_opt[1]' type='checkbox'  />
                                <label for='' class='radio-label'>$row_opt[1]</label>
                            </div>
                        </div>");
                    };

                    echo("          
                                </div>
                            </div>
                        </div>");

                };
            ?>

            </div>

            <div style="position: relative; top: -5px; left: 2.5vw; margin-bottom: 30px; color: #333; width: 90%; flex-direction: row-reverse; display: flex;">
                <h1 onclick="handleAnswerTransfer()">Submit</h1>
            </div>

        </div>
    </div>

<script>

function handleAnswerTransfer() {
    // prepare
    var qid = document.getElementsByClassName("questionPermute")[0].id
    var arr = document.getElementsByClassName("questionPermute")


    var arr_passed = []
    for (let i=0; i<arr.length; i++) {
        var tmp_arr = []
        var tmp_iter_arr = arr[i].getElementsByClassName("CheckBox");
        for (let item of tmp_iter_arr) {
            flag = (item.checked)? 1: 0;
            tmp_arr.push(flag);
        }
        arr_passed.push(tmp_arr)
    }

    var Obj = {
        qid: qid,
        data: arr_passed
    }

    var jsonStr = JSON.stringify(Obj);
    
    $.ajax({
        type: "POST",
        url: "getAnswer.php",
        dataType: "json",
        async: false,
        data: {'json':jsonStr},
        success: function () {alert("Test submitted."); self.location='./history.php';}
    });

}


function transferScore(){
    
    var qid = document.getElementsByClassName("questionPermute")[0].id
    var arr = document.getElementsByClassName("questionPermute")
    
    var arr_passed = []
    for (let i=0; i<arr.length; i++) {
        var tmp_arr = []
        var tmp_iter_arr = arr[i].getElementsByClassName("CheckBox");
        for (let item of tmp_iter_arr) {
            flag = (item.checked)? 1: 0;
            tmp_arr.push(flag);
        }
        arr_passed.push(tmp_arr)
    }

    var ajax = new XMLHttpRequest();

    // TODO: reconstruct data transfer using json

    ajax.open('get','getAnswer.php?arr='+arr_passed+'&id='+qid);
    ajax.send();

    ajax.onreadystatechange = function(){
        if (ajax.readyState ==4 && ajax.status==200) {
            
            alert("Test submitted.");
            //self.location='./history.php';
            
        };
    }
}



</script>
    


</body>
</html>



