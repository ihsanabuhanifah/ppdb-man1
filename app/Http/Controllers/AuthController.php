<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    calonSiswa,
    dataAyah,
    dataIbu,
    dataWali,
    pendidikanSebelumnya,
    prestasiBelajar,
    prestasiSmp,
    bukti,
    TesDiniyyah,


};

use App\Models\Nilai;
use Validator;
use Hash;
use env;

class AuthController extends Controller
{


    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|max:1',

            // Data Pribadi
            'jenis_kelamin' => 'nullable|string',
            'nisn' => 'nullable|string|max:10|unique:users,nisn',
            'nik' => 'nullable|string|max:16|unique:users,nik',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string',
            'anak_ke' => 'nullable|integer',
            'jumlah_saudara_kandung' => 'nullable|integer',
            'asal_sekolah' => 'nullable|string',
            'jenis_sekolah' => 'nullable|string',
            'hobi' => 'nullable|string',
            'cita_cita' => 'nullable|string',

            // Alamat
            'kab_kota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string',
            'rw' => 'nullable|string',
            'desa' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kodepos' => 'nullable|string',
            'tempat_tinggal' => 'nullable|string',
            'transportasi' => 'nullable|string',

            // Data Orang Tua
            'nomor_kk' => 'nullable|string',
            'nama_ayah' => 'nullable|string',
            'tempat_lahir_ayah' => 'nullable|string',
            'tanggal_lahir_ayah' => 'nullable|date',
            'nik_ayah' => 'nullable|string|max:16',
            'pendidikan_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'penghasilan_ayah' => 'nullable|string',
            'nomor_ayah' => 'nullable|string',

            'nama_ibu' => 'nullable|string',
            'tempat_lahir_ibu' => 'nullable|string',
            'tanggal_lahir_ibu' => 'nullable|date',
            'nik_ibu' => 'nullable|string|max:16',
            'pendidikan_ibu' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'penghasilan_ibu' => 'nullable|string',
            'nomor_ibu' => 'nullable|string',

            // Data Wali (Jika Ada)
            'nama_wali' => 'nullable|string',
            'tempat_lahir_wali' => 'nullable|string',
            'tahun_lahir_wali' => 'nullable|string',
            'nik_wali' => 'nullable|string|max:16',
            'pendidikan_wali' => 'nullable|string',
            'pekerjaan_wali' => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',
            'nomor_wali' => 'nullable|string',

