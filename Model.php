<?php
class Model
{
    protected $table;
    protected $id;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(array $params)
    {
        $keys = array_keys($params); 
        $fields = $this->getInsertFields($keys); 
        $placeholders = $this->getInsertPlaceholders($keys); 

        $sql = 'INSERT INTO `' . $this->table . '` (' . $fields . ') VALUES (' . $placeholders . ');';

        $sth = $this->db->prepare($sql)->execute(array_values($params));
    }


    public function findOrCreate($id, array $params)
    {
        $model = $this->find($id);
        if ($model) {
            return $model;
        }

        $params[$this->id] = $id;
        $this->create($params);
    }


    public function find($id)
    {
        $sql = 'SELECT * FROM `' . $this->table . '` WHERE `' . $this->id . '` = ?;';
        $sth = $this->db->prepare($sql);
        
        $sth->execute(array($id));
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getWhere(array $params)
    {
        $keys = array_keys($params);
        $where = $this->getWhereWithPlaceholder($keys);

        $sql = 'SELECT * FROM `' . $this->table . '` WHERE ' . $where;
        $sth = $this->db->prepare($sql);
        
        $sth->execute(array_values($params));

        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        
        return $result;
    }

    private function getInsertFields(array $keys)
    {
        return '`' . implode('`, `', $keys) . '`';
    }

    private function getInsertPlaceholders(array $keys)
    {
        return substr(
            str_repeat('?,', count($keys)), 0, -1
        );
    }

    private function getWhereWithPlaceholder(array $keys)
    {
        $where = array();
        foreach ($keys as $key) {
            $where[] = '`' . $key . '` = ?';
        }

        return implode(', ', $where);
    }

}
