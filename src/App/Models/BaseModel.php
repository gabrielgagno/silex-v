<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 1/16/17
 * Time: 11:29 AM
 */

namespace App\Models;


class BaseModel
{
    protected $nameSpace;
    protected $modelName;
    protected $tableName;

    public function __construct($modelName, $tableName = null)
    {
        $this->nameSpace = 'App\Models';
        $this->modelName = $modelName;
        $this->tableName = $tableName;
    }

    public static function getAll($limit = null, $offset = null)
    {

    }

    public static function getOne($id)
    {

    }

    public function save() {

    }

    public function create() {

    }

    public function update() {

    }

    public function delete() {

    }
}