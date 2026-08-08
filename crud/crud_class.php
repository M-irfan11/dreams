<?php

class crud_class
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "dreams";

    public $conn;


    /* =========================================================
       DATABASE CONNECTION
       ========================================================= */

    public function __construct()
    {
        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // Set UTF-8
        $this->conn->set_charset("utf8mb4");
    }


    /* =========================================================
       SELECT
       ========================================================= */

    public function common_select(
        $table,
        $columns = "*",
        $where = [],
        $where_condition = "AND",
        $order_by = "",
        $sort_order = "ASC",
        $limit = "",
        $offset = ""
    ) {
        $result = [
            "status" => false,
            "data" => [],
            "message" => ""
        ];

        $sql = "SELECT $columns FROM $table";


        /* ---------- WHERE ---------- */

        if (!empty($where)) {

            $where_clauses = [];

            foreach ($where as $column => $value) {

                $escaped_value = $this->conn->real_escape_string($value);

                $where_clauses[] =
                    "$table.$column = '$escaped_value'";
            }

            $sql .= " WHERE " . implode(
                " $where_condition ",
                $where_clauses
            );
        }


        /* ---------- ORDER BY ---------- */

        if (!empty($order_by)) {

            $sort_order = strtoupper($sort_order);

            if ($sort_order !== "ASC" && $sort_order !== "DESC") {
                $sort_order = "ASC";
            }

            $sql .= " ORDER BY $order_by $sort_order";
        }


        /* ---------- LIMIT ---------- */

        if ($limit !== "" && is_numeric($limit)) {

            $sql .= " LIMIT " . (int)$limit;

            if ($offset !== "" && is_numeric($offset)) {
                $sql .= " OFFSET " . (int)$offset;
            }
        }


        /* ---------- EXECUTE QUERY ---------- */

        $rs = $this->conn->query($sql);


        if ($rs === false) {

            $result["message"] =
                "SQL Error: " . $this->conn->error;

            return $result;
        }


        /* ---------- FETCH DATA ---------- */

        if ($rs->num_rows > 0) {

            while ($row = $rs->fetch_object()) {

                $result["data"][] = $row;
            }

            $result["status"] = true;
            $result["message"] = "Records found";

        } else {

            $result["message"] = "No records found";
        }


        return $result;
    }


    /* =========================================================
       NUMBER OF RECORDS
       ========================================================= */

    public function number_of_records($table)
    {
        $sql = "SELECT COUNT(*) AS total FROM $table";

        $rs = $this->conn->query($sql);

        if ($rs === false) {
            return 0;
        }

        if ($rs->num_rows > 0) {

            $row = $rs->fetch_object();

            return $row->total;
        }

        return 0;
    }


    /* =========================================================
       CUSTOM QUERY
       ========================================================= */

    public function common_query(
        $sql,
        $limit = "",
        $offset = ""
    ) {
        $result = [
            "status" => false,
            "data" => [],
            "message" => ""
        ];


        /* ---------- LIMIT ---------- */

        if ($limit !== "" && is_numeric($limit)) {

            $sql .= " LIMIT " . (int)$limit;

            if ($offset !== "" && is_numeric($offset)) {

                $sql .= " OFFSET " . (int)$offset;
            }
        }


        /* ---------- EXECUTE ---------- */

        $rs = $this->conn->query($sql);


        if ($rs === false) {

            $result["message"] =
                "SQL Error: " . $this->conn->error;

            return $result;
        }


        /* ---------- FETCH DATA ---------- */

        if ($rs->num_rows > 0) {

            while ($row = $rs->fetch_object()) {

                $result["data"][] = $row;
            }

            $result["status"] = true;
            $result["message"] = "Records found";

        } else {

            $result["message"] = "No records found";
        }


        return $result;
    }


    /* =========================================================
       INSERT
       ========================================================= */

    public function common_insert($table, $data)
    {
        $result = [
            "status" => false,
            "data" => [],
            "message" => ""
        ];


        if (empty($data)) {

            $result["message"] = "No data provided";

            return $result;
        }


        /* ---------- COLUMNS ---------- */

        $columns = implode(
            ", ",
            array_keys($data)
        );


        /* ---------- VALUES ---------- */

        $values_array = [];

        foreach ($data as $value) {

            $values_array[] =
                "'" .
                $this->conn->real_escape_string($value) .
                "'";
        }


        $values = implode(
            ", ",
            $values_array
        );


        /* ---------- QUERY ---------- */

        $sql =
            "INSERT INTO $table ($columns)
             VALUES ($values)";


        /* ---------- EXECUTE ---------- */

        if ($this->conn->query($sql)) {

            $result["status"] = true;

            $result["data"] =
                $this->conn->insert_id;

            $result["message"] =
                "Record inserted successfully";

        } else {

            $result["message"] =
                "Error: " . $this->conn->error;
        }


        return $result;
    }


    /* =========================================================
       UPDATE
       ========================================================= */

    public function common_update(
        $table,
        $data,
        $where = [],
        $where_condition = "AND"
    ) {
        $result = [
            "status" => false,
            "data" => [],
            "message" => ""
        ];


        if (empty($data)) {

            $result["message"] =
                "No data provided";

            return $result;
        }


        /* ---------- SET ---------- */

        $set_clauses = [];

        foreach ($data as $column => $value) {

            $escaped_value =
                $this->conn->real_escape_string($value);

            $set_clauses[] =
                "$column = '$escaped_value'";
        }


        $sql =
            "UPDATE $table SET " .
            implode(", ", $set_clauses);


        /* ---------- WHERE ---------- */

        if (!empty($where)) {

            $where_clauses = [];

            foreach ($where as $column => $value) {

                $escaped_value =
                    $this->conn->real_escape_string($value);

                $where_clauses[] =
                    "$column = '$escaped_value'";
            }

            $sql .=
                " WHERE " .
                implode(
                    " $where_condition ",
                    $where_clauses
                );
        }


        /* ---------- EXECUTE ---------- */

        if ($this->conn->query($sql)) {

            $result["status"] = true;

            $result["data"] =
                $this->conn->affected_rows;

            $result["message"] =
                "Record updated successfully";

        } else {

            $result["message"] =
                "Error: " . $this->conn->error;
        }


        return $result;
    }


    /* =========================================================
       DELETE
       ========================================================= */

    public function common_delete(
        $table,
        $where = [],
        $where_condition = "AND"
    ) {
        $result = [
            "status" => false,
            "data" => [],
            "message" => ""
        ];


        /* ---------- DELETE QUERY ---------- */

        $sql =
            "DELETE FROM $table";


        /* ---------- WHERE ---------- */

        if (!empty($where)) {

            $where_clauses = [];

            foreach ($where as $column => $value) {

                $escaped_value =
                    $this->conn->real_escape_string($value);

                $where_clauses[] =
                    "$column = '$escaped_value'";
            }

            $sql .=
                " WHERE " .
                implode(
                    " $where_condition ",
                    $where_clauses
                );

        } else {

            /*
             * Safety protection.
             * Do not allow DELETE without WHERE.
             */

            $result["message"] =
                "Delete requires a WHERE condition";

            return $result;
        }


        /* ---------- EXECUTE ---------- */

        if ($this->conn->query($sql)) {

            $result["status"] = true;

            $result["data"] =
                $this->conn->affected_rows;

            $result["message"] =
                "Record deleted successfully";

        } else {

            $result["message"] =
                "Error: " . $this->conn->error;
        }


        return $result;
    }


    /* =========================================================
       DATABASE DISCONNECT
       ========================================================= */

    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

?>