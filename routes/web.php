<?php

use App\Http\Controllers\Absensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   $result = DB::select("
            SELECT 
  mp.nip, 
  mp.nama, 
  mp.njab, 
  data_absen.tgl_kerja, 
  CASE when TIME_FORMAT(data_absen.masuk, '%H:%i') = '00:00' then null else TIME_FORMAT(data_absen.masuk, '%H:%i') end as masuk, 
  CASE when TIME_FORMAT(data_absen.pulang, '%H:%i') = '00:00' then null else TIME_FORMAT(data_absen.pulang, '%H:%i') end as pulang, 
  data_absen.hari, 
  data_absen.is_cuti, 
  case when data_absen.hari in (6, 7) then 0 when data_absen.hari in (1, 2, 3, 4, 5) 
  and data_absen.is_cuti >= 1 then 1 WHEN data_absen.terlambat IS NOT NULL THEN 2 WHEN data_absen.is_izin > 1 THEN 3 else 4 end as status 
FROM 
  m_pegawai mp 
  left join (
    SELECT 
      * 
    from 
      lap_absensi_202403 la 
    union 
    SELECT 
      * 
    from 
      lap_absensi_202404 la
  ) as data_absen on mp.nip = data_absen.nip 
WHERE 
  MONTH (data_absen.tgl_kerja) = 3 
order by 
  data_absen.tgl_kerja ASC;
            ");

            $data_kehadiran = [];

            foreach ($result as $dataItem) {
                $index = array_search($dataItem->nip, array_column($data_kehadiran, 'nip'));
                if(count($data_kehadiran) == 0 || $index == false && $data_kehadiran[$index]['nip'] != $dataItem->nip){
                    $data_kehadiran[] = [
                        'nip' => $dataItem->nip,
                        'nama' => $dataItem->nama,
                        'njab' => $dataItem->njab,
                        'absensi_kehadiran' => [
                            [
                                'tgl_kerja' => $dataItem->tgl_kerja,
                                'masuk' => $dataItem->masuk,
                                'pulang' => $dataItem->pulang,
                                'hari' => $dataItem->hari,
                                'status' => $dataItem->status,
                            ]
                        ]
                    ];
                }else {
                    array_push($data_kehadiran[$index]['absensi_kehadiran'], [
                                'tgl_kerja' => $dataItem->tgl_kerja,
                                'masuk' => $dataItem->masuk,
                                'pulang' => $dataItem->pulang,
                                'hari' => $dataItem->hari,
                                'status' => $dataItem->status,
                            ]);
                }

            }

    return view('welcome', ["dataEmps" => $data_kehadiran, "header" => $data_kehadiran[0]['absensi_kehadiran']]);
});
