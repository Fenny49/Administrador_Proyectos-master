<?php
// app/Models/EstatusModel.php
namespace App\Models;
use CodeIgniter\Model;

class EstatusModel extends Model
{
    protected $table = 'dbo.ESTATUS';
    protected $primaryKey = 'STAT_ID';
    protected $returnType = 'array';
    protected $allowedFields = ['STAT_NOM'];
}