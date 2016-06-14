<?php

namespace console\controllers;

use console\controllers\Movement;

use yii\console\Controller;
use Yii;

class ParkingController extends Controller {
	/**
	 *  Create performs a mysql database backup.
	 *
	 */
    public function actionUpdate($uniq = true) {
		$passenger = null;
		$cargo = 0;
		foreach(Movement::find()->orderBy('MOVEMENT_DATE_EBLG_LT')->each() as $m) {
			if($passenger === null) {
				$passenger = 0;
				echo var_dump($m->attributes);
			}
			if($m->MOVEMENT_DIRECTION == 'A') {
				if($m->MOVEMENT_CATEGORY == 'C') {
					$cargo++;
				} else { // other or passenger
					$passenger++;
				}
			} else { // departure
				if($m->MOVEMENT_CATEGORY == 'C') {
					$cargo--;
				} else { // other or passenger
					$passenger--;
				}
			}
			$m->PARKING_CARGO = $cargo;
			$m->PARKING_PASSENGER = $passenger;
			$m->save();
		}
    }

}