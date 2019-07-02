<?php

class Users extends Controller
{
    /**
     * Default page for /users. Pulls a list of users and displays in a table.
     */
    public function index()
    {
        $users = User::all()->toArray();

        $this->view('users/index.html', [ 'users' => $users]);
    }

    /**
     * User creation page.
     */
    public function create()
    {
        $this->view('users/create.html');
    }

    /**
     * Creates a User and stores in the databse with given params.
     *
     * @param array $params - POST Form Data values
     */
    public function store($params)
    {
        $user = User::create([
            'username' => $params['username'],
            'email' => $params['email']
        ]);

        $this->redirect('/users/index');
    }

    /**
     * User profile page.
     *
     * @param array $params
     */
    public function profile($params)
    {
        $id = $params['id'];

        if (!isset($id)) {
            $this->redirect('/users/index');
        }

        $user = User::find($id);

        if (!isset($user)) {
            $this->redirect('/users/index');
        }

        $this->view('users/show.html', $user->toArray());

    }

    /**
     * User edit page.
     *
     * @param array $params
     */
    public function edit($params)
    {
        $id = $params['id'];

        if (!isset($id)) {
            $this->redirect('/users/index');
        }

        $user = User::find($id);

        if (!isset($user)) {
            $this->redirect('/users/index');
        }

        $this->view('users/edit.html', $user->toArray());
    }

    /**
     * Updates the user with given params. id must be passed in.
     *
     * @param array $params - POST Form Data values
     */
    public function update($params)
    {
        $user = User::find($params['id']);

        $user->username = $params['username'];
        $user->email = $params['email'];
        $user->save();

        $this->redirect('/users');
    }

    /**
     * Deletes a user with a given id. id must be passed in.
     *
     * @param array $params - POST Form Data values
     */
    public function destroy($params)
    {
        $user = User::findOrFail($params['id']);
        $user->delete();

        $this->redirect('/users');
    }
}