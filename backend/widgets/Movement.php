<?php
/**
 * LatestMessages widget renders the last messages available on the website.
 *
 * @author Pierre M <devleaks.be@gmail.com>
 */

namespace backend\widgets;

use Yii;

class Movement extends Giplet {
	
	public $movements = [];
	
	public function run() {
        return $this->render('movement', [
			'id' => $this->id ? $this->id : null,
			'widget' => $this
        ]);
	}

}