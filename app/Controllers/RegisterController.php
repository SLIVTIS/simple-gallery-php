<?php

namespace App\Controllers;
use App\Models\UserModel;

class RegisterController extends BaseController{
    public function index(){
        return view('register');
    }

    public function register(){

        if ($this->request->getMethod() === 'POST' && $this->validate([
            'name' => 'required',
            'email' => 'required|valid_email',  // Se asegura de que sea un email válido
            'pass'  => 'required',
        ])) {
            $model = new UserModel();
            $user = $model->insert([
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'pass' => password_hash($this->request->getPost('pass'), PASSWORD_DEFAULT),
                'admin' => false
            ]);
        
            if (isset($user)) {
                //Usuario creado correctamente
                return redirect()->to(base_url());
            } 
        }
        return redirect()->to(base_url('register'));
    }
}