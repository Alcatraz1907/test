<?php

namespace app\modules\blog\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $user_id
 * @property string $title
 * @property string $text
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'user_id', 'title', 'text'], 'required'],
            [['post_id', 'user_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'text' => 'Text',
        ];
    }

    public function getPosts(){
	    return $this->hasMany(Posts::className(), ['post_id' => 'id']);
    }

    public static function getCommentForPost($post_id) {
	    $query = new Query();
	    return $query->select('comments.*, user.username')
		        ->from('comments')
	            ->join('join','posts', '`posts`.`id` = `comments`.`post_id`')
	            ->join('join','user', '`user`.`id` = `comments`.`user_id`')
	            ->where(['comments.post_id' => $post_id])
//		    ->with('orders')
                ->all();
//	    return Comments::find()
//		    ->select('comments.*, user.*, posts.*')
//		    ->leftJoin('posts', '`posts`.`id` = `comments`.`post_id`')
//		    ->leftJoin('user', '`user`.`id` = `comments`.`user_id`')
//		    ->where(['comments.post_id' => $post_id])
////		    ->with('orders')
//		    ->all();
    }
}
