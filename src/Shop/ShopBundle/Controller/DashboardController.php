<?php

namespace Shop\ShopBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Shop\ShopBundle\Entity\Address as address;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Shop\ShopBundle\Form\Type\AddressFormType as addressform;

class DashboardController extends Controller
{
    public function show_shippingAction(Request $request)
    {

        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
            if($user->getShippingAddress()== null){            
                $ADDRESS=new address;              
            }else{
                $ADDRESS =$user->getShippingAddress();
            }

            $form = $this->createForm(new addressform, $ADDRESS);
            
            if ('POST' === $request->getMethod()) {
            $form->bind($request);
            $em= $this->getDoctrine()->getManager();
            if ($form->isValid()) {
                if($ADDRESS->getId() != null){
                    $em->flush();
                    
                }else{
                    $address = new \Shop\ShopBundle\Entity\Address();
                    $address->setAddress($_POST['address_form_type']['address']);
                    $address->setCity($_POST['address_form_type']['city']);
                    $address->setCountry($_POST['address_form_type']['country']);
                    $address->setFirstname($_POST['address_form_type']['firstname']);
                    $address->setLastname($_POST['address_form_type']['lastname']);
                    $address->setEmail($_POST['address_form_type']['email']);
                    $user->setShippingAddress($address);
                    $em->persist($address);
                    $em->flush();
                }
  
            }
        }
            return $this->render('ShopShopBundle:Dashboard:shipping.html.twig', array(
                    'form' => $form->createView()));
    }
    
    public function show_billingAction(Request $request)
    {

        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
            if($user->getBillingAddress()== null){            
                $ADDRESS=new address;              
            }else{
                $ADDRESS =$user->getBillingAddress();
            }

            $form = $this->createForm(new \Shop\ShopBundle\Form\Type\AddressFormType(), $ADDRESS);
            
            if ('POST' === $request->getMethod()) {
            $form->bind($request);
            $em= $this->getDoctrine()->getManager();
            if ($form->isValid()) {
                if($ADDRESS->getId() != null){
                    $em->flush();
                    
                }else{
                    $address = new \Shop\ShopBundle\Entity\Address();
                    $address->setAddress($_POST['address_form_type']['address']);
                    $address->setCity($_POST['address_form_type']['city']);
                    $address->setCountry($_POST['address_form_type']['country']);
                    $address->setFirstname($_POST['address_form_type']['firstname']);
                    $address->setLastname($_POST['address_form_type']['lastname']);
                    $address->setEmail($_POST['address_form_type']['email']);
                    $user->setBillingAddress($address);
                    $em->persist($address);
                    $em->flush();
                }
            }
        }
            return $this->render('ShopShopBundle:Dashboard:billing.html.twig', array(
                    'form' => $form->createView()));
    }
}
