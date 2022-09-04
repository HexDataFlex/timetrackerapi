<?php 

/**
  * File for Project class and functions.
  * 
  * This file contains a class that manipulates with projects.
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
  * @category   Tracker
  * @author     Protopixel <protopixel06@gmail.com>
  * @license    MIT License
  * @version    prerelease-1.0
  * @since      File available since v1.0-pre1
  */

  /* -------------------------------------------------------------------------- */
  /*                                  Includes                                  */
  /* -------------------------------------------------------------------------- */
  include_once 'config.php';
  
/* -------------------------------------------------------------------------- */

/**
 * Creates a project
 * 
 * @param integer $userId  ID of the user
 * @param string  $name    Comment
 * 
 * @author     Protopixel <protopixel06@gmail.com>
 */
function createProject($userId, $name) {
    DB::query("INSERT INTO projects (name, user_id) VALUES (:name, :userId)", array(':name'=>$name, ':userId'=>$userId));
}

/**
 * Edits a project
 * 
 * @param integer $projectId  ID of the project
 * @param string  $name   Comment
 * 
 * @author     Protopixel <protopixel06@gmail.com>
 */
function editProject($projectId, $name) {
    DB::query("UPDATE projects SET name=:value WHERE id=:projectId", array(':value'=>$name, ':projectId'=>$projectId));
}

/**
 * Deletes a project
 * 
 * @param integer $projectId  ID of the project
 * 
 * @author     Protopixel <protopixel06@gmail.com>
 */
function deleteProject($projectId) {
    DB::query("DELETE FROM projects WHERE id=:tagId", array(':tagId'=>$projectId));
}

/**
 * Gets id of the project
 * 
 * @param integer $userId  ID of the user
 * @param string  $name    Comment
 * 
 * @return integer
 * 
 * @author     Protopixel <protopixel06@gmail.com>
 */
function getProject($userId, $name) {
    $id = DB::count("SELECT * FROM projects WHERE name=:name AND user_id=:userId", array(':name'=>$name, ':userId'=>$userId)) ? DB::query("SELECT * FROM projects WHERE name=:name AND user_id=:userId", array(':name'=>$name, ':userId'=>$userId))[0]['id'] : null;
    return $id;
}

/**
 * Gets the list of users projects
 * 
 * @param integer $userId  ID of the user
 * 
 * @return array
 * 
 * @author     Protopixel <protopixel06@gmail.com>
 */
function listProjects($userId) {
    if(DB::count("SELECT * FROM projects WHERE user_id=:userId", array(':userId'=>$userId)) >= 1) {
        return DB::query("SELECT * FROM projects WHERE user_id=:userId", array(':userId'=>$userId));
    } else {
        echo json_encode(array("error"=>"No projects found for this user"));
        return null;
    }
}