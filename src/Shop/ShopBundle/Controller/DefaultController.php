<?php

namespace Shop\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShopShopBundle:Homepage:index.html.twig');
    }
}
