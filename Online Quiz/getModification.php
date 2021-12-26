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

    $json = $_POST['json'];
    
    $arr=(array)(json_decode($json));
    
    $qname = $arr['qname'];
    $tlim = $arr['tlimit'];
    $id = $arr['id'];
    $qn = $arr['qn'];
    $qc = $arr['qc'];
    $on = (int)$arr['on'];
    $oc = $arr['oc'];
    $om = $arr['om'];
    $av = $arr['av'];
    $mode = (int)$arr['mode'];

    


    // TODO: delete (require rearranging index!)

    // add option:
    if ($mode === 0) {
        // add one option
        $query = "SELECT COUNT(option_id) FROM (SELECT option_id FROM Options WHERE quiz_id=$id AND question_id=$qn) as test";
        // get the max index first
        $res = mysqli_fetch_array(mysqli_query($con,$query))[0];

        $res += 1;
        $query = "INSERT INTO Options SET quiz_id=$id, question_id=$qn, option_id=$res, option_context='Placeholder', option_mark=0;";
        mysqli_query($con,$query);
    }

    // add question: 
    if ($mode === 1) {
        
        // add one question 
        $query = "SELECT COUNT(quiz_id) FROM (SELECT quiz_id FROM Questions WHERE quiz_id=$id ) as test";
        // get the max index first
        $res = mysqli_fetch_array(mysqli_query($con,$query))[0];

        $res += 1;
        $query = "INSERT INTO Questions SET quiz_id=$id, question_id=$res, question_context='Placeholder', solution=2;";
        mysqli_query($con,$query);
    }
    
    // delete option:
    if ($mode === 2) {
        // delete one option
        $query = "SELECT COUNT(option_id) FROM (SELECT option_id FROM Options WHERE quiz_id=$id AND question_id=$qn) as test";
        // get the max index first
        $res = mysqli_fetch_array(mysqli_query($con,$query))[0];

        if ($res > 0) {
            // then delete this node first
            $query = "DELETE FROM Options WHERE quiz_id=$id AND question_id=$qn AND option_id=$on";
            mysqli_query($con,$query);
            
            // then iterate from $on+1 to $res to change their indexes
            for ($index=$on+1; $index < $res+1; $index++) {
                $tmp_index = $index-1;
                $query = "UPDATE Options SET option_id=$tmp_index WHERE quiz_id=$id AND question_id=$qn AND option_id=$index";
                mysqli_query($con,$query);
            }
        }    
    }

    // delete question:
    if ($mode === 3) {
        // delete one question
        $query = "SELECT COUNT(quiz_id) FROM (SELECT quiz_id FROM Questions WHERE quiz_id=$id ) as test";
        // get the max index first
        $res = mysqli_fetch_array(mysqli_query($con,$query))[0];

        if ($res > 0) {
            // then delete this node first
            $query = "DELETE FROM Questions WHERE quiz_id=$id AND question_id=$qn";
            mysqli_query($con,$query);

            // then iterate from $qn+1 to $res to change their indexes
            for ($index=$qn+1; $index < $res+1; $index++) {
                $tmp_index = $index-1;
                $query = "UPDATE Questions SET question_id=$tmp_index WHERE quiz_id=$id AND question_id=$index";
                mysqli_query($con,$query);
            }
        }
    }

    // update question: question context
    if ($mode === 4) {
        
        // update metadata no matter which updatemode is selected
        $query="UPDATE Quiz SET quiz_name='$qname', quiz_duration=$tlim, quiz_available=$av WHERE quiz_id=$id";
        mysqli_query($con,$query);
        
        
        // only update if context not null
        if ($qc !== "") {
            $query = "UPDATE Questions SET question_context='$qc' WHERE quiz_id=$id AND question_id=$qn";
            mysqli_query($con,$query);
        }
    }

    // update option: option mark or option context
    if ($mode == 5) {
        // update metadata no matter which updatemode is selected
        $query="UPDATE Quiz SET quiz_name='$qname', quiz_duration=$tlim, quiz_available=$av WHERE quiz_id=$id";
        mysqli_query($con,$query);

        // only update if qname valid
        if ($oc !== "") {
            $query = "UPDATE Options SET option_context='$oc' WHERE quiz_id=$id AND question_id=$qn AND option_id=$on";
            mysqli_query($con,$query);
        }

        // only update if question context not null
        if ($qc !== "") {
            $query = "UPDATE Questions SET question_context='$qc' WHERE quiz_id=$id AND question_id=$qn";
            mysqli_query($con,$query);
        }
        
        // only update if option context not null
        if ($om !== "") {
            $query = "UPDATE Options SET option_mark=$om WHERE quiz_id=$id AND question_id=$qn AND option_id=$on";
            mysqli_query($con,$query);
        }

        
    }

    
    
    
?>