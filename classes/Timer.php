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
  * @category   Database
  * @author     Protopixel <protopixel06@gmail.com>
  * @license    MIT License
  * @version    prerelease-1.0
  * @since      File available since v1.0-pre1
  */

include_once 'config.php';

class Timer
{

    public $id = null;

    public $comment = null;

    public $projectId = null;

    public $tagId = null;

    public $timeStarted = null;

    public $timeEnded = null;

    public $length = null;
        
    public $ownerId = null;

    public function __construct($data = array()) {
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->comment = isset($data['comment']) ? $data['comment'] : null;
        $this->projectId = isset($data['projectId']) ? $data['projectId'] : null;
        $this->tagId = isset($data['tagId']) ? $data['tagId'] : null;
        $this->timeStarted = isset($data['timeStarted']) ? $data['timeStarted'] : null;
        $this->timeEnded = isset($data['timeEnded']) ? $data['timeEnded'] : null;
        $this->length = isset($data['length']) ? $data['length'] : null;
        $this->ownerId = isset($data['ownerId']) ? $data['ownerId'] : null;
    }

    // Setup
    public function setup() {
        $this->create();
        $this->setComment();
        $this->setProject();
        $this->setTag();
    }

    // Create
    public function create() {
        $time = time();
        $this->timeStarted = $time;
        DB::query("INSERT INTO time (id, user_id, time_started) VALUES (:id, :user_id, :time_started)",
                  array(':id' => $this->id, ':user_id' => $this->ownerId, ':time_started' => $this->ownerId));
    }

    // Edit Comment, Project and Tag
    public function setComment() {
        DB::query("UPDATE time SET comment = :comment
                   WHERE id = :id
                   ORDER BY time_started DESC LIMIT 1",
                  array(':comment' => $this->comment, ':id' => $this->id));
    }        
    public function setProject() {
        DB::query("UPDATE time SET project_id = :projectId
                   WHERE id = :id
                   ORDER BY time_started DESC LIMIT 1",
                  array(':projectId' => $this->projectId, ':id' => $this->id));
    }
    public function setTag() {
        DB::query("UPDATE time SET tag_id = :tagId
                   WHERE id = :id
                   ORDER BY time_started DESC LIMIT 1",
                  array(':tagId' => $this->tagId, ':id' => $this->id));
    }

    // Pause
    public function pause() {
        $time = time();
        $timeStarted = DB::query("SELECT * FROM time 
                                  WHERE id=:id
                                  ORDER BY time_started DESC LIMIT 1", 
                                 array(':id' => $this->id))[0]['time_started'];
        DB::query("UPDATE time
                   SET time_ended = :now,
                       length     = :length
                   WHERE id = :id
                   ORDER BY time_started DESC LIMIT 1", 
                  array(':now' => $time, ':length' => $time - $timeStarted, ':id' => $this->id));
    }

    // Resume
    public function resume() {                            
        DB::query("INSERT INTO time (id, user_id, comment, project_id, tag_id, time_started)
                   VALUES (:id, :user_id, :comment, :project_id, :tag_id, :time_started)", 
                  array(':id' => $this->id, ':comment' => $this->comment,
                        ':project_id' => $this->projectId, ':tag_id' => $this->tagId,
                        ':time_started' => time()));
    }

    // View
    public function view() {
        $details = array(
            'id' => $this->id,
            'comment' => $this->comment,
            'projectId' => $this->projectId,
            'tagId' => $this->tagId,
            'timeStarted' => $this->timeStarted,
            'timeEnded' => $this->timeEnded,
            'length' => $this->length,
            'ownerId' => $this->ownerId
        );
        return json_encode($details);
    }

}
