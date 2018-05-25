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

/**
 * Class Model | Core/Model.php
 *
 * @package     funombi\Core
 * @author      Nissar Chababy <contact at funilrys dot com>
 * @version     1.0.0
 * @copyright   Copyright (c) 2017, Nissar Chababy
 */

namespace Core;

use PDO;
use DateTime;
use App\Config\Database;
use Core\Files;

/**
 * Main logic behind Model call and usage.
 *
 * @author Nissar Chababy <contact at funilrys dot com>
 */
abstract class Model
{

    /**
     * Get and initiate the PDO database connection.
     * 
     * @staticvar PDO $db
     * 
     * @return PDO
     */
    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {

            $dsn = 'mysql:host=' . Database::DB_HOST . ';dbname=' . Database::DB_NAME . ';charset=utf8';
            $db  = new PDO($dsn, Database::DB_USER, Database::DB_PASSWORD);

            /**
             * Throw an Exception when an error occurs
             */
            $options = array(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $db = new PDO($dsn, Database::DB_USER, Database::DB_PASSWORD, $options);
        }

        return $db;
    }

    /**
     * Add prefix to table if Database::TABLE_PREFIX is set.
     * 
     * @param string $table Table name to add prefix to
     * @return string Table name with prefix
     */
    protected static function addPrefixToTable(string $table)
    {
        $prefix = Database::TABLE_PREFIX;
        if (!empty($prefix)) {
            $lastChar = '_';

            if (substr($prefix, -1) != $lastChar) {
                return $prefix . $lastChar . $table;
            }
            return $prefix . $table;
        }
        return $table;
    }

