<?php

class crud_class{

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "dreams";
    public $conn;

    public function __construct(){
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if($this->conn->connect_error){
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    /**
     * $use_soft_delete = true হলে "deleted_at IS NULL" কন্ডিশন অটো যোগ হবে।
     * sales, purchases, stocks - এই টেবিলগুলোতে deleted_at কলাম আছে, তাই true দিবেন (ডিফল্ট)।
     * account_heads, payment_vouchers, receive_vouchers, journal_vouchers, ledgers - এই টেবিলে
     * deleted_at কলাম নাই, তাই এগুলোর জন্য false পাঠাবেন।
     */
    public function common_select($table, $columns = "*", $where = [], $where_condition = "AND", $order_by = "",
        $sort_order = "ASC", $limit = "", $offset = "", $use_soft_delete = true){

        $result = [
            "status"  => false,
            "data"    => [],
            "message" => ""
        ];

        $sql = "SELECT $columns FROM $table";

        $has_where = false;
        if(!empty($where)){
            $where_clauses = [];
            foreach($where as $column => $value){
                if(is_null($value)){
                    $where_clauses[] = "$table.$column IS NULL";
                } else {
                    $where_clauses[] = "$table.$column = '" . $this->conn->real_escape_string($value) . "'";
                }
            }
            $sql .= " WHERE (" . implode(" $where_condition ", $where_clauses) . ")";
            $has_where = true;
        }

        if($use_soft_delete){
            $sql .= $has_where ? " AND $table.deleted_at IS NULL" : " WHERE $table.deleted_at IS NULL";
        }

        if(!empty($order_by)){
            $sql .= " ORDER BY $order_by $sort_order";
        }

        if($limit !== ""){
            $sql .= " LIMIT $limit";
            if($offset !== ""){
                $sql .= " OFFSET $offset";
            }
        }

        $rs = $this->conn->query($sql);
        if($rs === false){
            $result["message"] = "Query Error: " . $this->conn->error;
            return $result;
        }

        if($rs->num_rows > 0){
            $result["status"]  = true;
            $result["message"] = "Records found";
            while($row = $rs->fetch_object()){
                $result["data"][] = $row;
            }
        } else {
            $result["message"] = "No records found";
        }
        return $result;
    }

    public function number_of_records($table, $use_soft_delete = true){
        $sql = "SELECT COUNT(*) as total FROM $table";
        if($use_soft_delete){
            $sql .= " WHERE deleted_at IS NULL";
        }
        $rs = $this->conn->query($sql);
        if($rs && $rs->num_rows > 0){
            $row = $rs->fetch_object();
            return (int) $row->total;
        }
        return 0;
    }

    /**
     * নিজের কাস্টম SELECT / JOIN কোয়েরি চালাতে ব্যবহার করবেন (যেমন Ledger রিপোর্ট)।
     */
    public function common_query($sql){
        $result = [
            "status"  => false,
            "data"    => [],
            "message" => ""
        ];

        $rs = $this->conn->query($sql);

        if($rs === false){
            $result["message"] = "Query Error: " . $this->conn->error;
            return $result;
        }

        // INSERT/UPDATE/DELETE হলে $rs === true আসে, num_rows থাকে না
        if($rs === true){
            $result["status"]  = true;
            $result["message"] = "Query executed successfully";
            $result["data"]    = $this->conn->affected_rows;
            return $result;
        }

        if($rs->num_rows > 0){
            $result["status"]  = true;
            $result["message"] = "Records found";
            while($row = $rs->fetch_object()){
                $result["data"][] = $row;
            }
        } else {
            $result["message"] = "No records found";
        }
        return $result;
    }

    public function common_insert($table, $data){
        $result = [
            "status"  => false,
            "data"    => [],
            "message" => ""
        ];

        $columns = [];
        $values  = [];
        foreach($data as $column => $value){
            $columns[] = "`$column`";
            $values[]  = is_null($value) ? "NULL" : "'" . $this->conn->real_escape_string($value) . "'";
        }

        $sql = "INSERT INTO $table (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ")";

        if($this->conn->query($sql)){
            $result["status"]  = true;
            $result["data"]    = $this->conn->insert_id;
            $result["message"] = "Record inserted successfully";
        } else {
            $result["message"] = "Error: " . $this->conn->error;
        }
        return $result;
    }

    public function common_update($table, $data, $where = [], $where_condition = "AND"){
        $result = [
            "status"  => false,
            "data"    => [],
            "message" => ""
        ];

        $set_clauses = [];
        foreach($data as $column => $value){
            $set_clauses[] = is_null($value)
                ? "`$column` = NULL"
                : "`$column` = '" . $this->conn->real_escape_string($value) . "'";
        }
        $sql = "UPDATE $table SET " . implode(", ", $set_clauses);

        if(!empty($where)){
            $where_clauses = [];
            foreach($where as $column => $value){
                $where_clauses[] = "$column = '" . $this->conn->real_escape_string($value) . "'";
            }
            $sql .= " WHERE " . implode(" $where_condition ", $where_clauses);
        }

        if($this->conn->query($sql)){
            $result["status"]  = true;
            $result["data"]    = $this->conn->affected_rows;
            $result["message"] = "Record updated successfully";
        } else {
            $result["message"] = "Error: " . $this->conn->error;
        }
        return $result;
    }

    public function common_delete($table, $where = [], $where_condition = "AND"){
        $result = [
            "status"  => false,
            "data"    => [],
            "message" => ""
        ];

        $sql = "DELETE FROM $table";
        if(!empty($where)){
            $where_clauses = [];
            foreach($where as $column => $value){
                $where_clauses[] = "$column = '" . $this->conn->real_escape_string($value) . "'";
            }
            $sql .= " WHERE " . implode(" $where_condition ", $where_clauses);
        }

        if($this->conn->query($sql)){
            $result["status"]  = true;
            $result["data"]    = $this->conn->affected_rows;
            $result["message"] = "Record deleted successfully";
        } else {
            $result["message"] = "Error: " . $this->conn->error;
        }
        return $result;
    }

    /**
     * sales/purchases/stocks এর মতো deleted_at কলাম আছে এমন টেবিলের জন্য soft delete।
     */
    public function common_soft_delete($table, $where = [], $where_condition = "AND"){
        return $this->common_update($table, ["deleted_at" => date("Y-m-d H:i:s")], $where, $where_condition);
    }

    /**
     * Payment/Receive/Journal Voucher এর মতো একাধিক টেবিলে (master + details + ledger)
     * একসাথে ডাটা সেভ করার সময় ব্যবহার করবেন, যাতে মাঝপথে এরর হলে সব রোলব্যাক হয়ে যায়।
     */
    public function begin_transaction(){
        $this->conn->begin_transaction();
    }

    public function commit(){
        $this->conn->commit();
    }

    public function rollback(){
        $this->conn->rollback();
    }

    /**
     * PV-000001, RV-000001, JV-000001 এর মতো ধারাবাহিক ইনভয়েস নম্বর জেনারেট করে।
     * উদাহরণ: $crud->generate_invoice_no("payment_vouchers", "PV")
     */
    public function generate_invoice_no($table, $prefix, $column = "invoice_no"){
        $sql = "SELECT $column FROM $table ORDER BY id DESC LIMIT 1";
        $rs  = $this->conn->query($sql);

        $next = 1;
        if($rs && $rs->num_rows > 0){
            $row = $rs->fetch_object();
            $parts = explode("-", $row->$column);
            $lastNo = isset($parts[1]) ? (int) $parts[1] : 0;
            $next = $lastNo + 1;
        }
        return $prefix . "-" . str_pad($next, 6, "0", STR_PAD_LEFT);
    }

    public function __destruct(){
        $this->conn->close();
    }
}