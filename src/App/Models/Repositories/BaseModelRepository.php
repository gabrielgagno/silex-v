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
    public function findAll($limit = 0, $offset = 0, $returnType = Query::HYDRATE_OBJECT)
    {
        $em = Util::getApp()['orm.em'];
        $queryString = 'SELECT c from '.$this->_entityName. ' c limit '.$limit.' offset '.$offset;

        $query = $em->createQuery(
            $queryString
        );

        return $query->getResult($returnType);
    }

    public function findOne($id, $returnType = Query::HYDRATE_OBJECT)
    {
        $em = Util::getApp()['orm.em'];
        $query = $em->createQuery(
            'SELECT c from '.$this->_entityName. ' c where c.id='.$id
        );
        $result = null;
        try{
            $result = $query->getSingleResult($returnType);
        } catch (\Exception $e) {
            if($result==NULL){
                return null;
            }
        }

        return $query->getSingleResult($returnType);
    }

}