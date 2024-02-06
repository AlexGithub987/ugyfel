<?php

namespace AlexGithub987\Ugyfel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Ugyfel extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'ugyfel';

    protected $guarded = ['id'];


    public static function getUgyfelDataForCheck($data)
    {

        if (isset($data['egyszeru_cim']) and isset($data['egyszeru_cim']) != '') {
            $return = self::select('ugyfel.id as ugyfelid', 'ugyfel_cim.id as ugyfelcimid')
                ->join('ugyfel_cim', 'ugyfel_cim.ugyfel_id', '=', 'ugyfel.id')
                ->where('nev',trim($data['nev']))
                ->where('email',trim($data['email']))
                ->where('ugyfel_tipus','MAGANSZEMELY')
                ->where('cim_type','SZEKHELY')
                ->where('find_string',$data['egyszeru_cim'])
                ->get()->toArray();
        } else {
            $return = self::select('ugyfel.id as ugyfelid', 'ugyfel_cim.id as ugyfelcimid')
                ->join('ugyfel_cim', 'ugyfel_cim.ugyfel_id', '=', 'ugyfel.id')
                ->where('nev',trim($data['nev']))
                ->where('email',trim($data['email']))
                ->where('ugyfel_tipus','MAGANSZEMELY')
                ->where('cim_type','SZEKHELY')
                ->where('irsz',$data['irsz'])
                ->where('varos',$data['varos'])
                ->where('kozterulet',$data['kozterulet'])
                ->where('kozterulet_jelleg',$data['kozterulet_jelleg'])
                ->where('hsz',$data['hsz'])
                ->get()->toArray();
        }
 

        if ($return) {
            return $return[0];
        } else {
            return;
        }
        
    }

    public static function getUgyfelDataForCheckAdo($data)
    {
        $return = self::select('ugyfel.id as ugyfelid', 'ugyfel_cim.id as ugyfelcimid')
                    ->leftJoin('ugyfel_cim', 'ugyfel_cim.ugyfel_id', '=', 'ugyfel.id')
                    ->where('adoszam',$data['adoszam'])
                    ->where('ugyfel_tipus','JOGISZEMELY')
                    ->get()->toArray();
        if ($return) {
            return $return[0];
        } else {
            return;
        }
        
    }


}
