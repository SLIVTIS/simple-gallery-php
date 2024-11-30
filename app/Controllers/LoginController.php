<?php

namespace App\Controllers;
use App\Models\UserModel;

class LoginController extends BaseController{
    public function index(){
        return view('login');
    }

    public function login(){

        if ($this->request->getMethod() === 'POST' && $this->validate([
            'email' => 'required|valid_email',  // Se asegura de que sea un email válido
            'pass'  => 'required',
        ])) {
            $model = new UserModel();
            $pass = $this->request->getPost('pass');
            $user = $model->login([
                'email' => $this->request->getPost('email')
            ]);
        
            if (isset($user)) {
                // Verificar la contraseña
                if (password_verify($pass, $user['pass'])) {
                    session()->set(['user' => $user['id'], 'name' => $user['name'], 'admin' => $user['admin']]);
                    return redirect()->to(base_url());
                } else {
                    session()->setFlashdata('login_error', 'Los datos ingresados no son correctos');
                }
            } else {
                //Guarda el mensaje de error en la session
                session()->setFlashdata('login_error', 'Los datos ingresados no son correctos');
            }
        }
        return redirect()->to(base_url('login'));
    }

    public function logout() {
        session()->destroy();
        return redirect()->to(base_url());
    }

}