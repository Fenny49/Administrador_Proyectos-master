<?php

namespace App\Models;

use CodeIgniter\Model;

class CatalogModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // Llama al SP para obtener todos los registros (Este nombre está bien, no hay conflicto)
    public function getAll(string $sp_name)
    {
        $query = $this->db->query("EXEC $sp_name");
        return $query->getResultArray();
    }

    // RENOMBRADO: de 'create' a 'createEntry'
    public function createEntry(string $sp_name, string $name)
    {
        $query = "EXEC $sp_name ?";
        return $this->db->query($query, [$name]);
    }

    // RENOMBRADO: de 'update' a 'updateEntry'
    public function updateEntry(string $sp_name, int $id, string $name)
    {
        $query = "EXEC $sp_name ?, ?";
        return $this->db->query($query, [$id, $name]);
    }

    // RENOMBRADO: de 'delete' a 'deleteEntry'
    public function deleteEntry(string $sp_name, int $id)
    {
        $query = "EXEC $sp_name ?";
        return $this->db->query($query, [$id]);
    }
}