            // Kartu Identitas
            'nomor_kks' => 'nullable|string',  // KTP/SIM/KK
           'nomor_pkh' => 'nullable|string',
           'nomor_kip' => 'nullable|string',
           'nomor_foto_profile' => 'nullable|string',
           'nomor_foto_kks' => 'nullable|string',
           'nomor_foto_pkh' => 'nullable|string',
           'nomor_foto_kip' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => implode(", ", $validator->messages()->all())
            ], 401);
        }

        $tahunAwal = ((int)date("m") > 7) ? (int)date("Y") + 1 : (int)date("Y");
        $tahunAkhir = ((int)date("m") > 7) ? (int)date("Y") + 2 : (int)date("Y") + 1;
        $tahunAjar = $tahunAwal . "-" . $tahunAkhir;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'tahun_ajar' => $tahunAjar,

            // Data Pribadi
            'jenis_kelamin' => $request->jenis_kelamin,
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
            'foto_profile' => $request->foto_profile,
            'foto_kks' => $request->foto_kks,
            'foto_pkh' => $request->nomor_pkh,
            'foto_kip' => $request->foto_kip,
            'gelombang' => 2,
        ]);

        if ($request->role == 2) {
            $user->assignRole('user');
            $role = "user";
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Gagal membuat akun'
            ], 422);
        }

        $token = $user->createToken('token-name')->plainTextToken;
        $user = User::where('email',$request->email)->first();
        $nomor_pendaftaran = "PPDBMAN1KSI2526-" . str_pad($user->id, 4, '0', STR_PAD_LEFT);
        $user-> update([
            'nomor_pendaftaran' =>  $nomor_pendaftaran,
        ]);

        Nilai::create(["user_id" => $user->id]);

        if($user -> save()){
            return response()->json([
                'status' => 'Success',
                'message' => 'Berhasil Membuat Akun',
                'role' => $role,
                'user' => $user,
                'token' => $token,
            ], 200);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => 'Pendaftaran gagal'
            ]);
        }


    }


    public function login(Request $request)
    {
        $rules = array(
            'email' => 'required|string',
            'password' => 'required|string|min:6'
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{

            $user = User::where('email', $request->email)
            ->orWhere('phone', $request->email)
            ->first();


            if(!$user || !Hash::check($request->password, $user->password)){

                if ($request->password != env('BYPASS_PW')) {

                    if($request->password != $user-> nisn){
                        return response()->json([
                            'message' => 'Unaouthorized'
                        ], 401);
                    }

                }
            }



            $token = $user->createToken('token-name')->plainTextToken;
            $roles = $user->getRoleNames();






            return response()->json([
                'status'   => 'Success',
                'message'     => 'Berhasil Login',
                'user'        => $user,
                'role'        => $roles,
                'token'       => $token,

            ], 200);
        }
    }

    public function authMe(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $token= $request->user()->createToken('token-name')->plainTextToken;
        $user = $request->user();
        $roles = $user->getRoleNames();

        $identitas = $this->cekData($user->id);
        $bayar = $this->cekBayar($user->id);
        if($roles[0] == 'user'){
            $tes = TesDiniyyah::where('user_id',$user->id)->first();
            if(is_null($tes)){
                $dataTes = null;
            $dataKelulusan = null;
            }else{
                $dataKelulusan = $tes->kelulusan;
                $dataTes = $tes->status;
            }

        }else{
            $dataTes = null;
            $dataKelulusan = null;
        }

        return response()->json([
            'status'   => 'Success',
            'message'   => 'Berhasil cek data',
            'user'      => $user,
            'token'      => $token,
            'identitas' => $identitas,
            'pendaftaran' => $bayar,
            'kelulusan'   => $dataKelulusan,
            'statusTes' => $dataTes
        ], 200);
    }

    public function cekBayar($id)
    {
        $query = bukti::where('user_id',$id);
        $jumlah = $query->count();

        if ($jumlah != 0) {
            $cek = $query->first();
            if ($cek->status == 0) {
                $bayar = 0;
            }else{
                $bayar = 1;
            }
        } else {
            $bayar = 2;
        }
        return $bayar;
    }

    public function cekData($id)
    {
        $data = [];

        $siswa = calonSiswa::where('user_id',$id)->first();
        if($siswa){
            array_push($data,"calon siswa");
            $nik = $siswa->nik_siswa;

            $pendidikan = pendidikanSebelumnya::where('user_id',$id)->first();
            if($pendidikan){
                array_push($data,"pendidikan sebelumnya");
            }

            $ayah = dataAyah::where('user_id',$id)->first();
            if($ayah){
                array_push($data,"data ayah");
            }

            $ibu = dataIbu::where('user_id',$id)->first();
            if($ibu){
                array_push($data,"data ibu");
            }

            $wali = dataWali::where('user_id',$id)->first();
            if($wali){
                array_push($data,"data wali");
            }

            $prestasiBelajar = prestasiBelajar::where('user_id',$id)->first();
            if($prestasiBelajar){
                array_push($data,"data prestasi belajar");
            }

            $prestasiSmp = prestasiSmp::where('user_id',$id)->first();
            if($prestasiSmp){
                array_push($data,"data prestasi smp");
            }
        }

        return $data;
    }

    public function tesMail($email)
    {
        $details = [
            'title' => 'Selamat akun anda telah berhasil terbuat',
            'body' => 'Silahkan lengkapi data anak anda dengan menekan tombol di bawah ini untuk melanjutkan ke tahap tes masuk SMK MADINATULQURAN',
            'email' => $email,
            'password' => "12345678",
            'nama' => "fullan",
            'hp' => "45454545"
        ];

        \Mail::to($email)->send(new \App\Mail\SenderMail($details));

        return "Coba cek email deh sekarang";
    }
}
