<?
namespace AppBundle\Entity\Repositories;

use Doctrine\ORM\EntityRepository;

class OrdersRepository extends EntityRepository
{
    public function delete_orders($table)
    {
        return $this->_em->createQuery('DELETE FROM AppBundle\Entity\Orders o WHERE o.table = '.$table)
                         ->getResult();
    }
    
    public function create_order($table,$dish)
    {
        return $this->_em->createQuery('INSERT INTO AppBundle\Entity\Orders o (o.quantity, o.table, o.dish) values (1,$table,$dish)')
                         ->getResult();
    }
}
?>