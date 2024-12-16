<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/config.php");

class _Redis{
    private $redis;
    private $db_Index;
    public function __construct($db_Index=0) {
        $c_redis = \config\get('redis');
        // 连接 Redis
        $redis = new Redis();
        $redis->connect($c_redis[0], $c_redis[1]);
        $redis->select($db_Index);
        $this->db_Index = $db_Index;
        $this->redis = $redis;
    }
    public function switch($db_Index){
        $this->db_Index = $db_Index;
        $this->redis->select($db_Index);
    }
    public function get($db_Index, $key, $default = false)
    {
        if($db_Index!=$this->db_Index){
            $this->switch($db_Index);
        }
        $value = $this->redis->get($key);
        if (!$value && $default) {
            $this->redis->set($key, $default);
            return $default;
        }
    
        return $value;
    }
    public function set($db_Index, $key, $value)
    {
        if($db_Index!=$this->db_Index){
            $this->switch($db_Index);
        }
        $this->redis->set($key, $value);
        return true;
    }
    public function close()
    {
        $this->redis->close();
    }
}