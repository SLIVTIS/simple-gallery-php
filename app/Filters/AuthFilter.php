<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    /*public function before(RequestInterface $request, $arguments = null)
    {
        // Verifica si el usuario está autenticado
        if (!session()->get('user')) {
            return redirect()->to(base_url('login')); // Redirige al login si no está autenticado
        }
    }*/

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if($arguments[0] == 'admin'){
            if ($session->get('admin') == 0) {
                return redirect()->to(base_url('/'))->with('error', 'Acceso denegado');
            }
        }
        
        if($arguments[0] == 'user'){
            if (!$session->get('user')) {
                return redirect()->to(base_url('login')); // Redirige al login si no está autenticado
            }
        }

        

        // Verifica si el usuario está autenticado
        /*if (!$session->get('user')) {
            return redirect()->to(base_url('login')); // Redirige al login si no está autenticado
        }*/

        // Verifica si la ruta requiere acceso de administrador
        /*if (isset($arguments) && in_array('admin', $arguments)) {
            if (!$session->get('admin')) {
                return redirect()->to(base_url('/'))->with('error', 'Acceso denegado');
            }
        }*/
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No es necesario implementar esta función en este caso
    }
}
