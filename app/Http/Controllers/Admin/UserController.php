<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $akun = User::orderBy('id', 'desc')->get();
        return view('admin.user', compact('akun'));
    }

    public function edit($id)
    {
        $akun = User::where('id', $id)->first();
        return view('admin.user-edit', compact('akun'));
    }
    public function tambah()
    {
        return view('admin.tambah-akun');
    }
    public function store(Request $request)
    {

        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $datadokter = $request->validate([
            'hari_praktik' => 'required',
            'spesialis' => 'required',
            'jam_praktik' => 'required',
        ]);

        $datapasien = $request->validate([
            'jenis_kelamin' => 'required',
            'no_telp' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'berat_badan' => 'required',
            'tinggi_badan' => 'required',
        ]);

        if ($request->role == 'admin') {
            User::create($data);
            return redirect('admin/akun')
                ->with('success', 'Akun Admin Berhasil Ditambah');
        } elseif ($request->role == "dokter") {
            $dokter = User::create($data);

            $d = Dokter::create($datadokter);
            Dokter::where('id', $d->id)->update([
                'user_id' => $dokter->id
            ]);
            return redirect('admin/akun')
                ->with('success', 'Akun Dokter Berhasil Ditambah');
        } else {
            $pasien = User::create($data);

            $p = Pasien::create($datapasien);
            Dokter::where('id', $p->id)->update([
                'user_id' => $pasien->id
            ]);
            return redirect('admin/akun')
                ->with('success', 'Akun Pasien Berhasil Ditambah');
        }
    }

    public function edit_akun($id)
    {
        $akun = User::where('id', $id)->first();
        return view('admin.edit-akun', compact('akun'));
    }


    public function update_akun(Request $request, $id)
    {


        if ($request->password) {
            $data['password'] = bcrypt($request->password);
            // return $request;
        }

        User::findOrFail($id)->update($data);

        return redirect('admin/verifikasi_akun')
            ->with('success', 'Akun Berhasil Diperbaharui');
    }



    public function hapus($id)
    {

        User::destroy($id);
        return redirect('admin/verifikasi_akun')
            ->with('success', 'Akun Berhasil Dihapus');
    }
}