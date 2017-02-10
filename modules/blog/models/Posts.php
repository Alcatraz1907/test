<?php

namespace app\modules\blog\models;

use Yii;
use yii\helpers\BaseStringHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $text_preview
 * @property string $img
 * @property integer $user_id
 */
class Posts extends \yii\db\ActiveRecord
{
	public $image;
	public $string;
	public $filename;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 150],
            [['text_preview'], 'string', 'max' => 255],
	        [['user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'text_preview' => 'Text Preview',
            'img' => 'Img',
        ];
    }

    public function getComments(){
	    return $this->hasOne(Comments::className(), ['id' => 'post_id']);
    }

    public function beforeSave( $insert ) {
	    if(!empty(UploadedFile::getInstance($this, 'img'))) {
		    if ( $this->isNewRecord ) {
			    //generate && update
			    $this->string   = substr( uniqid( 'img' ), 0, 12 );
			    $this->image    = UploadedFile::getInstance( $this, 'img' );
			    $this->filename = 'static/images/' . $this->string . '.' . $this->image->extension;
			    $this->image->saveAs( $this->filename );
			    $this->text_preview = BaseStringHelper::truncate( $this->text, 250, '...' );
			    // save
			    $this->img = '/' . $this->filename;
		    } else {
			    $this->image = UploadedFile::getInstance( $this, 'img' );
			    if ( $this->image ) {
				    $this->image->saveAs( substr( $this->img, 1 ) );
			    }
		    }
	    } else {
		    $this->img = '/static/images.jpg';
	    }
		return parent::beforeSave($insert);
    }
}
