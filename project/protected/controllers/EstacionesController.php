<?php

class EstacionesController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(
					'admin',
                    'view',
				),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(
					'create', 'create__ajax'
				),
				'users'=>array('@'),
				'expression'=>'MyMethods::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionAdmin(){
		if(Yii::app()->user->getState('_userRol') == 1)
			$estaciones = Estaciones::model()->findAll();
		else
			$estaciones = Estaciones::model()->findAllByAttributes(
			    array('usuario'=>Yii::app()->user->getState('_userId')));

		$this->render('admin', array(
			'estaciones'=>$estaciones
		));
	}

	public function actionView($id){
        $estacion = $this->loadModel($id);

        $dispositivos = Dispositivos::model()->findAllByAttributes(
            array('estacion'=>$estacion->id)
        );
        $this->render('view', array(
            'estacion'=>$estacion,
            'dispositivos'=>$dispositivos
        ));
    }

	public function actionCreate(){
		$load = Yii::app()->getClientScript();
		$load->registerScriptFile(Yii::app()->request->baseUrl.'/js/modules/estaciones.js',CClientScript::POS_END);


		$model = new Estaciones;

		$this->render('create', array(
			'model'=>$model,
		));
	}
	public function actionCreate__ajax(){
		if(Yii::app()->getRequest()->getIsAjaxRequest() && isset($_POST['Estaciones'])){
			$response = array('status'=>'error');
			$error = false;

			$model = new Estaciones;
			$model->attributes = $_POST['Estaciones'];

			if($model->validate(null, false)){
				if($model->save()){
					$response['title'] = 'Echo';
	            	$response['message'] = 'Se agrego correctamente la estación.';
	            	$response['status'] = 'success';
				}
			}
			else{
            	$response['title'] = 'Error validación';
            	$response['message'] = 'Verifique los campos de "Información estación"';
            }

			echo CJSON::encode($response);
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Almacenes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		if(Yii::app()->user->getState('_userRol') == 1)
			$model = Estaciones::model()->findByAttributes(array('id'=>$id));
		else
			$model = Estaciones::model()->findByAttributes(array('id'=>$id,
                'usuario'=>Yii::app()->user->getState('_userId')));

		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Almacenes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='almacenes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
