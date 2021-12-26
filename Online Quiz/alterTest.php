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
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
      integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
      crossorigin="anonymous"
    />
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
        
        .radio input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 40px;
            height: 40px;
            left: 18px;
            z-index: 1;

        }
        .radio input[type="radio"] + .radio-label:before {
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
        .radio input[type="radio"]:checked + .radio-label:before {
            background-color: #1f1e33;
            box-shadow: inset 0 0 0 4px #f4f4f4;
        }
        .radio input[type="radio"]:focus + .radio-label:before {
            outline: none;
            border-color: #1f1e33;
        }
        .radio input[type="radio"]:disabled + .radio-label:before {
            box-shadow: inset 0 0 0 4px #f4f4f4;
            border-color: #b4b4b4;
            background: #b4b4b4;
        }
        .radio input[type="radio"] + .radio-label:empty:before {
            margin-right: 0;
        }
        .radioContainer {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            flex-direction: column;
            margin-left: 20px;
        }


        .editpane {
            position: absolute;
            top: 270px;
            width: 800px;
            height: 580px;
            background-color: whitesmoke;
            border-radius: 5px;
            transition: .5s;
        }

        .editpane.hide {
            position: absolute;
            top: -570px;
            width: 800px;
            height: 580px;
            background-color: black;
            color: black;
            border-radius: 5px;
            transition: .5s;
        }

        .editpaneBtns {
            position: absolute;
            bottom: 26px;
            left: 25px;
            width:40%; 
            font-size:20px; 
            display: flex; 
            flex-direction: row-reverse; 
            align-items: center;
            justify-content: center; 
            
        }

        .paneInput {
            margin-top: 10px;
            margin-bottom: 10px;
            margin-left: 20px;
            font-size: 20px;
        }


        .paneInput input {
            -webkit-appearance: none;
            border:1px #333 solid;
            height: 20px;
        }

        .paneBtns {
            font-size: 15px;
            padding: 10px;
            margin: 5px;
            background-color: #333;
            color: white;
        }

        .editpaneInputHide {
            visibility: hidden;
        }

        .editpaneInput:disabled {
            background-color: #333;
        }

        .ActionRadioContainer {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            flex-direction: column;
            margin-left: 20px;
            margin-top: 360px;
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
            

            <h1 style="position: absolute; top: 5px; left: 2.5vw; color: #333; width: 100%;"; >
                
                <?php
                    $test_id = $_GET['q'];
                    $query_info = "SELECT quiz_name, quiz_duration, quiz_available FROM Quiz WHERE quiz_id='$test_id'";
                    $res_info = mysqli_fetch_array(mysqli_query($con, $query_info));
                    echo("<div class='quizID' id='$test_id'>$res_info[0]</div>");
                    $quiz_name = $res_info[0];
                    $quiz_duration = $res_info[1];
                    $quiz_isAvailable = $res_info[2];
                ?>
                
                
                
                <div style="position: absolute; right: 6.5vw; top: 0px;" onclick=showEditPane()><i class="fas fa-align-justify"></i></div>
            </h1>
            <div style="position: absolute; top: 100px; left: 0px; width: 100%; height: 70vh; overflow-y: auto; overflow-x: hidden max"> 

            <?php
                
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
                                <label for='' class='radio-label' style='color: red; font-size: 20px;'>$row_opt[0]. </label>
                                <label for='' class='radio-label' style='font-size:20px;'>$row_opt[1]</label>
                                <label for='' class='radio-label' style='float: right; margin-right:20px;'>Option Mark : $row_opt[2]</label>
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
            
            

        </div>
    </div>
    
    
    <div class="editpane " id="editpane">
        <h2 style="position: absolute; left: 25px; top: 5px;">Edit Properties</h2>
        <h2 style="position: absolute; right: 25px; top: 5px;" onclick=showEditPane()><i class="fa fa-power-off"></i></h2>
        
        <div style="position: absolute; top: 65px; width: 100%; height: 80%; ">
            <div class="paneInput">Question Name:  <input class="editpaneInputHide" type = "text" name="quesNum"/></div>    
            <div class="paneInput">Time Limit (min):  <input class="editpaneInputHide" type = "text" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" name="quesNum"/></div>    
            <div class="paneInput">Question Number:  <input class="editpaneInputHide" type = "text" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" name="quesNum"/></div>
            <div class="paneInput">Question Context: <input class="editpaneInputHide" type = "text" name="quesContext"/></div>
            <div class="paneInput">Option Number:    <input class="editpaneInputHide" type = "text" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" name="optNum"/></div>
            <div class="paneInput">Option Context   :<input class="editpaneInputHide" type = "text" name="optContext"/></div>
            <div class="paneInput">Option Mark      :<input class="editpaneInputHide" type = "text" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" name="optMark"/></div>
            <div class="paneInput">Available      :<input class="editpaneInputHide" type = "text" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" name="optMark"/></div>
        </div>
        
        <div style="position: absolute; top: 65px; width: 40%; left: 180px; height: 80%; ">

            <?php

                echo("<div class='paneInput'><input class='editpaneInput' id='qname' type = 'text' name='quesName' value=$quiz_name /></div>
                <div class='paneInput'><input class='editpaneInput' id='tlimit' type = 'text' onkeyup='handleCheck(this)' name='quesDuration' value=$quiz_duration></div>")
                
            ?>
            
            
            
            <div class="paneInput"><input class="editpaneInput" id="qn" type = "text" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" name="quesNum"/></div>
            <div class="paneInput"><input class="editpaneInput" id="qc" type = "text" name="quesContext"/></div>
            <div class="paneInput"><input class="editpaneInput" id="on" type = "text" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" name="optNum"/></div>
            <div class="paneInput"><input class="editpaneInput" id="oc" type = "text" name="optContext"/></div>
            <div class="paneInput"><input class="editpaneInput" id="om" type = "text" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" name="optMark"/></div>
            
            <?php

                echo("<div style='margin-left: 15px;'><input class='radio' id='av' type = 'checkbox'/></div>");
                echo("<script>document.getElementById('av').checked = $quiz_isAvailable</script>");
            ?>
            
            

        </div>



        <div style="position: absolute; left: 46%; top: 58px; width: 50%; height: 80%; background-color: #333; color: white; border-radius: 5px; padding: 10px; line-height: 20px; overflow-y: scroll;">
            <div style="font-size: 25px; color: red">Instructions:</div> <br> 
            <p style="font-size: 15px;">0. <b>Please read the instruction before you start.</b> To improve the efficiency, the page won't be automatically refreshed. You may need to manually refresh the page to see the changes you made.<br/><br>
            1. You can only alter one question's context and one of its option's context at one time. <br><br>
            2. To update context, select 'Add', provide question number (or together with option number), enter whatever you want to update, then click 'Execute'. Everything left blank will not be altered.<br>
                <span>If you does not enter option number, options will not be altered.</span><br>
                <span>Question Name, Time Limit and Availablity's value will be updated to the value displayed in the textbox/checkbox.</span><br><br>
            3. Every option with mark "0" is considered as a false answer, if you select <b>anyone of these</b>, your score of this question will be 0. <br> Questions whose mark greater than "0" are considered true, you get (partial) score for choosing each of them. <br> You can use this feature to build MCQs.</p>
            4. To delete a question (or an option), just provide question number ( or question number together with option number) then click 'Execute'. <br><br>
            5. If you want to insert a question, just select 'Add', leave everything blank, click 'Execute'.<br><br>
            6. If you want to insert an option, select 'Add', provide the question number, click 'Execute'. <br><br> 
            

            

        </div>

        <div class='ActionRadioContainer' id='actions'>
            <div class='radio action'style="line-height:30px;"  >
                <input class='radio' id='action0' name='actionSelection' type='radio' onclick="handleTableUpdate()"/>
                <label for='' class='radio-label'>Add</label>
            </div>
            <div class='radio action' style="line-height:30px;" >
                <input class='radio' id='action1' name='actionSelection' type='radio' onclick="handleTableUpdate()"/>
                <label for='' class='radio-label'>Delete</label>
            </div>
            <div class='radio action' style="line-height:30px;" >
                <input class='radio' id='action2' name='actionSelection' type='radio' onclick="handleTableUpdate()"/>
                <label for='' class='radio-label'>Update</label>
            </div>
        </div>
        
        <div class="editpaneBtns" >
        <div class="paneBtns" onclick="handlePaneExecute()">Execute</div>
        <div class="paneBtns" onclick="handlePanePreview()">Preview</div>
        
        </div>
    
    </div>

<script>

function handleTableUpdate() {
    
    if (document.getElementById('action1').checked || document.getElementById('action0').checked) {
        document.getElementById('qc').disabled = true
        document.getElementById('oc').disabled = true
        document.getElementById('om').disabled = true
        document.getElementById('on').disabled = false

        if (document.getElementById('action0').checked) {
            document.getElementById('on').disabled = true
        }
    } else {
        document.getElementById('qc').disabled = false
        document.getElementById('oc').disabled = false
        document.getElementById('om').disabled = false
        document.getElementById('on').disabled = false
    }

}

function handleCheck(obj) {
    obj.value=obj.value.replace(/[^\d]/g,'')
}

function showEditPane() {
    if (document.getElementById('editpane').classList.contains('hide')) {
        document.getElementById('editpane').classList.remove('hide')
    } else {
        document.getElementById('editpane').classList.add('hide')
    }
}

function handlePanePreview() {
    // prepare
    var qname = document.getElementById('qname').value;
    var tlimit = document.getElementById('tlimit').value;
    var qn = document.getElementById('qn').value;
    var qc = document.getElementById('qc').value;
    var on = document.getElementById('on').value;
    var oc = document.getElementById('oc').value;
    var om = document.getElementById('om').value;
    var av = document.getElementById('av').checked;

    // check mode
    var checked = false;
    //add
    if (document.getElementById('action0').checked) {
        checked = true;
        if (qn != "" && on != "") {
            alert("Invalid Input!");    
        } 
        if (qn != "" ) {
            alert("Operation: Add one option under question No."+qn+".");
        }
        if (qn == "") {
            alert("Operation: Add a new question.");
        }
    }

    // delete
    if (document.getElementById('action1').checked) {
        checked = true;
        if (qn != "" && on != "") {
            alert("Operation: Delete question No."+qn+"'s option No."+on+".");
        } 
        if (qn != "" && on == "") {
            alert("Operation: Delete question No."+qn+".");
        }
        if (qn == "") {
            alert("Invalid Input!");
        }
    }

    // update
    if (document.getElementById('action2').checked) {
        checked = true;
        if (qn == "") {
            alert("Invalid Input!");    
        } 
        if (qn != "" && on == "") {
            alert("Operation: modify question No."+qn+"'s context.");
        }
        if (qn != "" && on != "") {
            alert("Operation: modify question No."+qn+"'s No."+on+" option.");
        }
    }

    // not selected
    if (!checked) {
        alert("Please select one operation first!")
    }
}

function handlePaneExecute() {
    // prepare
    var qname = document.getElementById('qname').value;
    var tlimit = document.getElementById('tlimit').value;
    var qn = document.getElementById('qn').value;
    var qc = document.getElementById('qc').value;
    var on = document.getElementById('on').value;
    var oc = document.getElementById('oc').value;
    var om = document.getElementById('om').value;
    var av = document.getElementById('av').checked;

    // check mode
    var isIllegal = false;
    var operation = '';
    var mode = -1;
    var checked = false;
    //add
    if (document.getElementById('action0').checked) {
        checked = true;
        operation = 'add'
        if (qn != "" && on != "") {
            isIllegal = true
            alert("Invalid Input!");    
        } 
        if (qn != "" ) {
            mode = 0;
            alert("Ongoing Operation: Add one option under question No."+qn+".");
        }
        if (qn == "") {
            mode = 1;
            alert("Ongoing Operation: Add a new question.");
        }
    }

    // delete
    if (document.getElementById('action1').checked) {
        checked = true;
        operation = 'del'
        if (qn != "" && on != "") {
            mode = 2;
            alert("Ongoing Operation: Delete question No."+qn+"'s option No."+on+".");
        } 
        if (qn != "" && on == "") {
            mode = 3;
            alert("Ongoing Operation: Delete question No."+qn+".");
        }
        if (qn == "") {
            isIllegal = true;
            alert("Invalid Input!");
        }
    }

    // update
    if (document.getElementById('action2').checked) {
        checked = true;
        operation = 'upd'
        if (qn == "") {
            isIllegal = true;
            alert("Invalid Input!");    
        } 
        if (qn != "" && on == "") {
            mode = 4;
            alert("Operation: modify question No."+qn+"'s context.");
        }
        if (qn != "" && on != "") {
            mode = 5;
            alert("Operation: modify question No."+qn+"'s No."+on+" option.");
        }
    }

    // not selected
    if (!checked) {
        isIllegal = true;
        alert("Please select one operation first!")
    }

    if (!isIllegal) {
        var Obj = {
            qname: qname,
            tlimit: tlimit,
            id: document.getElementsByClassName('quizID')[0].id,
            qn: qn,
            qc: qc,
            on: on,
            oc: oc,
            om: om,
            av: av? 1: 0,
            mode: mode
        };

        console.log(Obj);
        var jsonStr = JSON.stringify(Obj);

        $.ajax({
            type: "POST",
            url: "getModification.php",
            dataType: "json",
            async: false,
            data: {'json':jsonStr}
        });


    }
}


function transferScore(){
    //var arr = document.getElementsByClassName("CheckBox");
    
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

    ajax.open('get','getAnswer.php?arr='+arr_passed+'&id='+qid);
    //ajax.open('get','getAnswer.php?content='+arr_passed);
    ajax.send();

    ajax.onreadystatechange = function(){
        if (ajax.readyState ==4 && ajax.status==200) {
            
            self.location='./history.php';
            
        };
    }
}
</script>
    


</body>
</html>



