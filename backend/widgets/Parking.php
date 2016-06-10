<?php
/**
 * LatestMessages widget renders the last messages available on the website.
 *
 * @author Pierre M <devleaks.be@gmail.com>
 */

namespace backend\widgets;

use Yii;

class Parking extends Giplet {
	
	public $parking_data = [];
	
	public function run() {
        return $this->render('parking', [
			'id' => $this->id ? $this->id : null,
			'widget' => $this
        ]);
	}

}