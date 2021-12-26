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
    
    
    //$answer_arr = $_GET['arr'];
    
    //$test_id = $_GET['id'];

    $json = $_POST['json'];
    $arr = (array)(json_decode($json));
    $quizID = $arr['qid'];
    $ans = $arr['data'];
    
    $user_id = $_SESSION['id'];


    $counter = 0;
    $total = 0;
    $full_score = 0;

    
    // get the max index first
    $query = "SELECT COUNT(quiz_id) FROM (SELECT quiz_id FROM Questions WHERE quiz_id=$quizID) as test";
    $res_questionCount = mysqli_fetch_array(mysqli_query($con,$query))[0];

    for ($i=1; $i<$res_questionCount+1; $i++) {
        $query = "SELECT COUNT(option_id) FROM (SELECT option_id FROM Options WHERE quiz_id=$quizID AND question_id=$i) as test";
        // get the max index first
        $res_optionCount = mysqli_fetch_array(mysqli_query($con,$query))[0];
        $tmp_score = 0;
        $fail_choice_flag = false;
        for ($j=1; $j<$res_optionCount+1; $j++) {
            
            $query = "SELECT option_mark FROM Options WHERE quiz_id=$quizID AND question_id=$i AND option_id=$j";
            $res_score = mysqli_fetch_array(mysqli_query($con,$query))[0];
            // maintain the full score counter
            $full_score += $res_score;
            

            if ($ans[$i-1][$j-1] === 1) {
                $tmp_score += $res_score;
            }
            
            // chose the wrong answer
            if ($ans[$i-1][$j-1] === 1 && $res_score === 0) {
                $fail_choice_flag = true;
            }
        }

        // if any wrong answer choosed, then you got 0
        if (!$fail_choice_flagil) {
            $total += $tmp_score;
        }

    };

    echo $total;

/*

    while ($row_q = mysqli_fetch_array($res_question)) {
        echo $row_q[1];
        $query_option = "SELECT option_id, option_context, option_mark FROM Options WHERE quiz_id='$quizID' AND question_id='$row_q[1]'";
        $res_option = mysqli_query($con, $query_option);
        
        $this_score = 0;
        $this_full_score = 0;
        while ($row_opt = mysqli_fetch_array($res_option)) {
            echo $row_opt[2];
            if (($answer_arr[$counter]===1 && $row_opt[2]===0)||($answer_arr[$counter]===0 && $row_opt[2]!==0)) {
                $this_score = 0;
                break;
            } else {
                $this_score += $row_opt[2];
                


            $this_full_score += $row_opt[2];
            $counter = $counter + 1;
        };
        $total += $this_score;
        $full_score += $this_full_score;
        
    };

*/
    //echo $counter;
    // store the percentage
    $percent = floor(($total / $full_score) * 100);

    $date = date('y/m/d');

    // check if the corresponding test exists
    $query = "SELECT quiz_id FROM Test WHERE user_id='$user_id' AND quiz_id='$quizID'";
    $ans = mysqli_fetch_array(mysqli_query($con,$query))[0];
    
    $total = $total*1;
    $conn= new mysqli('localhost','root','root','quizdb')or die("Could not connect to mysql".mysqli_error($conn));
    if ($ans) {
        $quer="UPDATE Test SET attempt_Date='$date', score=$total, score_percent=$percent WHERE quiz_id='$quizID' AND user_id='$user_id'";
        mysqli_query($conn,$quer);
        
    } else {
        $que="INSERT INTO Test SET attempt_Date='$date', score=$total, score_percent=$percent, quiz_id='$quizID', user_id='$user_id'";
        mysqli_query($conn,$que);
    }    

?>