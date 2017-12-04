<?php

namespace common\models;

use Yii;
use \common\models\base\Style as BaseStyle;
use \common\behaviors\ListAll;

/**
 * This is the model class for table "style".
 */
class Style extends BaseStyle
{
	use ListAll;

	const STROKE_TYPES = 'STROKE_TYPES';
	const FILL_PATTERNS = 'FILL_PATTERNS';
	const FONT_SIZES = 'FONT_SIZES';
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'display_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'stroke_width'], 'integer'],
            [['glyph_size'], 'number'],
            [['name', 'display_name', 'glyph', 'stroke_style', 'stroke_color', 'fill_pattern', 'fill_color', 'font_size'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 2000],
            [['font_name'], 'string', 'max' => 200],
            [['name'], 'unique'],
            [['display_name'], 'unique']
        ]);
    }
	
}
/* Fill patterns:

.circles-1
.circles-2
.circles-3
.circles-4
.circles-5
.circles-6
.circles-7
.circles-8
.circles-9
.diagonal-stripe-1
.diagonal-stripe-2
.diagonal-stripe-3
.diagonal-stripe-4
.diagonal-stripe-5
.diagonal-stripe-6
.dots-1
.dots-2
.dots-3
.dots-4
.dots-5
.dots-6
.dots-7
.dots-8
.dots-9
.horizontal-stripe-1
.horizontal-stripe-2
.horizontal-stripe-3
.horizontal-stripe-4
.horizontal-stripe-5
.horizontal-stripe-6
.horizontal-stripe-7
.horizontal-stripe-8
.horizontal-stripe-9
.vertical-stripe-1
.vertical-stripe-2
.vertical-stripe-3
.vertical-stripe-4
.vertical-stripe-5
.vertical-stripe-6
.vertical-stripe-7
.vertical-stripe-8
.vertical-stripe-9
.crosshatch
.houndstooth
.lightstripe
.smalldot
.verticalstripe
.whitecarbon

*/