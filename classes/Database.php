<?php 
/**
  * File for database class.
  * 
  * This file contains a class that connects to the database and makes queries.
  * 
  * PHP version 7.4.27
  * 
  * LICENSE: MIT License
  *
  * Copyright (c) 2022 Protopixel
  *
  * Permission is hereby granted, free of charge, to any person obtaining a copy
  * of this software and associated documentation files (the "Software"), to deal
  * in the Software without restriction, including without limitation the rights
  * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  * copies of the Software, and to permit persons to whom the Software is
  * furnished to do so, subject to the following conditions:
  *
  * The above copyright notice and this permission notice shall be included in all
  * copies or substantial portions of the Software.
  *
  * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  * SOFTWARE.
  * 
  * @category   Core
  * @author     Protopixel <protopixel06@gmail.com>
  * @license    MIT License
  * @version    prerelease-1.0
  * @since      File available since v1.0-pre1
  */

  /* -------------------------------------------------------------------------- */
  /*                                  Includes                                  */
  /* -------------------------------------------------------------------------- */
  include_once 'config.php';
  
/**
 * Database class
 *
 * A class that connects to the database and makes queries.
 * 
 * @license    MIT License
 * @version    prerelease-1.0
 * @since      Class available since alpha-2.1.1
 */ 
class DB {
    private static function connect() {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=timetracker;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function query($query, $params = array()) {
        $stmt = self::connect()->prepare($query);
        $stmt->execute($params);

        if(explode(' ', $query)[0] == 'SELECT') {
            $data = $stmt->fetchAll();
            return $data;
        }
    }

    public static function count($query, $params = array()) {
        if(explode(' ', $query)[0] == 'SELECT') {
            // $data = $stmt->fetchAll();
            // return $data;
            $stmt = self::connect()->prepare($query);
            $stmt->execute($params);
            return count($stmt->fetchAll());
        }
    }
}