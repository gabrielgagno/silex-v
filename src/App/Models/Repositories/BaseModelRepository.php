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
    public function findAll($returnType = Query::HYDRATE_OBJECT, $limit = 0, $offset = 0)
    {
        $em = Util::getApp()['orm.em'];
        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from($this->_entityName, 'u');

        if($limit>0) {
            $qb->setMaxResults($limit);
        }
        if($offset>0) {
            $qb->setFirstResult($offset);
        }

        $query = $qb->getQuery();

        $result = $query->getResult($returnType);
        return $result;
    }

    public function findOne($id, $returnType = Query::HYDRATE_OBJECT)
    {
        $em = Util::getApp()['orm.em'];
        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from($this->_entityName, 'u')
            ->where('u.id = '.$id);
        $query = $qb->getQuery();
        $result = $query->getOneOrNullResult($returnType);
        return $result;
    }

}