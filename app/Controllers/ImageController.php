<?php

namespace App\Controllers;

use App\Models\ImageModel;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

//class ImageController extends ResourceController
class ImageController extends BaseController
{
    //protected $imageModel = 'App\Models\ImageModel';
    protected $format = 'json';

    protected $imageModel;

    public function __construct()
    {
        // Inicializamos el modelo
        $this->imageModel = new ImageModel();
    }

    /**
     * Lista todas las imágenes.
     * @return mixed
     */
    public function index()
    {
        return $this->showGallery($this->currentUser['id'], false);
    }

    public function viewGallery($id = null)
    {
        // Llamar al método `showGallery` con el ID y el valor adicional
        return $this->showGallery($id, true);
    }

    public function showGallery($id = null, $isGalleryRoute)
    {
        $this->isAuthenticated();

        // Obtiene todas las imágenes de la base de datos
        $images = $this->imageModel->getImagesByOwner($id);
        $userModel = new UserModel();
        $user = $userModel->find($id);
        $panel = null;

        // Carga la vista 'gallery_view' con los datos de las imágenes
        if($this->currentUser['admin'] == 1){
            $isGalleryRoute ? $panel = view('includes/panel', ['nameGallery' => $user['name']]) : $panel = view('includes/panel');
        }else{
            $panel = view('includes/header');
        }
        $gallery = view('gallery_view', ['images' => $images]);
        $footer = view('includes/footer');
     
        return $panel . $gallery . $footer;
    }


    /**
     * Sube una imagen y la registra en la base de datos.
     * @return mixed
     */
    public function create()
    {
        $userId = session()->get('user');
        $file = $this->request->getFile('image'); // Campo 'image' en el formulario
    
        if (!$file || !$file->isValid()) {
            return $this->fail('Error al subir el archivo.');
        }

        // Validar el archivo (opcional)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($file->getExtension(), $allowedExtensions)) {
            return $this->fail('Solo se permiten imágenes (jpg, jpeg, png, gif, webp).');
        }

        $fileName = $file->getName(); //Obtiene el nombre original

        // Generar un nombre único y mover el archivo
        $newName = $file->getRandomName(); // Nombre único para evitar colisiones
        $file->move(WRITEPATH . 'uploads', $newName); // Mover el archivo a 'writable/uploads'

        // Guardar solo el nombre del archivo en la base de datos
        $data = [
            'path' => $newName,
            'id_user' => $userId,
            'date_upload' => date('Y-m-d H:i:s'),
            'name' => $fileName
        ];

        // Insertar los datos en la base de datos
        if (!$this->imageModel->insert($data)) {
            return $this->fail($this->imageModel->errors());
        }
        return $this->response->setStatusCode(200)->setJSON(['message' => 'Imagen subida exitosamente.']);
        //return $this->respondCreated(['message' => 'Imagen subida exitosamente.', 'id' => $this->imageModel->getInsertID()]);
    }

    /**
     * Sirve una imagen desde la carpeta 'writable/uploads'.
     * @param string $fileName
     * @return mixed
     */
    public function serveImage($fileName)
    {
        $filePath = WRITEPATH . 'uploads/' . $fileName;

        // Verifica si el archivo existe
        if (!is_file($filePath)) {
            return $this->failNotFound("La imagen no se encontró.");
        }

        // Detecta el tipo MIME del archivo
        $mimeType = mime_content_type($filePath);

        // Configura la respuesta HTTP con el contenido de la imagen
        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setBody(file_get_contents($filePath));
    }

    /**
     * Elimina una imagen por ID.
     * @param int $id
     * @return mixed
     */
    public function delete($id = null)
    {
        $image = $this->imageModel->find($id);
        if (!$image) {
            return $this->failNotFound("No se encontró la imagen con ID: $id");
        }

        // Eliminar el archivo físico
        $filePath = WRITEPATH . 'uploads/' . $image['path'];
        if (is_file($filePath)) {
            unlink($filePath);
        }

        // Eliminar el registro de la base de datos
        if (!$this->imageModel->delete($id)) {
            return $this->response->setStatusCode(500)->setJSON(["Message" => "Error al eliminar la imagen."]);
        }

        return $this->response->setStatusCode(200);
    }

    public function deleteSelected(){
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
        if (!isset($data['ids']) || !is_array($data['ids'])) {
            return $this->response->setStatusCode(400)
                                  ->setJSON(['message' => 'No se proporcionaron IDs válidos']);
        }

        // Eliminar los IDs proporcionados
        foreach ($data['ids'] as $id) {
            if (!$this->imageModel->delete($id)) {
                // Responder en caso de error al eliminar
                return $this->response->setStatusCode(500)
                                      ->setJSON(['message' => "Error al eliminar el ID: $id"]);
            }
        }

        // Responder con éxito
        return $this->response->setStatusCode(200)
                              ->setJSON(['message' => 'Imágenes eliminadas correctamente']);
    }
}
