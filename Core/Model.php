<?php

/*
 * The MIT License
 *
 * Copyright 2017 Nissar Chababy <contact at funilrys dot com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Core;

use PDO;
use App\Config\Database;

/**
 * Base Model
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
abstract class Model
{

    /**
     * Get and initiate the PDO database connection
     * 
     * @return mixed
     */
    protected static function getDB()
    {
        static $db = null;
        if ($db === null) {

            $dsn = 'mysql:host=' . Database::DB_HOST . ';dbname=' . Database::DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, Database::DB_USER, Database::DB_PASSWORD);
            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }

    /**
     * Return rows from the database based on the conditions
     * 
     * @param string $table
     * @param array $conditions  Conditions : select, where, where_or, order_by, limit, return_type
     * @return array
     */
    protected static function getRows($table, $conditions = array())
    {
        $sql = 'SELECT ';
        $sql .= array_key_exists("select", $conditions) ? $conditions['select'] : '*';
        $sql .= ' FROM ' . $table;
        if (array_key_exists("where", $conditions)) {
            $sql .= ' WHERE ';
            $i = 0;
            foreach ($conditions['where'] as $key => $value) {
                $pre = ($i > 0) ? ' AND ' : '';
                $sql .= $pre . $key . " = '" . $value . "'";
                $i++;
            }
        }
        if (array_key_exists("where_or", $conditions)) {
            $sql .= ' WHERE ';
            $i = 0;
            foreach ($conditions['where_or'] as $key => $value) {
                $pre = ($i > 0) ? ' OR ' : '';
                $sql .= $pre . $key . " = '" . $value . "'";
                $i++;
            }
        }

        if (array_key_exists("order_by", $conditions)) {
            $sql .= ' ORDER BY ' . $conditions['order_by'];
        }

        if (array_key_exists("start", $conditions) && array_key_exists("limit", $conditions)) {
            $sql .= ' LIMIT ' . $conditions['start'] . ',' . $conditions['limit'];
        } elseif (!array_key_exists("start", $conditions) && array_key_exists("limit", $conditions)) {
            $sql .= ' LIMIT ' . $conditions['limit'];
        }
        $db = static::getDB();
        $query = $db->prepare($sql);
        $query->execute();

        if (array_key_exists("return_type", $conditions) && $conditions['return_type'] != 'all') {
            switch ($conditions['return_type']) {
                case 'count':
                    $data = $query->rowCount();
                    break;
                case 'single':
                    $data = $query->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $data = '';
            }
        } else {
            if ($query->rowCount() > 0) {
                $data = $query->fetchAll();
            }
        }
        if (!empty($data)) {
            return $data;
        }
        return !empty($data) ? $data : false;
    }

    /**
     * Insert data into the database
     * 
     * @param string $table
     * @param array $data Data to insert to table
     * @return boolean
     */
    protected static function insert($table, $data)
    {
        if (!empty($data) && is_array($data)) {
            $columns = '';
            $values = '';
            $i = 0;
            if (!array_key_exists('created', $data)) {
                $data['created'] = date("Y-m-d H:i:s");
            }
            if (!array_key_exists('modified', $data)) {
                $data['modified'] = date("Y-m-d H:i:s");
            }

            $columnString = implode(',', array_keys($data));
            $valueString = ":" . implode(',:', array_keys($data));
            $sql = "INSERT INTO " . $table . " (" . $columnString . ") VALUES (" . $valueString . ")";

            $db = static::getDB();
            $query = $db->prepare($sql);

            foreach ($data as $key => $val) {
                $query->bindValue(':' . $key, $val);
            }
            $insert = $query->execute();
            return $insert ? $this->db->lastInsertId() : false;
        } else {
            return false;
        }
    }

    /**
     * Update data into the database
     * 
     * @param string $table Name of the table
     * @param array $data Data to update
     * @param array $conditions 
     * @return boolean
     */
    protected static function update($table, $data, $conditions)
    {
        if (!empty($data) && is_array($data)) {
            $colvalSet = '';
            $whereSql = '';
            $i = 0;
            if (!array_key_exists('modified', $data)) {
                $data['modified'] = time();
            }
            foreach ($data as $key => $val) {
                $pre = ($i > 0) ? ', ' : '';
                $colvalSet .= $pre . $key . "='" . $val . "'";
                $i++;
            }
            if (!empty($conditions) && is_array($conditions)) {
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach ($conditions as $key => $value) {
                    $pre = ($i > 0) ? ' AND ' : '';
                    $whereSql .= $pre . $key . " = '" . $value . "'";
                    $i++;
                }
            }
            $sql = "UPDATE " . $table . " SET " . $colvalSet . $whereSql;
            echo $sql;
            $db = static::getDB();
            $query = $db->prepare($sql);
            $update = $query->execute();
            return $update ? $query->rowCount() : false;
        } else {
            return false;
        }
    }

    /**
     * Delete data from the database
     * 
     * @param string $table
     * @param array $conditions
     * @return boolean
     */
    public static function delete($table, $conditions)
    {
        $whereSql = '';
        if (!empty($conditions) && is_array($conditions)) {
            $whereSql .= ' WHERE ';
            $i = 0;
            foreach ($conditions as $key => $value) {
                $pre = ($i > 0) ? ' AND ' : '';
                $whereSql .= $pre . $key . " = '" . $value . "'";
                $i++;
            }
        }
        $sql = "DELETE FROM " . $table . $whereSql;
        $db = static::getDB();
        $delete = $db->exec($sql);

        if ($delete === true) {
            return true;
        }
        return false;
    }

    /**
     * Get the current value of \App\Config\Sessions::SECURED_COOKIES
     *  and generate the complete site URL
     * 
     * @return string
     */
    public static function siteURL()
    {
        $http = \App\Config\Sessions::SECURED_COOKIES ? 'https://' : 'http://';
        return $http . $_SERVER['HTTP_HOST'] . explode('index.php', $_SERVER['REDIRECT_URL'])[0];
    }

}
