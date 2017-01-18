<?php
/**
 * Created by IntelliJ IDEA.
 * User: gjpgagno
 * Date: 1/18/17
 * Time: 10:32 AM
 */

namespace App\Models\Repositories;


use App\Libraries\Util;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class BaseModelRepository extends EntityRepository
{
    public function findAll($limit = null, $offset = null, $returnType = Query::HYDRATE_OBJECT)
    {
        $em = Util::getApp()['orm.em'];
        $query = $em->createQuery(
            'SELECT c from '.$this->_entityName. ' c'
        );

        return $query->getResult($returnType);
    }

    public function findOne($id, $returnType = Query::HYDRATE_OBJECT)
    {
        $em = Util::getApp()['orm.em'];
        $query = $em->createQuery(
            'SELECT c from '.$this->_entityName. ' c where id='.$id
        );

        return $query->getResult($returnType);
    }

}