<?php

class Users extends Controller
{
    public function index()
    {
        $users = User::all()->toArray();

        $this->view('users/index.html', [ 'users' => $users]);
    }

    public function create()
    {
        $this->view('users/create.html');
    }

    public function store($params)
    {
        $user = User::create([
            'username' => $params['username'],
            'email' => $params['email']
        ]);

        $this->redirect('/users/index');
    }

    public function show($id)
    {
        $user = User::find($id)->toArray();

        $this->view('users/show.html', $user);

    }

    public function edit($id)
    {
        $user = User::find($id)->toArray();

        $this->view('users/edit.html', $user);
    }

    public function update($params)
    {
        $user = User::find($params['id']);

        $user->username = $params['username'];
        $user->email = $params['email'];
        $user->save();

        $this->redirect('/users');
    }

    public function destroy($params)
    {
        $user = User::findOrFail($params['id']);
        $user->delete();

        $this->redirect('/users');
    }
}