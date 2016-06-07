<?php
/**
 * LatestMessages widget renders the last messages available on the website.
 *
 * @author Pierre M <devleaks.be@gmail.com>
 */

namespace backend\widgets;

use Yii;

class FlightTable extends Giplet {
	
	public $flights = [];
	
	public function run() {
        return $this->render('flight-table', [
			'id' => $this->id ? $this->id : null,
			'widget' => $this
        ]);
	}

}