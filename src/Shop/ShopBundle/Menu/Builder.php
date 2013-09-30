<?php

namespace Shop\ShopBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Doctrine\ORM\Mapping;

class Builder extends ContainerAware {

    public function mainMenu(FactoryInterface $factory, array $options) {

         
        $em = $this->container->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository('ShopShopBundle:Category');
        $menuitems = $repository->findAll();
        

        $menu = $factory->createItem('root');

        foreach ($menuitems as $item) {
            
            $menu->addChild($item->getCategoryName(), 
                    array('route' => 'shop_shop_categorypage',
                          'routeParameters'=>array('id'=> $item->getId())      
                        ));
        }
        return $menu;
    }
    
    

}