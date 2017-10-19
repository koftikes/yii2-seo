<?php

namespace sbs\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%seo}}".
 *
 * @property integer $id
 * @property integer $item_id
 * @property string $modelName
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class Seo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id'], 'integer'],
            [['modelName'], 'required'],
            [['modelName'], 'string', 'max' => 150],
            [['title', 'keywords'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Seo Title',
            'keywords' => 'Seo Keywords',
            'description' => 'Seo Description',
        ];
    }
}
