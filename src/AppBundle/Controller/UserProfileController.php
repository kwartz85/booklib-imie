<?php

namespace AppBundle\Controller;

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
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $usrfirstname = $usr->getFirstname();
        $usrlastname = $usr->getLastname();
        $usrmail = $usr->getEmail();
        $usrroles = $usr->getRoles();

        return $this->render('user/index.html.twig',
            [
                "firstname" => $usrfirstname,
                "lastname" => $usrlastname ,
                "mail" => $usrmail,
                "roles" => $usrroles
            ]
        );
    }
}
