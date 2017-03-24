<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserProfileController extends Controller
{
    /**
     * @Route("/user", name="user_profile")
     *
     */

    public function userProfileAction(Request $request)
    {
        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $lastBorrow= $this->getDoctrine()->getRepository("AppBundle:Borrow")->findLastBorrow($user->getId());

        return $this->render('user/index.html.twig',
            [
                "user" => $user,
                "lastBorrow"=> $lastBorrow
            ]
        );
    }


}
