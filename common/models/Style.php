<?php

namespace common\models;

use Yii;
use \common\models\base\Style as BaseStyle;

/**
 * This is the model class for table "style".
 */
class Style extends BaseStyle
{
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
