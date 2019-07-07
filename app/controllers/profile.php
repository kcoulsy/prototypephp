<?php

class Profile extends Controller
{
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