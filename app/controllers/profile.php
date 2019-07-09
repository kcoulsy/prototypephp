<?php

/**
 * Routes for handling profile changes and routes
 */
class Profile extends Controller
{
    /**
     * Updates the user profile
     *
     * @param array $params
     *
     * @return void
     */
    public function update($params)
    {
        $this->assertType($params, 'POST');
        $this->requireParams($params, [
            'user_id'
        ]);

        $user_id = $params['user_id'];

        try {
            $current_user = $this->getUser();
            if ($current_user->id != $user_id) {

                $can_update = AuthController::hasRole('admin.profile.update');
                if (!$can_update) {
                    throw new Exception('You do not have the required role to update another user profile!');
                }
            }

            $user = User::find($params['user_id']);

            if ($_FILES['profile_image']['size'] > 0) {
                $uc = new UploadController(['jpg', 'png', 'jpeg', 'gif']);
                $new_profile_image = $uc->upload(null, 'profile_image');
                $user->userExtended()->update(['profile_image' => '/' . $new_profile_image]);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }

        $this->redirect('/admin/profile?id=' . $params['user_id']);
    }
}