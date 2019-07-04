<?php

class Admin extends Controller
{
    /**
     * Default homepage for the admin page
     */
    public function index()
    {
        $this->view('admin/index.html');
    }

    /**
     * Users page of admin panel
     */
    public function users($params)
    {
        if (isset($params['page'])) {
            $currentPage = $params['page'];
        } else {
            $currentPage = 1;
        }

        $users = User::paginate(2, ['*'], 'page', $currentPage)->withPath('/admin/users')->toArray();

        $users['current_page'] = $currentPage;

        $this->view('admin/users.html', $users);
    }
}
