<?php

namespace app\modules\blog\controllers;

use app\models\User;
use app\modules\blog\models\Comments;
use Yii;
use app\modules\blog\models\Posts;
use app\modules\blog\models\PostsSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * DefaultController implements the CRUD actions for Posts model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
	            'class' => AccessControl::className(),
	            'only'  => [ 'create', 'update', 'delete' ],
	            'rules' => [
	            	[
			            'actions' => [ 'create', 'update', 'delete' ],
			            'allow'   => true,
			            'roles'   => [ '@' ] // @ or ?
		            ]
	            ]
            ]
        ];
    }

    /**
     * Lists all Posts models.
     * @return mixed
     */
    public function actionIndex()
    {
	    $searchModel = new PostsSearch();
		$allPost = Posts::find();
		if(isset(Yii::$app->request->queryParams['PostsSearch']['title']))
			$allPost ->andWhere(['like', 'title', Yii::$app->request->queryParams['PostsSearch']['title']]);
	    if($allPost){
		    $pages = new Pagination(['totalCount' => $allPost->count(), 'pageSize' => 9]);

		    $posts = $allPost->offset($pages->offset)
			    ->limit($pages->limit)
			    ->all();

			return $this->render('index', [
				'posts' => $posts,
				'pages' => $pages,
				'searchModel' => $searchModel
			]);
	    }
    }

    /**
     * Displays a single Posts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
	    $post = $this->findModel($id);
	    $comment = new Comments();
	    $comment->post_id = $post->id;

//	    $comment_for_post = Comments::find()->where('post_id = '. $post->id)->all();
	    $comment_for_post = Comments::getCommentForPost($post->id);
        return $this->render('view', [
            'model' => $this->findModel($id),
	        'comment_form' => $comment,
	        'comment_for_post' => $comment_for_post
        ]);
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Posts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Posts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
