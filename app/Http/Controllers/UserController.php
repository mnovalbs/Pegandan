<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        if($request->has('cari')){
            $data_user=\App\user::where('name', 'LIKE', '%'.$request->cari.'%')->get();
        } else 
        {
            $data_user = \App\user::all();
        }
        return view('user.index',['data_user'=>$data_user]);
    }

    public function create(Request $request)
    {

        $user = new \App\user;
        $user->name=$request->name;
        $user->occupation=$request->occupation;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->save();

//        $user = \App\user::create($request->all());
        return redirect('/user')->with('sukses', 'Data pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = \App\user::find($id);       
        return view('user/edit',['user'=>$user]);
    }

    public function update(Request $request, $id)
    {
        $user = \App\user::find($id);
        $user->update($request->all());
        return redirect('/user')->with('sukses', 'Data pengguna berhasil disunting');
    }

    public function delete ($id)
    {
        $user = \App\user::find($id);
        $user->delete($user);
        return redirect('/user')->with('sukses', 'Data pengguna berhasil dihapus.');
    }
}
