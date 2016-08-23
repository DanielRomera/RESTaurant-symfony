<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Orders;

class RestaurantController extends Controller
{
    public function tablesAction(Request $request)
    {
       $em = $this->getDoctrine()->getManager();
       $tables = $em->getRepository("AppBundle\Entity\Tables")->findAll();
       
       return $this->render('default/tables.json.twig', array(
           'tables' => $tables
       ));
    }


    public function ordersAction(Request $request, $current_table)
    {
       $orders = $this->getDoctrine()
       ->getRepository('AppBundle:Orders')
       ->findBy(["table"=>$current_table]);
       
       
       return $this->render('default/orders.json.twig', array(
           'orders' => $orders
       ));        
    }    
    
    public function dishesAction(Request $request)
    {
       $dishes = $this->getDoctrine()
       ->getRepository('AppBundle:Dishes')->findAll();
       
       return $this->render('default/dishes.json.twig', array(
           'dishes' => $dishes
       ));         
    }
    
    public function finishAction(Request $request)
    {
       try{
            $current_table = $request->request->get('table');        
            $em = $this->getDoctrine()->getManager();
            $em->getRepository("AppBundle\Entity\Orders")->delete_orders($current_table);
            $result = 1;
        } 
        catch(Exception $e)
        {
            $result = 0;
        }
        
       return $this->render('default/response.json.twig', array(
           'result' => $result
       ));         
            
    }    
        
    function create_orderAction(Request $request)
    {
        try{

            $choosen_dish = $request->request->get('dish');
            $current_table = $request->request->get('table');

            $order = $this->getDoctrine()
            ->getRepository('AppBundle:Orders')
            ->findOneBy(["table"=>$current_table, "dish"=>$choosen_dish]);

            if($order){
                //The order already exists so, we have to increase the quantity
                $new_quantity = $order->getQuantity();
                $new_quantity++;
                $order->setQuantity($new_quantity);
            }
            else {
                //There are no current orders for that dish so, we create one                
                $order = $this->create_order($current_table,$choosen_dish);
            }

            $em = $this->getDoctrine()->getManager();    
            $em->persist($order);
            $em->flush();
            $result = 1;
        } 
        catch(Exception $e)
        {
            $result = 0;
        }
        
       return $this->render('default/response.json.twig', array(
           'result' => $result
       ));         
        
    }
    
    
    function create_order($current_table,$choosen_dish)
    {
        $table = $this->getDoctrine()
        ->getRepository('AppBundle:Tables')
        ->find($current_table);

        $dish = $this->getDoctrine()
        ->getRepository('AppBundle:Dishes')
        ->find($choosen_dish);

        $order = new Orders();
        $order->setQuantity(1);
        $order->setTable($table);
        $order->setDish($dish);
        
        return $order;
    }    
    
}
