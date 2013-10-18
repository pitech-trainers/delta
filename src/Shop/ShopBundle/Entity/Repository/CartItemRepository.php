<?php

namespace Shop\ShopBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CartItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CartItemRepository extends EntityRepository {

    public function removeItems($id) {
        $query = $this->_em->createQuery('DELETE FROM Shop\ShopBundle\Entity\CartItem c where c.id = ?1');
        $query->setParameter(1, $id);
        $result = $query->getResult();
       
    }
    public function clearCart($id) {
        $query = $this->_em->createQuery('DELETE FROM Shop\ShopBundle\Entity\CartItem c where c.cart = ?1');
        $query->setParameter(1, $id);
        $result = $query->getResult();
       
    }
    


}