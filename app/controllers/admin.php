<?php

use Illuminate\Database\Capsule\Manager as DB;
use \Core\Controller as Controller;
use \Model\User as User;
use \Model\UserGroup as UserGroup;

/**
 * Admin control panel routes
 */
class Admin extends Controller
{
    /**
     * Required roles for specific routes
     *
     * @var array
     */
    public $protected_roles = [
        'index' => 'admin.access',
        'users' => 'admin.access.users',
        'groups' => 'admin.access.groups',
        'group' => 'admin.access.group'
    ];

    /**
     * Default homepage for the admin page
     *
     * @param array $params
     *
     * @return void
     */
    public function index($params)
    {
        $this->assertType($params, 'GET');

        $this->view('admin/index.html');
    }

    /**
     * Default homepage for the admin page
     *
     * @param array $params
     *
     * @return void
     */
    public function profile($params)
    {
        $this->assertType($params, 'GET');
        $this->requireParams($params, ['id']);
        $id = $params['id'];
        $user = User::find($id);

        $groups = array_pluck($user->userGroupLink->toArray(), 'group_id');
        $users_groups = [];

        foreach($user->userGroupLink as $group_link) {
            $group = $group_link->userGroup->toArray();
            $group['count'] = $group_link->userGroup->count();
            array_push($users_groups, $group);
        }

        $this->view('admin/profile.html', ['user' => $user, 'groups' => $users_groups]);
    }

    /**
     * Users page of admin panel
     *
     * @param array $params
     *
     * @return void
     */
    public function users($params)
    {
        $this->assertType($params, 'GET');

        if (isset($params['page'])) {
            $currentPage = $params['page'];
        } else {
            $currentPage = 1;
        }

        $users = User::paginate(10, ['*'], 'page', $currentPage)->withPath('/admin/users')->toArray();

        $users['current_page'] = $currentPage;

        $this->view('admin/users.html', $users);
    }

    /**
     * Groups page of admin panel
     *
     * @param array $params
     *
     * @return void
     */
    public function groups($params)
    {
        $this->assertType($params, 'GET');

        if (isset($params['page'])) {
            $currentPage = $params['page'];
        } else {
            $currentPage = 1;
        }

        $groups = UserGroup::withCount('userGroupLink')
                    ->paginate(10, ['*'], 'page', $currentPage)
                    ->withPath('/admin/groups')
                    ->toArray();

        $groups['current_page'] = $currentPage;

        $this->view('admin/groups.html', $groups);
    }


    /**
     * Individual group page of admin panel
     *
     * @param array $params
     *
     * @return void
     */
    public function group($params)
    {
        $this->assertType($params, 'GET');

        if (isset($params['id'])) {
            $id = $params['id'];
        } else {
            $this->redirect('/admin/groups');
        }
        if (isset($params['page'])) {
            $currentPage = $params['page'];
        } else {
            $currentPage = 1;
        }

        $group = UserGroup::find($id)->toArray();

        $users = DB::table('user_group')
                    ->join('user_group_link', 'user_group.id', '=', 'user_group_link.group_id')
                    ->join('user', 'user.id', '=', 'user_group_link.user_id')
                    ->where('user_group.id', '=', $id)
                    ->select('user.*')
                    ->paginate(10, ['*'], 'page', $currentPage)
                    ->withPath('/admin/group?id=' . $id)
                    ->toArray();

        $this->view('admin/group.html', [
            'group'=> $group,
            'users' => $users
        ]);
    }
}
