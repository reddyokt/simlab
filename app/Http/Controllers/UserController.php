<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
            'username' => 'required|max:255',
            'role' => 'required',
            'phone' => 'required|numeric|min:10',
            'email'=> 'required|email:dns|unique:users'
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
}
