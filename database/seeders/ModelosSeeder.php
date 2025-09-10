<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modelos = [
            "MAGNER 165",
            "SC 303",
            "SC 360",
            "MAGNER 2000",
            "KISAN K5-A",
            "NEWTON III",
            "MAGNER 915",
            "CIMA 7016",
            "MAGNER 175",
            "SC CDS9",
            "HYUNDAI SB9",
            "KDL-100",
            "CUMMINS MM2",
            "SC 820J",
            "DTC 1",
            "MAGNER VC525",
            "NEWTON 30",
            "CUMMINS LX",
            "DTC 9",
            "KISAN K6",
            "G&D PRONOTE 1.5",
            "CDM 25",
            "CDM 15",
            "KD-100",
            "DTC 6",
            "LAC 17",
            "PELICAN 301",
            "SC 313",
            "SC 3003",
            "PELICAN 309",
            "KISAN K5",
            "KISAN K3",
            "SCAN COIN ICX ACTIVE 9",
            "ELEVADOR DE MONEDAS",
            "ELEVADOR DISTRIBUIDOR DE MONEDA",
            "INTEROLL KSVDW23TO1",
            "BALANZA ETIQUETADORA",
            "SISTEMA DE DISTRIBUCION",
            "F.T.CAJAS.",
            "REIS CW-2015",
            "CUMMINS 4391",
            "CUMMINS IFX236",
            "KISAN KD10",
            "PROFIPACK C400",
            "PROFIPACK P425",
            "NO APLICA",
            "MAGNER 125",
            "HYUNDAI MIB-11V",
            "HSM PROFIPACK",
            "KISAN KD20",
            "MAGNER 152",
            "HSM-DESTRUCTORA DE SOPORTE",
            "KISAN K3-A",
        ];

        $data = [];

        foreach ($modelos as $descripcion) {
            $data[] = ['descripcion' => $descripcion];
        }

        DB::table('modelos')->insert($data);
    }
}
