<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;


use Symfony\Component\Validator\Context\ExecutionContextInterface;

use App\Entity\Address;
use DateTime;

class AddressController extends Controller
{

    /**
     * @Route("/address", name="address")
     */
    public function index()
    {
        return $this->render('address/index.html.twig',["address" => NULL,"list"=>$this->getActiveAddresses()]);
    }

    private function getActiveAddresses()
    {
            return $this->getDoctrine()->getRepository(Address::class)
            ->findBy(
                ["status" => "1"],
                ["first_name" => "ASC"]
            );
    }

    /**
     * @Route("/address/edit/{id}", name="edit_address")
     */
    public function editAddress(Request $request,$id)
    {
        
            $address = $this->getDoctrine()
                ->getRepository(Address::class)
                ->find($id);
            
            if(!$address)
                return $this->render('address/index.html.twig',["address"=>NULL,"list"=>$this->getActiveAddresses()]);


            return $this->render('address/index.html.twig',["address"=>$address,"list"=>$this->getActiveAddresses()]);
    }

     /**
     * @Route("/address/search", name="search_address", methods={"GET","POST"})
     */
    public function searchAddress(Request $request)
    {

        $term = $request->request->get('search');

        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(Address::class)->createQueryBuilder('a');

        $lst = $qb->select('a')
            ->where("a.status = 1 and (a.first_name like concat('%',:term,'%') or a.last_name like concat('%',:term,'%') or a.phone like concat('%',:term,'%') or a.email like concat('%',:term,'%') )")
            ->setParameter(':term', $term)
            ->getQuery()
            ->getResult();


        return $this->render('address/index.html.twig',["address"=>NULL,"list"=>$lst]);
    }

    private function fillObject(Request $request,$address=NULL)
    {

        if(!$address)
            $address = new Address();
        $address->setFirstName($request->request->get('first_name'));
        $address->setLastName($request->request->get('last_name'));
        $address->setPhone($request->request->get('phone_no'));
        $address->setCity($request->request->get('city'));
        $address->setStatus(1);
        $address->setZip($request->request->get('zip_code') ? $request->request->get('zip_code') : NULL);
        $address->setStreet($request->request->get('street'));
        $address->setStreetNo($request->request->get('street_no') ? $request->request->get('street_no') : NULL);
        $address->setEmail($request->request->get('email'));
        $address->setCountry($request->request->get('country'));
        $address->setBirthday($request->request->get('birth_date') ? new DateTime($request->request->get('birth_date')) : NULL );
        $address->setCreatedAt(new \DateTime("now"));
        $address->setUpdatedAt(new \DateTime("now"));
        $address->setUpdatedBy("1");
        $address->setCreatedBy("1");
        return $address;
    }

    /**
     * @Route("/address/delete/{id}", name="delete_address", methods={"GET"})
     */
    public function deleteAddress(Request $request,$id)
    {
        $address = $this->getDoctrine()
                ->getRepository(Address::class)
                ->find($id);


         if(!$address)
            return $this->redirectToRoute("address");

        $address->setStatus(0);
        $address->setUpdatedAt(new \DateTime("now"));
        $address->setUpdatedBy("1");
        $em = $this->getDoctrine()->getManager();
        $em->flush($address);
    

        return $this->redirectToRoute("address");
    }

    /**
     * @Route("/address/update/{id}", name="update_address", methods={"POST"})
     */
    public function updateAddress(Request $request,ValidatorInterface $validator,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $address = $em->getRepository(Address::class)->find($id);


         if(!$address)
            return $this->redirectToRoute("address");

       
        $address = $this->fillObject($request,$address);
        $violations = $validator->validate($address);

        foreach($violations as $k=>$e){
             $this->addFlash(
                $e->getPropertyPath(),
                $e->getMessage()
            );
        }

        if(0 === count($violations))
        {
            $em->flush();
        }
        
        return $this->render('address/index.html.twig',["address"=>$address,"list"=>$this->getActiveAddresses()]);
    }
    /**
     * @Route("/address/add", name="create_address", methods={"POST"})
     */
    public function createAddress(Request $request,ValidatorInterface $validator)
    {

        $entityManager = $this->getDoctrine()->getManager();
       
        if ($request->getMethod() != 'POST') {
            die('Invalid request method');
        }

        $address = $this->fillObject($request);
        $violations = $validator->validate($address);

        foreach($violations as $k=>$e){
             $this->addFlash(
                $e->getPropertyPath(),
                $e->getMessage()
            );
        }

        if(0 === count($violations))
        {
            $entityManager->persist($address);
            $entityManager->flush();
        }

        return $this->render('address/index.html.twig',["address" => $address,"list"=>$this->getActiveAddresses()]);
    }
}
