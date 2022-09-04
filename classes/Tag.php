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
 * Creates a tag
 * 
 * @param integer $userId  ID of the user
 * @param string  $name    Comment
 * 
 * @author     Protopixel <protopixel06@gmail.com>
 */
function createTag($userId, $name) {
    DB::query("INSERT INTO tags (name, user_id) VALUES (:name, :userId)", array(':name'=>$name, ':userId'=>$userId));
}

/**
 * Edits a tag
 * 
 * @param integer $tagId  ID of the tag
 * @param string  $name   Comment
 * 
 * @author     Protopixel <protopixel06@gmail.com>
 */
function editTag($tagId, $name) {
    DB::query("UPDATE tags SET name=:value WHERE id=:tagId", array(':value'=>$name, ':tagId'=>$tagId));
}

/**
 * Deletes a tag
 * 
 * @param integer $tagId  ID of the tag
 * 
 * @author     Protopixel <protopixel06@gmail.com>
 */
function deleteTag($tagId) {
    DB::query("DELETE FROM tags WHERE id=:tagId", array(':tagId'=>$tagId));
}

/**
 * Gets id of the tag
 * 
 * @param integer $userId  ID of the user
 * @param string  $name    Comment
 * 
 * @return integer
 * 
 * @author     Protopixel <protopixel06@gmail.com>
 */
function getTag($userId, $name) {
    $id = DB::count("SELECT * FROM tags WHERE name=:name AND user_id=:userId", array(':name'=>$name, ':userId'=>$userId)) ? DB::query("SELECT * FROM tags WHERE name=:name AND user_id=:userId", array(':name'=>$name, ':userId'=>$userId))[0]['id'] : null;
    return $id;
}

/**
 * Gets the list of users tags
 * 
 * @param integer $userId  ID of the user
 * 
 * @return array
 * 
 * @author     Protopixel <protopixel06@gmail.com>
 */
function listTags($userId) {
    if(DB::count("SELECT * FROM tags WHERE user_id=:userId", array(':userId'=>$userId)) >= 1) {
        return DB::query("SELECT * FROM tags WHERE user_id=:userId", array(':userId'=>$userId));
    } else {
        echo json_encode(array("error"=>"No tags found for this user"));
        return null;
    }
}