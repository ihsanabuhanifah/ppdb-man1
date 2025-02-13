<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\{
    User,
    bukti,
    TesDiniyyah,
    TesMasuk,
    calonSiswa,
    WaControllers
};
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{
    UsersExport,
    TugasPakNurExport
};
use App\Imports\UsersImport;
use Validator;
use Auth;
use Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->page;
        $rolesss = [$request->role];
        $users = User::whereHas('roles', function($q) use ($rolesss){
                    $q->whereIn('name', $rolesss);
                 });
        if ($request->keywords) {
            $users = $users->where('name','like', "%".strtolower($request->keywords)."%")
            ->orWhere('email','like', "%".strtolower($request->keywords)."%");
        }

        if ($request->tahun_ajar) {
            $users = $users->where('tahun_ajar', $request->tahun_ajar);
        }

        $users = $users->orderBy("created_at", 'desc')
                ->with('roles')

                ->paginate($request->perpage, ['users.*']);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'role' => $request->role,
            'message' => 'sukses menampilkan data',
            'data' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // --------------- Sudah ada di register ---------------------
        // $users = $request->validate([
        //     'name' => 'required',
        //     'email' => 'required',
        //     'password' => 'required',
        //     'role' => 'required',
        //     'status' => 'required'
        // ]);

        // if(ManagemenUser::create($users)){
        //     return response()->json([
        //         "status" => "success",
        //         "message" => 'Berhasil Menyimpan Data'
        //     ]);
        // }else{
        //     return response()->json([
        //         "status" => "failed",
        //         "message" => 'Gagal Menyimpan Data'
        //     ]);
        // }

    }
    /*
     * @param  \App\Models\Managemen  $managemen
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $users
        ]);
    }


    public function detail()
    {

        $users = User::where('id', Auth::user()->id)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $users
        ]);
    }


    public function detailByAdmin($id)
    {

        $users = User::where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $users
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Managemen  $managemen
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::where('id', $id)->first();

        return response()-> json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Managemen  $managemen
     * @return \Illuminate\Http\Response
     */

     public function updateProfile(Request $request)
     {
        $user = User::where('id', Auth::user()->id)->first();

$user->update([
    'name' => $request->name,
    'email' => $request->email,
    'phone' => $request->phone,


    // Data Pribadi
    'jenis_kelamin' => $request->jenis_kelamin,
    'jalur_seleksi' => $request->jalur_seleksi,
    'nisn' => $request->nisn,
    'nik' => $request->nik,
    'tempat_lahir' => $request->tempat_lahir,
    'tanggal_lahir' => $request->tanggal_lahir,
    'agama' => $request->agama,
    'anak_ke' => $request->anak_ke,
    'jumlah_saudara_kandung' => $request->jumlah_saudara_kandung,
    'asal_sekolah' => $request->asal_sekolah,
    'jenis_sekolah' => $request->jenis_sekolah,
    'hobi' => $request->hobi,
    'cita_cita' => $request->cita_cita,

    // Alamat
    'alamat' => $request->alamat,
    'rt' => $request->rt,
    'rw' => $request->rw,
    'desa' => $request->desa,
    'kecamatan' => $request->kecamatan,
    'kodepos' => $request->kodepos,
    'tempat_tinggal' => $request->tempat_tinggal,
    'transportasi' => $request->transportasi,

    // Data Orang Tua
    'nomor_kk' => $request->nomor_kk,
    'nama_ayah' => $request->nama_ayah,
    'tempat_lahir_ayah' => $request->tempat_lahir_ayah,
    'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah,
    'nik_ayah' => $request->nik_ayah,
    'pendidikan_ayah' => $request->pendidikan_ayah,
    'pekerjaan_ayah' => $request->pekerjaan_ayah,
    'penghasilan_ayah' => $request->penghasilan_ayah,
    'nomor_ayah' => $request->nomor_ayah,

    'kab_kota' => $request->kab_kota,
    'provinsi'=> $request->provinsi,

    'nama_ibu' => $request->nama_ibu,
    'tempat_lahir_ibu' => $request->tempat_lahir_ibu,
    'tanggal_lahir_ibu' => $request->tanggal_lahir_ibu,
    'nik_ibu' => $request->nik_ibu,
    'pendidikan_ibu' => $request->pendidikan_ibu,
    'pekerjaan_ibu' => $request->pekerjaan_ibu,
    'penghasilan_ibu' => $request->penghasilan_ibu,
    'nomor_ibu' => $request->nomor_ibu,

    // Data Wali
    'nama_wali' => $request->nama_wali,
    'tahun_lahir_wali' => $request->tahun_lahir_wali,
    'nik_wali' => $request->nik_wali,
    'pendidikan_wali' => $request->pendidikan_wali,
    'pekerjaan_wali' => $request->pekerjaan_wali,
    'penghasilan_wali' => $request->penghasilan_wali,
    'nomor_wali' => $request->nomor_wali,

    // Kartu Identitas
    'nomor_kks' => $request->nomor_kks,
    'nomor_pkh' => $request->nomor_pkh,
    'nomor_kip' => $request->nomor_kip,
    'foto_profile' => $request->foto_profile ?? $user->foto_profile,
    'foto_kks' => $request->foto_kks ?? $user->foto_kks,
    'foto_pkh' => $request->foto_pkh ?? $user->foto_pkh,
    'foto_kip' => $request->foto_kip ?? $user->foto_kip,

    // prestasi

    'nama_prestasi1' => $request->nama_prestasi1,
    'nama_prestasi2' => $request->nama_prestasi2,
    'nama_prestasi3' => $request->nama_prestasi3,

    'juara_ke_1' => $request->juara_ke_1,
    'juara_ke_2' => $request->juara_ke_2,
    'juara_ke_3' => $request->juara_ke_3,
    'tingkat1' => $request->tingkat1,
    'tingkat2' => $request->tingkat2,
    'tingkat3' => $request->tingkat3,
]);

return response()->json([
    "status" => "success",
    "message" => 'Berhasil Menyimpan Data'
]);


         if($users->save()){
             return response()->json([
                 "status" => "success",
                 "message" => 'Berhasil Menyimpan Data'
             ]);
         }else{
             return response()->json([
                 "status" => "failed",
                 "message" => 'Gagal Menyimpan Data'
             ]);
         }
     }


    public function update(Request $request, $id)
    {
        $users = User::where('id', $id)->first();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        $users->password = bcrypt($request->password);
        if($users->save()){
            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data'
            ]);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => 'Gagal Menyimpan Data'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Managemen  $managemen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            for($i = 0 ; $i < count($request->id) ; $i++){
             $delete = User::find($request->id[$i]);
             $delete -> delete();
            }
            return response()->json([
             "status" => "success",
             "message" => 'Berhasil Menyimpan Status'
         ]);
         } catch (\Throwable $th) {
             //throw $th;
             return response()->json([
                 "status" => "faild",
                 "message" => 'id tidak ditemukan'
             ]);
         }

    }

    public function export()
    {
        return Excel::download(new UsersExport, 'user-export-' . date("Y-m-d") . '.xlsx');
    }

    public function import(Request $request)
    {
        $data = Excel::import(new UsersImport, $request->file('file')->store('temp'));

        if($data){
            return response()->json([
                'message'   => 'Success',
            ], 200);
        }else{
            return response()->json([
                'message'   => 'Gagal',
            ], 200);
        }
    }

    public function delete(Request $request)
    {

        // return $request->id[1];
        try {
           for($i = 0 ; $i < count($request->id) ; $i++){
            $delete = User::find($request->id[$i]);
            $delete -> delete();
           }
           return response()->json([
            "status" => "success",
            "message" => 'Berhasil Menyimpan Status'
        ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status" => "faild",
                "message" => 'id tidak ditemukan | ' . $th
            ]);
        }

        $users = User::where('id', $request->id)->first();
        $users->status = '1';
        if($users->save()){
            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Status'
            ]);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => 'Gagal Mengubah status'
            ]);
        }
    }

    public function updateStatus($id)
    {
        $bukti = bukti::where('user_id', $id)->first();
        $uploader = User::where('id' ,  Auth::user()->id)->first();
        if ($bukti->status == 0 || $bukti->status == false) {
            $bukti->status = 1;
            $bukti->approved_by = $uploader->name;

            if($bukti->save()){
                $user = User::where('id',$id)->with('tesDiniyyah')->first();
                $siswa = calonSiswa::where('user_id',$id)->first();
                $details = [
                    'nominal' => $bukti->nominal,
                    'name' => $siswa->name_siswa,
                    'materi'  => "Matematika, Diniyyah, Logika"
                ];

                // \Mail::to($user->email)->send(new \App\Mail\konf_pembayaran($details));
                // \Mail::to($user->email)->send(new \App\Mail\konfirmasi($details));

                $wa = new WaControllers();
                $message = "*Chat Otomatis PPDB SMK MQ (Jangan Dibalas)*

بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم
Alhamdulillah Wa Sholatu wa salamu a'la Rasulillah Ama ba'ad

Jazakumullahu Khairan kami telah menerima pembayaran untuk biaya pendaftaran
Untuk tahap selanjutnya nya silahkan mengerjakan *Tes Umum secara online* dan jadwalkan hari untuk *Tes Membaca Alquran serta wawancara*.
Adapun tes membaca Alquran bisa memilih online atau bisa datang langsung ke SMK MADINATULQURAN.
Untuk yang memilih tes online bisa menjadwalkan tesnya di hari *Sabtu atau Ahad* & untuk yang memilih datang langsung bisa memilih jadwal tesnya di hari *Ahad*
Adapun waktu/jam nya akan kami informasikan.

Jika ada pertanyaan hubungi CS kami
082113165990 (Ustadz Raihan)
0895320050324 (Ustadz Ihsan)

Barakallahu fiikum
Hormat kami,


Panitia PPDB SMK MADINATULQURAN";

                if ($wa->wablas($user->phone,$message, false)) {
                    return response()->json([
                        "status" => "Success",
                        "message" => "Berhasil Mengkonfirmasi Pembayaran"
                    ]);
                }else{
                    return response()->json([
                        "status" => "failed",
                        "message" => "Gagal Mengkonfirmasi Pembayaran"
                    ]);
                }
            }else{
                return response()->json([
                    "status" => "failed",
                    "message" => 'Gagal Merubah Status'
                ]);
            }
        }
        return response()->json([
            "status" => "success",
            "message" => 'Data Sudah Terubah'
        ]);
    }

    public function getJadwal(Request $request)
    {
        $request->keywords;
        $request->page;
        if($request->sort){
            $sort = $request->sort;
            // echo $sort;
        }else{
            $sort = "desc";
        }
        $array = ["user"];
        $users = User::where('name', 'like', '%'.strtolower($request->keywords)."%")
                 ->with('roles')
                 ->whereHas('roles', function($q) use ($array){
                     $q->whereIn('name', $array);
                 })
                 ->with('calonSiswa')
                 ->with(['tesDiniyyah' => function($query) use ($sort){
                    $query->orderBy('tanggal', $sort);
                 }])
                 ->paginate($request->perpage, [
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.phone',
                    'users.created_at'
                ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $users
        ]);
    }

    public function getListNilai(Request $request)
    {
        $request->keywords;
        $request->page;
        $array = ["user"];

        $users = User::where('name', 'like', '%'.strtolower($request->keywords)."%")
                 ->with('roles')
                 ->whereHas('roles', function($q) use ($array){
                     $q->whereIn('name', $array);
                 })
                 ->with('calonSiswa')
                 ->with('TesMasuk')
                 ->paginate($request->perpage, [
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.phone',
                    'users.created_at'
                ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $users
        ]);
    }

    public function getSingleListNilai()
    {
        $users = User::where('id', Auth::user()->id)
                 ->with('calonSiswa')
                 ->with('TesMasuk')
                 ->first();

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $users
        ]);
    }

    public function getKelulusan(Request $request)
    {
        $request->keywords;
        $request->page;
        $rolesss = ["user"];
        $jadwal = $request->jadwal;
        $users = Bukti::leftJoin('users','bukti.user_id','=','users.id')
                    ->leftJoin('calon_siswa', 'bukti.user_id','=','calon_siswa.user_id')
                    ->leftJoin('pendidikan_sebelumnya', 'bukti.user_id', '=' , 'pendidikan_sebelumnya.user_id')
                    ->with('User')
                    // ->where('bukti.nominal', "=" , 350000)
                    ->Where('bukti.nominal', "<" , 450001);
        if ($request->tahun_ajar) {
            $users = $users->whereHas('user', function($q) use ($request){
                $q->where('tahun_ajar', $request->tahun_ajar);
             });
        }
        $users = $users->get();

        $tes = TesDiniyyah::get();
        $tesMasuk = TesMasuk::get();
        //
        foreach ($tes as $key2) {
            foreach ($users as $key) {
                if ($key->user_id == $key2->user_id) {
                    $key['tes_diniyyah'] = $key2;
                    break;
                }
            }
        }
        foreach ($tesMasuk as $key2) {
            foreach ($users as $key) {
                if ($key->user_id == $key2->user_id) {
                    $hasilTes = TesMasuk::where('user_id' , "=" , $key2->user_id)->get();
                    $key['tes_umum'] = $hasilTes;
                    break;
                }
            }
        }



        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'role' => $request->role,
            'message' => 'sukses menampilkan data',
            'data' => $users,
            // 'tes' => $tes
        ]);
    }

    public function getAll(Request $request)
    {
        if($request->user_id){
            $data = User::where('id',$request->user_id)
                    ->with('calonSiswa')
                    ->with('pendidikanSebelumnya')
                    ->with('dataAyah')
                    ->with('dataIbu')
                    ->with('dataWali')
                    ->with('prestasiBelajar')
                    ->with('prestasiSmp')
                    ->first();
        }else{
            $data = User::with('calonSiswa')
                    ->with('pendidikanSebelumnya')
                    ->with('dataAyah')
                    ->with('dataIbu')
                    ->with('dataWali')
                    ->with('prestasiBelajar')
                    ->with('prestasiSmp')
                    ->get();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $data
        ]);
    }

    public function device(Request $request, $id){

        $user = User::find($id);
        $user->device = $request->token;
        $user->save();

        return $request->token;
    }

    // Tugas Kuliah pak nur
    public function TugasKuliah()
    {
        return Excel::download(new TugasPakNurExport, "tugas_pak_nur.xlsx");
    }

    public function resetPassword($email)
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            $randomToken = Str::random(50);
            $user->token_reset = $randomToken;
            $user->save();
            $details = [
                "id" => $user->id,
                "randomToken" => $randomToken
            ];
            try {
                \Mail::to($user->email)->send(new \App\Mail\resetPassword($details));
                return response()->json([
                    "status" => "Success",
                    "message" => 'Berhasil Mengirim Email Reset Password'
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    "status" => "Failed",
                    "message" => 'Gagal Mengirim Email'
                ]);
            }

        } else {
            return response()->json([
                "status" => "Failed",
                "message" => 'Data Tidak Ditemukan'
            ]);
        }
    }

    public function changepassword($id, $token_reset, Request $request)
    {
        $user = User::where('id', $id)->where('token_reset', $token_reset)->first();

        if ($user) {
            if ($request->password) {
                $user->password = bcrypt($request->password);
                $user->token_reset = null;
            } else {
                $user->password = bcrypt("12345678");
                $user->token_reset = null;
            }

            if($user->save()){
                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Merubah Password'
                ]);
            }else{
                return response()->json([
                    "status" => "failed",
                    "message" => 'Gagal Menyimpan Data'
                ]);
            }
        }else{
            return response()->json([
                "status" => "failed",
                "message" => 'Data Tidak Ditemukan'
            ]);
        }
    }

    public function updateTahun()
    {
        try {
            $rolesss = ["user"];
            $users = User::whereHas('roles', function($q) use ($rolesss){
                $q->whereIn('name', $rolesss);
            })->update(['tahun_ajar' => "2025-2026"]);

            return response()->json([
                "status" => "success",
                "message" => 'Tahun Ajar Update'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "failed",
                "message" => 'Gagal update tahun ajaran'
            ]);
        }
    }

    public function updateBatal($id, Request $request)
    {
        $user = User::where('id', $id)->first();

        if ($user) {
            $user->is_batal = $request->is_batal;
            if($user->save()){
                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Merubah Is Batal'
                ]);
            }else{
                return response()->json([
                    "status" => "failed",
                    "message" => 'Gagal Menyimpan Data'
                ]);
            }
        }else{
            return response()->json([
                "status" => "failed",
                "message" => 'Data Tidak Ditemukan'
            ]);
        }
    }

    public function getSudahBayar(Request $request)
    {
        $request->page;
        $rolesss = [$request->role];
        $nominal = 450000;
        $users = User::whereHas('roles', function($q) use ($rolesss){
                    $q->whereIn('name', $rolesss);
                 });
        if ($request->keywords) {
            $users = $users->where('name','like', "%".strtolower($request->keywords)."%")
            ->orWhere('email','like', "%".strtolower($request->keywords)."%");
        }

        if ($request->tahun_ajar) {
            $users = $users->where('tahun_ajar', $request->tahun_ajar);
        }

        $users = $users->whereHas('bukti', function($n) use ($nominal){
            $n->where('nominal', '>=', $nominal);
        });

        $users = $users->orderBy("created_at", 'desc')
                ->with('roles')
                ->with('bukti')
                ->with('tesDiniyyah')
                ->paginate($request->perpage, [
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.device',
                    'users.phone',
                    'users.tahun_ajar',
                    'users.is_batal',
                    'users.created_at'
                ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'role' => $request->role,
            'message' => 'sukses menampilkan data',
            'data' => $users
        ]);
    }




    public function jumlahPendaftaran()
{
    $jenisSekolahList = ['SMP', 'MTs', 'PKBM', 'PDF Wustha', 'PPS SPQ'];

    $jumlahPendaftaran = User::select('jenis_sekolah', DB::raw('count(*) as total'))
        ->whereNotNull('jenis_sekolah')
        ->whereIn('jenis_sekolah', $jenisSekolahList)
        ->groupBy('jenis_sekolah')
        ->pluck('total', 'jenis_sekolah')
        ->toArray();

    // Menetapkan nilai default 0 untuk jenis sekolah yang tidak ada di database
    $hasil = [];
    $totalKeseluruhan = 0;

    foreach ($jenisSekolahList as $jenis) {
        $jumlah = $jumlahPendaftaran[$jenis] ?? 0;
        $hasil[$jenis] = $jumlah;
        $totalKeseluruhan += $jumlah;
    }

    // Menambahkan total keseluruhan
    $hasil['Total'] = $totalKeseluruhan;

    return response()->json([
        'status' => 'success',
        'data' => $hasil
    ]);
}

}
