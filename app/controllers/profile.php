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

        echo 'hereo';
        die();
    }
}