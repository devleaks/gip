<?php
/**
 * LatestMessages widget renders the last messages available on the website.
 *
 * @author Pierre M <devleaks.be@gmail.com>
 */

namespace backend\widgets;

use Yii;

class DelayTable extends Giplet {
	
	public $delays = [];
	
	protected function compute_delays() {
	}
	
	public function run() {
		$this->compute_delays();
        return $this->render('delay-table', [
			'id' => $this->id ? $this->id : null,
			'widget' => $this
        ]);
	}

}