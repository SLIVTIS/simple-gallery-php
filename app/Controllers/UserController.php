<?php
namespace App\Controllers;
use App\Models\UserModel;

class UserController extends BaseController
{
    //Metodo principal para mostrar todos los usuarios disponibles
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->getUser();

        $panel = view('includes/panel');   
        $main = view('list', $data);
        $footer = view('includes/footer');
     
        return $panel . $main . $footer;
    }

    //Sirve la vista para añadir un usuario
    public function viewCreate()
    {
        //Información para la vista
        $data = [
            'title' => "Crear Usuario",
            'url' => base_url('admin/user/store')
        ];

        $panel = view('includes/panel');   
        $main = view('user_form', $data);
        $footer = view('includes/footer');
        return $panel . $main . $footer;
    }

    //Sirve la vista para editar un usuario
    public function viewEdit($id)
    {
        $model = new UserModel();
        $data = [
            'title' => "Actualizar Usuario",
            'url' => base_url('admin/user/update/' . $id),
            'user' => $model->getUser($id)
        ];
    
        $panel = view('includes/panel');   
        $main = view('user_form', $data);
        $footer = view('includes/footer');
        return $panel . $main . $footer;
    }

    public function viewChangePass($id){
        $model = new UserModel();
        $data = [
            'url' => base_url('admin/user/changepass/' . $id),
            'user' => $model->getUser($id)];
        
        $panel = view('includes/panel');   
        $main = view('change_pass', $data);
        $footer = view('includes/footer');
        return $panel . $main . $footer;       
    }

    //Guardar el usuario nuevo en la base de datos
    public function store(){
        $model = new UserModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'pass' => password_hash($this->request->getPost('pass'), PASSWORD_DEFAULT),
            'admin' => $this->request->getPost('admin') == null ? 0 : 1
        ];
        $model->insert($data);
        return redirect()->to(base_url('admin/user'));
    }

    //Actualizar los campos name y email del usuario
    public function update($id)
    {
        $model = new UserModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'admin' => $this->request->getPost('admin') == null ? 0 : 1
        ];
        $model->update($id, $data);
        return redirect()->to(base_url('admin/user'));
    }

    //Actualiza solo la contraseña del usuario
    public function updatePass($id){
        // Leer el contenido JSON enviado en la solicitud
        $json = file_get_contents('php://input');

        // Decodificar el JSON
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Responder con JSON inválido
            return $this->response->setStatusCode(400)
                                  ->setJSON(['message' => 'JSON inválido']);
        }

        // Validar si los IDs están presentes
        if (!isset($data['pass'])) {
            return $this->response->setStatusCode(400)
                                  ->setJSON(['message' => 'Hacen falta los datos de id o pass']);
        }
        $model = new UserModel();
        $model->update($id, ['pass'=> password_hash($data['pass'], PASSWORD_DEFAULT)]);

        return $this->response->setStatusCode(200)
            ->setJSON(['message' => 'Contraseña actualizada con éxito']);
    }

    //Elimina un solo usuario en base al id
    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);
        return redirect()->to(base_url('admin/user'));
    }
}

