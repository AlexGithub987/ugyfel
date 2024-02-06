<?php

namespace AlexGithub987\Ugyfel;

use AlexGithub987\Ugyfel\Models\Companies;
use AlexGithub987\Ugyfel\Models\Ugyfel as ModelsUgyfel;
use AlexGithub987\Ugyfel\Models\Ugyfel_cim as ModelsUgyfel_cim;
use AlexGithub987\Ugyfel\Models\Ugyfel_kapcsolat as ModlesUgyfel_kapcsolat;

class Ugyfel
{
    // Build wonderful things
    public function hello()
    {
        return 'Hello, World!';
    } 
    
    public function index($request) {

        if ( $request['adoszam'] ) {       
            $ugyfel_tipus = 'JOGISZEMELY';    
        } else {
            $ugyfel_tipus = 'MAGANSZEMELY';
        }

        $company_id = Companies::select('*')->first()['id'];

        // ügyflél keresés típus szerint
        if ($ugyfel_tipus == 'JOGISZEMELY') {
            if (!isset($request['ceg']) or !isset($request['adoszam'])) {
                return ["message" => "hiányzó paraméter(ek): cég vagy adószám"];
            }
            $ugyfel_dummy = ModelsUgyfel::getUgyfelDataForCheckAdo($request);

        } else {
            if (!isset($request['nev']) or !isset($request['email'])) {
                return ["message" => "hiányzó paraméter(ek): email vagy név"];
            }
            $ugyfel_dummy = ModelsUgyfel::getUgyfelDataForCheck($request);
        }
 

        if (isset($ugyfel_dummy['ugyfelid'])) {
 
            $ugyfel             = ModelsUgyfel::select('*')->where('id', $ugyfel_dummy['ugyfelid'])->get()->toArray();
            $ugyfel_cim         = ModelsUgyfel_cim::select('*')->where('id', $ugyfel_dummy['ugyfelcimid'])->get()->toArray();
            $ugyfel_kapcsolat   = ModlesUgyfel_kapcsolat::select('*')->where('ugyfel_id', $ugyfel_dummy['ugyfelid'])->get()->toArray();

            return ["ugyfel" => $ugyfel, "ugyfel_cim" => $ugyfel_cim, "ugyfel_kapcsolat" => $ugyfel_kapcsolat];
        } else {
            // ugyfel letrehozás
            return self::create_ugyfel($request, $company_id, $ugyfel_tipus);
        }
        

    }

    
    private static function create_ugyfel($data, $company_id, $ugyfel_tipus)
    {

        $ugyfel_new = new ModelsUgyfel();
        $ugyfel_new->company_id     = $company_id;
        $ugyfel_new->ugyfel_tipus   = $ugyfel_tipus;
        $ugyfel_new->nev            = ($ugyfel_tipus == 'JOGISZEMELY') ? $data['ceg'] : $data['nev'];
        $ugyfel_new->email          = $data['email'];
        $ugyfel_new->telefon        = isset($data['telefon']) ? $data['telefon'] : '';
        $ugyfel_new->adoszam        = isset($data['adoszam']) ? $data['adoszam'] : '';
        $ugyfel_new->nyelv          = 'HU';
        $ugyfel_new->ugyfel_mod     = '1';
        $ugyfel_new->status         = '1';
        $ugyfel_new->save();

        $ugyfel = ModelsUgyfel::where('id', $ugyfel_new->id)->first();

        if (isset($data['adoszam'])) {

            // if ($data['adoszam'] != '' and strlen($data['adoszam']) != 13 and !preg_match('/^[0-9_-]*$/', $data['adoszam'])) {

            //     $dummy = [
            //         'summary'       => 'Hiba az ügyfél azonosításban (ConnectivityAPI)',
            //         'description'   => '*Tenant: ' . $tenant->id .'*  - Hibás adószám: ' . $data['adoszam'] . ', Ügyfél ID: ' . $ugyfel_new->id,
            //         'table'         => 'ugyfel',
            //         'table_row'     => $ugyfel_new->id
            //     ];
            //     jiraTask::createIssue($dummy);
            // }
        }      
        
        if (isset($data['egyszeru_cim'])) {
            $kozterulet = $data['egyszeru_cim'];
            $find_string = $data['egyszeru_cim'];
        } else {
            $kozterulet = $data['kozterulet'];
            $find_string = $data['irsz'].' '.$data['varos'].' '.$data['kozterulet'].' '.$data['kozterulet_jelleg'].' '.$data['hsz'];
        } 
                
        $ugyfel_cim_new = new ModelsUgyfel_cim();
        $ugyfel_cim_new->ugyfel_id          = $ugyfel['id'];
        $ugyfel_cim_new->irsz               = isset($data['egyszeru_cim']) ? NULL : $data['irsz'];
        $ugyfel_cim_new->varos              = isset($data['egyszeru_cim']) ? NULL : $data['varos'];
        $ugyfel_cim_new->kozterulet         = $kozterulet;
        $ugyfel_cim_new->kozterulet_jelleg  = isset($data['egyszeru_cim']) ? NULL : $data['kozterulet_jelleg'];
        $ugyfel_cim_new->hsz                = isset($data['egyszeru_cim']) ? NULL : $data['hsz'];
        $ugyfel_cim_new->find_string        = $find_string;
        $ugyfel_cim_new->cim_type           = 'SZEKHELY';
        $ugyfel_cim_new->sorszam            = 1;
        $ugyfel_cim_new->save();

        $ugyfel_cim = ModelsUgyfel_cim::where('id', $ugyfel_cim_new->id)->first()->toArray();


        $ugyfel_kapcsolat_new = new ModlesUgyfel_kapcsolat();
        $ugyfel_kapcsolat_new->ugyfel_id    = $ugyfel['id'];
        $ugyfel_kapcsolat_new->nev          = $data['nev'];
        $ugyfel_kapcsolat_new->telefon      = isset($data['telefon']) ? $data['telefon'] : '';
        $ugyfel_kapcsolat_new->email        = $data['email'];
        $ugyfel_kapcsolat_new->save();

        $ugyfel_kapcsolat = ModlesUgyfel_kapcsolat::where('id', $ugyfel_kapcsolat_new->id)->first()->toArray();


        return ["ugyfel" => [$ugyfel], "ugyfel_cim" => [$ugyfel_cim], "ugyfel_kapcsolat" => [$ugyfel_kapcsolat]];
    }


}