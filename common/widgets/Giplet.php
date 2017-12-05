<?php
/**
 * Giplet widget renders the last messages available on the website.
 *
 * @author Pierre M <devleaks.be@gmail.com>
 */

namespace common\widgets;

use Yii;
use yii\bootstrap\Widget;

class Giplet extends Widget { // class should be abstract
	
	/** top element identifier */
	public $id = null;
	
	/** giplet internal name */
	public $name;
	

	/** giplet title */
	public $title = null;
	
	/** giplet parameters */
	public $data = null;
	

	/** Message's source */
	public $source;
	
	/** Message type */
	public $type;
	
	/** Message channel(optional) */
	public $channel = null;
	
}