<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 1/16/17
 * Time: 11:29 AM
 */

namespace App\Models;

use App\Libraries\Util;
use Doctrine\ORM\Query;

class BaseModel
{
    protected $nameSpace;
    protected $modelName;
    protected $tableName;
    private $_app;

    public function __construct($tableName = null)
    {
        $this->modelName = get_called_class();
        $this->_app = Util::getApp();
        $this->_logger = $this->_app['monolog'];
        $this->tableName = $tableName;
    }

    public static function getAll($limit = null, $offset = null)
    {
        $className = get_called_class();
        $app = Util::getApp();
        $modelRepository = $app['orm.em']->getRepository('App\Models\Application');
        $models = $modelRepository->findAll();
        return $models;
    }

    public static function getOne($id)
    {
        $app = Util::getApp();
        $modelRepository = $app['orm.em']->getRepository('App\Models\Application');
        $models = $modelRepository->findOne($id);
        return $models;
    }

    public function save() {

    }

    public function create() {

    }

    public function update() {

    }

    public function delete() {

    }

    public function arrayForm()
    {

    }
}