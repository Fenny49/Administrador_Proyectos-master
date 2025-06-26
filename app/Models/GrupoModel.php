<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoModel extends Model
{
    protected $table            = 'GRUPOS';
    protected $primaryKey       = 'GPO_ID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['GPO_NOM', 'GPO_DESC'];
}