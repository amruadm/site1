<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\ProductOrder;
use AppBundle\Entity\User;
use AppBundle\Service\Minecraft\PermissionManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ServiceController extends Controller
{
    /**
     * @Route("/services/", name="services")
     */
    public function aboutAction(Request $request, PermissionManager $pexManager)
    {
        $robocassa_login = $this->container->getParameter('robocassa_login');
        $robocassa_pass = $this->container->getParameter('robocassa_pass');
        $robocassa_test_pass = $this->container->getParameter('robocassa_test_pass');

        //VIP and Premium
        $products = $this->getDoctrine()->getRepository(Product::class)->findBy(['id' => [1,2]]);

        $prod_arr = [];

        $user_id = 0;

        $user = $this->getUser();

        if(!empty($user))
            $user_id = $user->getId();

        foreach($products as $product)
        {
            $crc = $this->generateCRCHash($robocassa_login, $robocassa_pass, 0, $product->getId(), $user_id, $product->getPrice());
            $prod_arr[$product->getId()] = [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'crc' => $crc
            ];
        }

        $test_crc = $this->generateCRCHash($robocassa_login, $robocassa_test_pass, 0, 0, $user_id, 10);
        return $this->render("services/services.html.twig", [
            'products' => $prod_arr,
            'robocassa_login' => $robocassa_login,
            'custom_pay_crc' => md5("$robocassa_login::0:$robocassa_pass:Shp_item=3:Shp_user=$user_id"),
            'test_crc' => $test_crc
        ]);
    }

    /**
     * @Route("/payment/order/", name="payment/order")
     */
    public function orderAction(Request $request, PermissionManager $pexManager)
    {
        $robocassa_login = $this->container->getParameter('robocassa_login');
        $robocassa_pass = $this->container->getParameter('robocassa_pass2');

        $is_test = $request->get("IsTest") == 1;

        if($is_test)
            $robocassa_pass = $this->container->getParameter('robocassa_test_pass2');

        $out_summ = $request->get('OutSum');
        $inv_id = $request->get('InvId');
        $shp_item = $request->get('Shp_item');
        $shp_user_id = $request->get('Shp_user');
        $crc = $request->get('SignatureValue');

        $product = $this->getDoctrine()->getRepository(Product::class)->find($shp_item);
        if(!$is_test && empty($product))
        {
            return new Response('Unknown product', Response::HTTP_BAD_REQUEST);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->find($shp_user_id);
        if(empty($user))
        {
            return new Response('Unknown user', Response::HTTP_BAD_REQUEST);
        }

        $crc = strtoupper($crc);

        $prod_price = $out_summ;

        $prod_id = $is_test?$shp_item:$product->getId();

        $confirm_crc = $this->generateCRCHash(null, $robocassa_pass, $inv_id, $prod_id, $shp_user_id, $prod_price);
        $confirm_crc = strtoupper($confirm_crc);

        if($confirm_crc != $crc)
        {
            return new Response('Bad CRC '.$confirm_crc.'<br /> '.$inv_id.' '.$prod_id.' '.$shp_user_id.' '.$prod_price, Response::HTTP_BAD_REQUEST);
        }
        if(!$is_test)
        {
            if ($out_summ < $product->getPrice())
            {
                return new Response('Bad price', Response::HTTP_BAD_REQUEST);
            }
        }

        $order = new ProductOrder();
        $order->setId($inv_id);
        $order->setProductid($shp_item);
        $order->setConfirmed(true);
        $order->setHash($crc);
        $order->setAmount($prod_price);
        $order->setUserid($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();

        if(!$is_test)
        {
            $group = $pexManager->getFromProduct($product);
            if (!empty($group))
            {
                $pexManager->setGroup($user, $group);
            }
        }

        return new Response('OK'.$inv_id, Response::HTTP_OK);
    }

    private function generateCRCHash($login, $pass, $inv_id, $shp_item, $user_id, $price)
    {
        if(!empty($login))
            return md5("$login:$price:$inv_id:$pass:Shp_item=$shp_item:Shp_user=$user_id");
        else
            return md5("$price:$inv_id:$pass:Shp_item=$shp_item:Shp_user=$user_id");
    }

    /**
     * @Route("/payment/success/", name="payment/success")
     */
    public function successAction(Request $request)
    {
        return new Response('OK', Response::HTTP_OK);
    }

    /**
     * @Route("/payment/fail/", name="payment/success")
     */
    public function failAction(Request $request)
    {
        return new Response('OK', Response::HTTP_OK);
    }
}