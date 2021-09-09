<?php 

use Engine\src\Db;

class Browse
{
  public function __construct()
  {
    $this->db   = new Db();
    $this->auth = new Auth();
  }

  public function getNewVideos()
  {
    $data = $this->db->query("SELECT * FROM (SELECT * FROM `music` WHERE hide IS NULL AND deleted IS NULL ORDER BY published_at DESC LIMIT 100) sub ORDER BY published_at DESC")->fetchAll();
    return '{"code": 200, "status": "success", "message": "Successfully fetched last 50 videos.", "items": '.json_encode($data).'}';
  }

  public function getAllChannels()
  {
    $data = $this->db->query("SELECT * FROM `channels`")->fetchAll();
    return '{"code": 200, "status": "success", "message": "Successfully fetched channels list.", "items": '.json_encode($data).'}';
  }

  public function getChannelById($channel)
  {
    if (!isset($channel))
    {
      return '{"code": 404, "status": "error", "message": "Missing params, nothing to show."}';
    }
    $id = $this->db->query("SELECT * FROM `channels` WHERE id=$channel")->fetchAll()[0]['channel_id'];
    $data = $this->db->query("SELECT * FROM `music` WHERE channel_id=\"$id\" AND hide IS NULL AND deleted IS NULL ORDER BY published_at DESC")->fetchAll();
    if (count($data) > 0)
    {
      return '{"code": 200, "status": "success", "message": "Successfully fetched channel by id: '.$channel.'", "items": '.json_encode($data).'}';
    }
    else
    {
      return '{"code": 200, "404": "error", "message": "Cannot find anything in channel with id: '.$id.'", "items": '.json_encode($data).'}';
    }
  }

  public function getVideo($video)
  {
    if (!isset($video))
    {
      return '{"code": 404, "status": "error", "message": "Missing params. Nothing to show."}';
    }
    $data = $this->db->query("SELECT * FROM `music` WHERE id=$video AND hide IS NULL AND deleted IS NULL")->fetchAll();
    if (count($data) > 0) 
    {
      return '{"code": 200, "status": "success", "message": "Successfully fetched video by id: '.$video.'", "items": '.json_encode($data).'}';
    }
    else
    {
      return '{"code": 200, "404": "error", "message": "Cannot find video with id: '.$video.'", "items": '.json_encode($data).'}';
    }
  }
}