    /**
     * Return rows from the database based on the conditions.
     * 
     * @param string $table Name of the table
     * @param array $conditions  Conditions : select, where, where_or, where_operator, order_by, group_by, limit, return_type
     * @return boolean Data from database
     */
    protected static function getRows(string $table, array $conditions = array(), bool $debug = false)
    {
        $table = static::addPrefixToTable($table);

        if ($debug) {
            $debugInfo = array();
        }

        /**
         * Check if the key exist so we use the defined operator instead of '='
         */
        $operators = (array_key_exists('where_operator', $conditions)) ? $conditions['where_operator'] : '=';

        $sql = 'SELECT ';
        $sql .= array_key_exists("select", $conditions) ? $conditions['select'] : '*';
        $sql .= ' FROM ' . $table;

        if (array_key_exists("where", $conditions)) {
            $sql .= ' WHERE ';
            $i   = 0;

            foreach ($conditions['where'] as $key => $value) {
                $pre      = ($i > 0) ? ' AND ' : '';
                $operator = (is_array($operators)) ? $operators[$i] : $operators;
                $sql      .= $pre . "(" . $key . " " . $operator . "'" . $value . "')";

                $i++;
            }
        }

        if (array_key_exists("where_or", $conditions)) {
            if (!array_key_exists("where", $conditions)) {
                $sql .= ' WHERE ';
            }
            $i = 0;

            foreach ($conditions['where_or'] as $key => $value) {
                $key      = preg_replace('/_or/', '', $key);
                $pre      = ($i > 0) ? ' OR ' : '';
                $operator = (is_array($operators)) ? $operators[$i] : $operators;
                $sql      .= $pre . "(" . $key . " " . $operator . "'" . $value . "')";

                $i++;
            }
        }

        if (array_key_exists("group_by", $conditions)) {
            $sql .= ' GROUP BY ' . $conditions['group_by'];
        }

        if (array_key_exists("order_by", $conditions)) {
            $sql .= ' ORDER BY ' . $conditions['order_by'];
        }

        if (array_key_exists("start", $conditions) && array_key_exists("limit", $conditions)) {
            $sql .= ' LIMIT ' . $conditions['start'] . ',' . $conditions['limit'];
        } elseif (!array_key_exists("start", $conditions) && array_key_exists("limit", $conditions)) {
            $sql .= ' LIMIT ' . $conditions['limit'];
        }

        $db    = static::getDB();
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
        } elseif ($query->rowCount() > 0) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }

        if ($debug) {
            $debugInfo = array_merge($debugInfo, array(
                'statement'      => $sql,
                'extracted_data' => $data
                    )
            );
            
            \Kint::dump($debugInfo);
        }

        return $data;
    }

    /**
     * Insert data into the database.
     * 
     * @param string $table Name of the table
     * @param array $data Data to insert to table
     * @return boolean 
     */
    protected static function insert(string $table, array $data)
    {
        $table = static::addPrefixToTable($table);

        if (!empty($data) && is_array($data)) {
            $columns = '';
            $values  = '';
            $i       = 0;

            if (!array_key_exists('created', $data)) {
                $date            = new DateTime();
                $data['created'] = $date->getTimestamp();
            }

            if (!array_key_exists('modified', $data)) {
                $data['modified'] = $date->getTimestamp();
            }

            $columnString = implode(',', array_keys($data));
            $valueString  = ":" . implode(',:', array_keys($data));
            $sql          = "INSERT INTO " . $table . " (" . $columnString . ") VALUES (" . $valueString . ")";

            $db    = static::getDB();
            $query = $db->prepare($sql);

            foreach ($data as $key => $val) {
                $query->bindValue(':' . $key, $val);
            }

            $insert = $query->execute();

            if ($insert) {
                return $db->lastInsertId();
            }
            return false;
        }
        return false;
    }

    /**
     * Update data into the database.
     * 
     * @param string $table Name of the table
     * @param array $data Data to update
     * @param array $conditions WHERE statement
     * @param array|string $operator Sign of WHERE statement
     * @return booleanean
     */
    protected static function update(string $table, array $data, array $conditions, $operators = '=')
    {
        $table = static::addPrefixToTable($table);


        if (!empty($data) && is_array($data)) {
            $colvalSet = '';
            $whereSql  = '';
            $i         = 0;

            if (!array_key_exists('modified', $data)) {
                $date             = new DateTime();
                $data['modified'] = $date->getTimestamp();
            }

            foreach ($data as $key => $val) {
                $pre       = ($i > 0) ? ', ' : '';
                $colvalSet .= $pre . $key . "='" . $val . "'";

                $i++;
            }

            if (!empty($conditions) && is_array($conditions)) {
                $whereSql .= ' WHERE ';
                $i        = 0;

                foreach ($conditions as $key => $value) {
                    $pre = ($i > 0) ? ' AND ' : '';

                    $operator = (is_array($operators)) ? $operators[$i] : $operators;
                    $whereSql .= $pre . $key . " " . $operator . "'" . $value . "'";

                    $i++;
                }
            }

            $sql    = "UPDATE " . $table . " SET " . $colvalSet . $whereSql;
            $db     = static::getDB();
            $query  = $db->prepare($sql);
            $update = $query->execute();

            if ($update) {
                return $query->rowCount();
            }
            return false;
        }
        return false;
    }

    /**
     * Delete data from the database.
     * 
     * @param string $table Name of the table
     * @param array $conditions WHERE statement
     * @return boolean
     */
    public static function delete(string $table, array $conditions)
    {
        $table = static::addPrefixToTable($table);

        $whereSql = '';
        if (!empty($conditions) && is_array($conditions)) {
            $whereSql .= ' WHERE ';
            $i        = 0;

            foreach ($conditions as $key => $value) {
                $pre      = ($i > 0) ? ' AND ' : '';
                $whereSql .= $pre . $key . " = '" . $value . "'";

                $i++;
            }
        }

        $sql    = "DELETE FROM " . $table . $whereSql;
        $db     = static::getDB();
        $delete = $db->exec($sql);

        if ($delete) {
            return true;
        }
        return false;
    }

    /**
     * Check if App\Config\Database is at its default state.
     * 
     * @return boolean
     */
    public static function isDefaultDatabaseConfig()
    {
        $consts = array(
            'DB_HOST'      => 'your-database-host',
            'DB_NAME'      => 'your-database-name',
            'DB_USER'      => 'your-database-username',
            'DB_PASSWORD'  => 'your-database-password',
            'TABLE_PREFIX' => 'your-table-prefix'
        );

        $root         = Files::getRoot();
        $databaseFile = $root . 'App' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'Database.php';
        $currentFile  = file_get_contents($databaseFile);

        foreach ($consts as $key => $value) {
            if (preg_match("/const $key = '$value';/", $currentFile)) {
                return true;
            }
        }
        return false;
    }

}
