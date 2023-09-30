<?php
    include "MySql.php";
    $db = new connect_DB('localhost','mongonv2','root','');
    $qr= new Query("mongonv2");

    function get_data_fix_limit($qr,$db)
    {
        $query= $qr->select_data($db,"fix_limit");
        $result=$db->get_data($query);
        if (!$result)
        {
            die ('Query is wrong');
        }
        else
        {
            
        }
        $fix_limit=[];
        while ($row = mysqli_fetch_assoc($result))
        {
            $fix_limit[$row['display_type']."_".$row['meter']]=$row['limit'];

        };
        return $fix_limit;
    }
    function get_count_request($qr,$db)
    {
        $query= $qr->count_data($db,"request");
        $result=$db->get_data($query);
        while ($row = mysqli_fetch_assoc($result))
        {
            
            $last_row=$row['MAX(id)']; 
        };
        if ($last_row===0)
        {
            return 1;
        }
        else
        {
            return $last_row+1;
        }
    }

    function add_request($qr,$db,$id,$rq,$stt,$creator,$date,$dl,$user)
    {
        $query= $qr->insert_request($db,"request",$id,$rq,$stt,$creator,$date,$dl,$user);
        $db->get_data($query);
    }

    function get_last_VL($qr,$db)
    {
    $query= $qr->select_request_VL($db,"request");
    $result=$db->get_data($query);
    if (!$result)
    {
        die ('Query wrong1');
    }
    else
    {

    }
    $arr_rq_tr=[];
    while ($row = mysqli_fetch_assoc($result))
    {
        array_push($arr_rq_tr,$row['requestnumber']);    
    };
    return $arr_rq_tr;
    }
/////////////////////////
    $dl = "bbb";
    $request = "VL3_CanadianFrench";
    function count_requestnumber($qr,$db,$request)
        {
            $query= $qr->count_requestnumber_check($db,"request",$request);
            $result=$db->get_data($query);
            while ($row = mysqli_fetch_assoc($result))
            {
                $count_requestnumber=$row['COUNT(requestnumber)'];
                // print_r($row);
            };
            return $count_requestnumber;
        }
    function update_request_before_send($qr,$db,$dl,$request)
    {
        $query= $qr->update_request($db, "request", $dl,$request);
        $db->get_data($query);
    }

    // $duc = update_request_before_send($qr,$db,$dl,$request);
    $duc = count_requestnumber($qr,$db,$request);
    print_r($duc);
    

?>