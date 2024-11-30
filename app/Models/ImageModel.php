<?php
namespace App\Models;

use CodeIgniter\Model;

class ImageModel extends Model
{
    // Especifica la tabla y la clave primaria
    protected $table = 'Images';
    protected $primaryKey = 'id';

    // Define las columnas que pueden ser manipuladas
    protected $allowedFields = [
        'id_user',
        'path',  
        'date_upload',
        'name'
    ];

    /**
     * Obtiene imágenes con base en un ID específico o todas las imágenes
     * @param int|null $id
     * @return array
     */
    public function getImage($id = null)
    {
        return $id ? $this->find($id) : $this->findAll();
    }

    /**
     * Obtiene las imágenes asociadas a un propietario específico.
     * @param int $propietarioId
     * @param string|null $tipoPropietario
     * @return array
     */
    public function getImagesByOwner($propietarioId)
    {
        $query = $this->where('id_user', $propietarioId);
        
        return $query->findAll();
    }

    /**
     * Inserta una nueva imagen en la base de datos
     * @param array $data
     * @return bool|int
     */
    public function addImage(array $data)
    {
        return $this->insert($data);
    }

    /**
     * Actualiza una imagen existente
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateImage($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Elimina una imagen por ID
     * @param int $id
     * @return bool
     */
    public function deleteImage($id)
    {
        return $this->delete($id);
    }
}
