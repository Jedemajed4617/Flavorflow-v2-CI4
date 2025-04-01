<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $authenticated_required = ['dashboard', 'profile'];

        $logged_in = ['account', 'login', 'register'];

        $segment = $request->getUri()->getSegment(1); 

        // when user is not logged in navigate the user to account login
        if (in_array($segment, $authenticated_required) && !$session->get('logged_in')) {
            return redirect()->to('/account')->with('error', 'Je moet ingelogd zijn.');
        }

        // when user is logged in navigate the user to profile
        if (in_array($segment, $logged_in) && $session->get('logged_in')) {
            return redirect()->to('/profile');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No changes needed after request
    }
}