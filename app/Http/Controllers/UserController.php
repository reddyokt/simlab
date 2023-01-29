<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = User::all();
        //dd($data->all());
        return view ('user.index', compact('data'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Role::all();
        return view ('user.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
       $validatedData =  $request->validate([
            'username' => 'required|max:50|unique:users,username',
            'nama_lengkap'=> 'required|max:50',
            'role_id' => 'required'
       ]);
       $validatedData['password'] = Hash::make('qwerty');

       User::create($validatedData);

        return redirect ('/user')->with('success', 'Data Akun berhasil ditambahkan');
    }

    public function show($id)
    {
    $data = User::find($id);
    return view('user.edit', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());

        return redirect ('/user')->with('success', 'Data User berhasil diubah');

    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect ('/user')->with('success', 'Data User berhasil dihapus');
    }

    public function profile()
    {
        $data = User::where('id', auth()->id())
        ->get();
        return view ('/user/profile', compact ('data'));
    }

    public function profileedit(Request $request)
    {
        //dd($request->all());
        $user = User::find(auth()->id());
        $user->update($request->all());
        return redirect()->back();
    }

    public function passwordubah(Request $request)
    {
        //dd($request->all());
        $user = $request->validate([
            'old_password'=> 'required',
            'new_password'=> 'required|confirmed|min:7|string'
        ]);
        $auth = Auth::user();

        //matched old password//
        if(!Hash::check($request->get('old_password'), $auth->password))
        {
            return back()->with('error', 'old password salah');
        }
        //matched new_password//
        if(strcmp($request->get('old_password'), $request->new_password) ==0)
        {
            return redirect()->back()->with("error", "Password lama dan password baru tidak boleh sama");
        }

        $user = User::find($auth->id);
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->back()->with('success', 'Password berhasil diubah');
    }
}
