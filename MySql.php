<?php
    class connect_DB
    {
        public $host, $database,$user,$pass,$conn;
        function __construct($host_,$database_,$user_,$pass_)
        {   
            // config database
            $this->host = $host_;
            $this->database=$database_;
            $this->user=$user_;
            $this->pass=$pass_;
            $this->connection_DB($host_,$database_,$user_,$pass_);
        }
        // connect database
        function connection_DB($host_,$database_,$user_,$password_)
        {
            // Create connection
            $this->conn = mysqli_connect($host_, $user_, $password_, $database_);
            // Check connection
            if (!$this->conn) {
                die("Connect fail");
                // include "../../template/loader.php";
            }
            // echo "Connected successfully";
        }
        function get_data($result)
        {
            return $result;
        }
        /////////////////test/////////////////////////////
    }
    // =================================================
    // ====================QUERY========================
    // =================================================
    class Query
    {
        public $host, $database,$user,$pass;
        function __construct($database_)
        {
            $this->database=$database_;
        }
        function select_data($db,$table)
        {
            $query = 'SELECT * FROM ' . $this->database . "." . $table;
            $stmt = mysqli_stmt_init($db->conn);
            if (!mysqli_stmt_prepare($stmt, $query)) {
                die("Query preparation failed");
            }
            else
            {
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            }
            return $result;
        }
        function count_data($db,$table)
        {
            $query='SELECT MAX(id) FROM '.$this->database.".".$table;
            $stmt = mysqli_stmt_init($db->conn);
            if (!mysqli_stmt_prepare($stmt, $query)) {
                die("Query preparation failed");
            }
            else
            {
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            }
            return $result;
        }
        function insert_request($db,$table,$id,$qr,$stt,$creator,$date,$dl,$user)
        {
            $query="INSERT INTO ".$this->database.".".$table." (id, requestnumber, status,requester,dateissue,deadline,user) VALUES (?,?,?,?,?,?,?);";
            $stmt = mysqli_stmt_init($db->conn);
            if (!mysqli_stmt_prepare($stmt, $query)) {
                die("Query preparation failed");
            }
            else
            {
                mysqli_stmt_bind_param($stmt,"sssssss",$id,$qr,$stt,$creator,$date,$dl,$user);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            }
            return $result;
        }
        function select_request_VL($db,$table)
        {
            $query='SELECT requestnumber FROM '.$this->database.".".$table." WHERE requestnumber LIKE ?";
            $stmt = mysqli_stmt_init($db->conn);
            if (!mysqli_stmt_prepare($stmt, $query)) {
                die("Query preparation failed");
            }
            else
            {
                $requestNumberPattern = 'VL%'; 
                mysqli_stmt_bind_param($stmt,"s",$requestNumberPattern);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            }
            return $result;
        }

        function update_request($db, $table, $dl,$request)
        {
            $query = "UPDATE " . $db->database . "." . $table . " 
                    SET deadline=?
                    WHERE requestnumber=?;";
            
            $stmt = mysqli_stmt_init($db->conn);
            
            if (!mysqli_stmt_prepare($stmt, $query)) {
                die("Query preparation failed");
            } else {
                mysqli_stmt_bind_param($stmt, "ss", $dl, $request);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            }
            
            return $result;
        }
        function count_requestnumber_check($db,$table,$request)
        {
            $query = 'SELECT COUNT(requestnumber) FROM ' . $this->database . "." . $table ." WHERE requestnumber = ?;";
            $stmt = mysqli_stmt_init($db->conn);
            
            if (!mysqli_stmt_prepare($stmt, $query)) {
                die("Query preparation failed");
            } else {
                mysqli_stmt_bind_param($stmt,"s",$request);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            }
            
            return $result;
        }


    }
?>

