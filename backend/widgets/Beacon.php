<?php
/**
 * LatestMessages widget renders the last messages available on the website.
 *
 * @author Pierre M <devleaks.be@gmail.com>
 */

namespace backend\widgets;

use Yii;
use yii\bootstrap\Widget;

class Beacon extends Giplet {
	/** number of recent message to display */
	public $header;
	
	/** text excerpt length */
	public $body;
	
	/** retricted to show only wires with this status */
	public $footer;
	
	/** retricted to show only wires with this status */
	public $color = 'default';
	
	/** top element identifier */
	public $id = null;
	
	public function init() {
		parent::init();
		$this->registerAssets();
	}
	
	public function run() {
        return $this->render('beacon', [
			'id' => $this->id ? $this->id : null,
			'widget' => $this
        ]);
	}

    /**
     * Register client assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        // IndicatorAsset::register($view);
    }

}