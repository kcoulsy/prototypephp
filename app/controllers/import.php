<?php

use \Core\Controller as Controller;

use \Model\Player as Player;

/**
 * Default route controller
 */
class Import extends Controller
{
    /**
     * Required roles for specific routes
     *
     * @var array
     */
    public $protected_roles = [];

    /**
     * Default homepage for the site.
     *
     * @param string $name The name displayed on the hero banner.
     *
     * @return void
     */
    public function index($params)
    {
        $this->assertType($params, 'GET');

        $this->view('import/index.html');
    }

    /**
     * Default homepage for the site.
     *
     * @param string $name The name displayed on the hero banner.
     *
     * @return void
     */
    public function update($params)
    {
        $this->assertType($params, 'POST');

        $this->view('import/updating.html');
        $data = json_decode($params['data']);
        // var_dump(json_last_error());
        if (json_last_error() != JSON_ERROR_NONE)  {
            echo 'Invalid data';
        } else {
            foreach($data as $player) {
                $name = str_replace('-Draenor', '', $player->name);
                // var_dump($player);
                $existing = Player::where('name', $name);
                if ($existing->count()) {
                    $existing = $existing->first();
                    echo 'Player found: ' . $existing->name . '<br />'; 
                    
                    $existing->rank_index = $player->rank_index;
                    $existing->player_class = strtolower($player->class);
                    $existing->officer_note = $player->officer_note;
                    $existing->note = $player->note;
                    $existing->save();
                    echo 'Player updated <br />'; 
                } else {
                    $new = new Player;
                    $new->name = $name;
                    $new->rank_index = $player->rank_index;
                    $new->player_class = strtolower($player->class);
                    $new->officer_note = $player->officer_note;
                    $new->note = $player->note;
                    $new->save();
                    echo 'Saved new player: ' . $name . '<br />';
                }
            }
        }
        echo '</div>'; //close of the container
    }
}