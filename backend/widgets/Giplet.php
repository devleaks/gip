<?php
/**
 * Giplet widget renders the last messages available on the website.
 *
 * @author Pierre M <devleaks.be@gmail.com>
 */

namespace backend\widgets;

use Yii;
use yii\bootstrap\Widget;

class Giplet extends Widget { // class should be abstract
	/** Message's source */
	public $source;
	
	/** Message type */
	public $type;
	
	/** Message channel(optional) */
	public $channel = null;
	
	/** top element identifier */
	public $id = null;
	
	/** giplet title */
	public $title = null;
	
}