<?php

namespace Mooi\WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mooi\WallBundle\Entity\Post;
use Mooi\WallBundle\Entity\Reply;
use Mooi\WallBundle\Form\Type\WallPostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class WallController extends Controller
{

    public function indexAction($id)
    {
        
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();
        $wallOwner = $this->getDoctrine()
            ->getRepository('MooiUserBundle:User')
            ->find($id);
        
        /*$rp = $this->getDoctrine()
                   ->getRepository('MooiUserBundle:User');
        $query = $rp->createQueryBuilder('u')
            ->where('u.id = :id')
            ->setParameter('id', $id)*/
            
        /*$query = 'SELECT u 
                        FROM MooiUserBundle:User u 
                        INNER JOIN MooiWallBundle:Post p  
                        WHERE u.id = :id
                        ORDER BY p.time DESC';
            $em = $this->getDoctrine()->getEntityManager();
            $result = $em->createQuery($query)
                        ->setParameter('id', $id);
            $wallOwner = $result->getResult();*/
        
        $roleId = $user->getRole()->getId();
        
        //set new post object and create form
        $newPost = new Post();
        $form = $this->createForm(new WallPostType(), $newPost);
       
            
            return $this->render('MooiWallBundle:Wall:index.html.twig', array(
                    'form'              => $form->createView(),
                    'id'                => $id,
                    'wallOwner'         => $wallOwner
            ));

      

        
    }
    

}
