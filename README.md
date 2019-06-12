# phporm
A php library to map mysql tables to php model objects and perform crud operations via model instance.
<code>
<?php
include_once "SQL.php";
class DBObject extends SQLQuery
{
    protected $table, $foreign_key_name;
    protected $created_stamp,$update_stamp;
    private function getModelNameAsTableName()
    {
        return strtolower(get_called_class()) . 's';
    }
    private function getModelName()
    {
        return get_called_class();
    }
    /**
     * create new blank instance of the model
     */
    private static function getModelInstance()
    {
        $obj = get_called_class();
        return new $obj;
    }
    public function setTable($tableName)
    {
        $this->table = $tableName;
        return $this;
    }
    public function getTable()
    {
        if (!isset($this->table)) {
            $this->setTable($this->getModelNameAsTableName());

            return $this->table;
        }
        return $this->table;
    }
    public function setForeignKeyName($keyName)
    {
        $this->foreign_key_name = $keyName;
        return $this;
    }
    public function getForeignKeyName()
    {
        if (!isset($this->foreign_key_name)) {
            $this->setForeignKeyName(strtolower(get_called_class()) . '_id');

            return $this->foreign_key_name;
        }
        return $this->foreign_key_name;
    }
    /**
     * instanciate the current model
     * pass assoc array to initialize fields
     */

    public static function instantiate($record)
    {
        //create new instance
        $object = self::getModelInstance();
        foreach ($record as $attribute => $value) { 
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }
    /**
     * @param Class , Record
     * instantiate a new model
     * pass assoc array to initialize fields
     */

    public static function instantiate_m($model, $record)
    {
        //create an instance of passed model
        $object = new $model;
        foreach ($record as $attribute => $value) {
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    private function has_attribute($attribute)
    {
        // get_object_vars returns an associative array with all attributes
        // (incl. private ones!) as the keys and their current values as the value
        $object_vars = get_object_vars(self::getModelInstance());
        // We don't care about the value, we just want to know if the key exists
        // Will return true or false
        return array_key_exists($attribute, $object_vars);
    }
    /**
     * return model array from input array
     */
    public static function resultSetToModelArray($results)
    {
        $modelArray = array();
        for ($i = 0; $i < count($results); $i++) {

            array_push($modelArray, self::instantiate($results[$i]));
        }

        return $modelArray;
    }

    /**
     * return model array from input array
     */
    public static function resultSetToModelArray_m($model, $results)
    {
        $modelArray = array();
        for ($i = 0; $i < count($results); $i++) {
            array_push($modelArray, self::instantiate_m($model, $results[$i]));
        }
        return $modelArray;
    }

    /**
     * get assoc array of field -> value from object
     */
    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }
    /**
     * get json_string from object
     */
    public function toJSON()
    {
        return json_encode($this);
    }
    /*
    returns array of Model Objects
     */
    public static function all()
    {
        $obj = self::getModelInstance();
        return self::resultSetToModelArray(self::query("SELECT * FROM " . $obj->getTable()));
    }
    public static function id($id)
    {
        $obj = self::getModelInstance();
        $record = self::query("SELECT * FROM " . $obj->getTable() . " WHERE id = " . $id);
        // echo "SELECT * FROM " . $obj->getTable() . " WHERE id = " . $id;
        return self::resultSetToModelArray($record)[0];

    }
    /**
     * Saves the current object to its table
     *  */
    public function save()
    {
       return  self::insert($this->getTable(), $this->toArray());
    }
    /**
     * delete the object from table ,called from object context
     */
    public function delete()
    { 
        return self::nonQuery("DELETE FROM " . $this->getTable() . " WHERE id = " . $this->id);

    }
    /**
     * Updates the current model and saves to its table
     */
    public function update()
    {
       $data = $this->toArray();
       // print_r($data);
       $upd = '';
       foreach ($data as $key => $value) {
             if($key != 'id'){
                if ($upd != '') {
                    $upd .= ' , ';
                }
                $upd .= "`{$key}` = '{$value}'";
            }
       }
        $sql = "UPDATE `{$this->getTable()}` SET {$upd} WHERE `id` = {$this->id}";
        // echo $sql;
        self::nonQuery($sql);
        return self::id($this->id);
    }
    /**
     * Fetches an array of model objects via relationship
     */
    public function findAll($class,$key_name)
    {
        $childObj = new $class;
        $key =  $key_name == null ? $this->getForeignKeyName() : $key_name;
        $query = "SELECT * FROM `{$childObj->getTable()}` WHERE `{$key}` = {$this->id}";
        return self::resultSetToModelArray_m($class,self::query($query));
    }
    public static function where($argsArray,$extra_sql)
    {
        //construct where clause
        //e.g where id = '0' and age = ''
        $where = '';
        if (is_array($argsArray)) {
            foreach ($argsArray as $key => $value) {
                # code...
                if ($where != '') {
                    $where .= ' AND ';
                }
                $where .= "`{$key}` = '{$value}'";
            }
        } else {
            $where = $argsArray;
        }
        $obj = self::getModelInstance();
    $results = self::resultSetToModelArray(self::query("SELECT * FROM `{$obj->getTable()}` WHERE {$where} {$extra_sql}"));
        // if(count($results) == 1){
        //      return $results[0];
        //  }else{
             return $results;
        //  }

    }
}
</code>
