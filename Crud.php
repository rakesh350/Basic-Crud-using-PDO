<?php
/*
 *  A PHP class to perform basic CRUD operation using PHP PDO
 *  Author : jrakesh173@gmail.com
 */
class Crud {
    private $conn_obj;
    function __construct($conn_obj) {
        $this->conn_obj = $conn_obj;
    }
    public function insert($table_name, $data) {
        $sql = "insert into " . $table_name . " ";
        $sql .= "(";
        foreach ($data as $key => $value) {
            $sql .= $key . ",";
        }
        $sql = substr($sql, 0, -1);
        $sql .= ") values (";
        foreach ($data as $key => $value) {
            $sql .= ":" . $key . ",";
        }
        $sql = substr($sql, 0, -1);
        $sql .= ")";
        $stmt = $this->conn_obj->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        if ($stmt->execute()) {
            return $this->conn_obj->lastInsertId();
        } else {
            return false;
        }

    }
    // Normal selects with basic condition
    public function select($table_name, $condition = false) {
        $sql = "select * from " . $table_name;
        if ($condition !== false) {
            $sql .= " where ";
            foreach ($condition as $key => $value) {
                if ($key === "operator") {
                    $sql .= " " . $value . " ";
                } else {
                    $sql .= $key . "=:$key ";
                }
            }
            $sql = substr($sql, 0, -1);
        }
        $stmt = $this->conn_obj->prepare($sql);
        if ($condition !== false) {
            foreach ($condition as $key => $value) {
                if ($key !== "operator") {
                    $stmt->bindValue(":$key", $value);
                }
            }
        }
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        } else {
            return false;
        }
    }
    // Will be used for pagination
    public function get_page($table_name, $limit, $offset = 0, $condition = false) {
        $sql = "select * from " . $table_name;
        if ($condition !== false) {
            $sql .= " where ";
            foreach ($condition as $key => $value) {
                if ($key === "operator") {
                    $sql .= " " . $value . " ";
                } else {
                    $sql .= $key . "=:$key ";
                }
            }
            $sql = substr($sql, 0, -1);
        }
        $sql .= " limit $limit offset $offset";
        $stmt = $this->conn_obj->prepare($sql);
        if ($condition !== false) {
            foreach ($condition as $key => $value) {
                if ($key !== "operator") {
                    $stmt->bindValue(":$key", $value);
                }
            }
        }
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        } else {
            return false;
        }
    }
    // Updating data
    public function update($table_name, $data, $condition = false) {
        $sql = "update " . $table_name . " set ";
        foreach ($data as $key => $value) {
            $sql .= "$key = :$key ,";
        }
        $sql = substr($sql, 0, -1);
        if ($condition !== false) {
            $sql .= " where ";
            foreach ($condition as $key => $value) {
                if ($key === "operator") {
                    $sql .= " " . $value . " ";
                } else {
                    $sql .= $key . "=:$key ";
                }
            }
            $sql = substr($sql, 0, -1);
        }
        $stmt = $this->conn_obj->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        if ($condition !== false) {
            foreach ($condition as $key => $value) {
                if ($key !== "operator") {
                    $stmt->bindValue(":$key", $value);
                }
            }
        }
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }
    public function delete($table_name, $condition) {
        $sql = "delete from " . $table_name . " where ";
        foreach ($condition as $key => $value) {
            if ($key === "operator") {
                $sql .= " " . $value . " ";
            } else {
                $sql .= $key . "=:$key ";
            }
        }
        $sql = substr($sql, 0, -1);
        $stmt = $this->conn_obj->prepare($sql);
        if ($condition !== false) {
            foreach ($condition as $key => $value) {
                if ($key !== "operator") {
                    $stmt->bindValue(":$key", $value);
                }
            }
        }
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }
}
?>
