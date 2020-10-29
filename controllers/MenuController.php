<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Menu;
use app\models\Product;
use app\models\Info;
use yii\data\Pagination;

class MenuController extends AppController
{
	
    public function actionIndex()
    {
        $res = [1 => 'Port Place (base_1)',
                2 => 'Evropeysiy (base_2)'
                ];
        $this->setMeta('Portal');      
        return $this->render('index',['res'=>$res]);
    }

            public function actionView($id)
    {   
        $session = Yii::$app->session;
        $session->open();
        $session->set('db',$id);
        $menu = Menu::find()->all();
            $query = Product::find();
            $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 20, 'forcePageParam'=>false, 'pageSizeParam'=>false]);
            $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $info = Info::findOne(1);
        $this->setMeta('Portal |'. $info->name);
        return $this->render('view', ['menu'=>$menu,'products'=>$products,'info'=>$info,'pages'=>$pages]);

    }

    	public function actionViewcat($id)
    	{	$info = Info::findOne(1);
    		if(!$id == 0){
    		$query = Product::find()->where(['category_id'=> $id]);
    		}else{
    		$query = Product::find();	
    		}
        		$pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 2, 'forcePageParam'=>false, 'pageSizeParam'=>false]);
        		$catproduct = $query->offset($pages->offset)->limit($pages->limit)->all();
            $category = Menu::findOne($id);


    		$this->setMeta($info->name . '|' . $category->name, $category->keywords,$category->description);

    		return $this->render('viewcat',['catproduct'=>$catproduct,'info'=>$info,'category'=>$category,'pages'=>$pages]);
    	}
}