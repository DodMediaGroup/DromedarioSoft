<?php

class ClientesController extends Controller
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
					'create', 'create__ajax',

					'estaciones',

					'autocomplete__json'
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
		$clientes = Usuarios::model()->findAllByAttributes(
											array('rol'=>2),
											array('condition'=>'t.estado != 2'));

		$this->render('admin', array(
			'clientes'=>$clientes
		));
	}

	public function actionCreate(){
		$load = Yii::app()->getClientScript();
		$load->registerScriptFile(Yii::app()->request->baseUrl.'/js/modules/clientes.js',CClientScript::POS_END);


		$model = new Usuarios;
		$modelPersona = new Personas;
		$modelPassword = new UsuarioPasswords;

		$passDefault = 'Dromedario_'.rand(100, 1000);
		$modelPassword->password = $passDefault;


		$this->render('create', array(
			'model'=>$model,
			'modelPersona'=>$modelPersona,
			'modelPassword'=>$modelPassword
		));
	}
	public function actionCreate__ajax(){
		if(Yii::app()->getRequest()->getIsAjaxRequest() && isset($_POST['Personas'])){
			$response = array('status'=>'error');
			$error = false;

			$model = new Usuarios;
			$modelPersona = new Personas;
			$modelPassword = new UsuarioPasswords;

			$model->attributes = $_POST['Usuarios'];
			$model->usuario = $_POST['Personas']['nombre'].$_POST['Personas']['apellido'];
			$model->rol = 2;

			$user = Usuarios::model()->findByAttributes(array('email'=>$model->email));
			if($user != null){
				$response['title'] = 'Error validación';
            	$response['message'] = 'Ya existe un usuario con este email';
			}
			else if($model->validate(null, false)){
				$modelPersona->attributes = $_POST['Personas'];
				$modelPersona->usuario = 0;
				if($modelPersona->validate(null, false)){
					$modelPassword->attributes = $_POST['UsuarioPasswords'];
					$modelPassword->usuario = 0;
					if($modelPassword->validate(null, false)){
						if($model->save()){
							$modelPersona->usuario = $model->id;
							
							$modelPassword->usuario = $model->id;
							$modelPassword->password = MyMethods::crypt_blowfish($modelPassword->password);
							
							$modelPersona->save();
							$modelPassword->save();

							$response['title'] = 'Echo';
			            	$response['message'] = 'El cliente se agrego con exito.';
			            	$response['status'] = 'success';
						}
					}
					else{
						$response['title'] = 'Error validación';
            			$response['message'] = 'Verifique los campos de "Datos de acceso"';
					}
				}
				else{
					$response['title'] = 'Error validación';
            		$response['message'] = 'Verifique los campos de "Información personal"';
				}
			}
			else{
            	$response['title'] = 'Error validación';
            	$response['message'] = 'Verifique los campos de "Datos de acceso"';
            }

			echo CJSON::encode($response);
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}



	public function actionEstaciones($id){
		$cliente = $this->loadModel($id);
		$estaciones = Estaciones::model()->findAllByAttributes(array('usuario'=>$cliente->id));

		$this->render('//estaciones/admin', array(
			'cliente'=>$cliente,
			'estaciones'=>$estaciones
		));
	}



	public function actionAutocomplete__json(){
		if(Yii::app()->getRequest()->getIsAjaxRequest() && isset($_GET['term'])){
			$response = array();

			$clientes = Personas::model()->findAll(array('condition'=>'t.identificacion LIKE "%'.$_GET['term'].'%" OR t.nombre LIKE "%'.$_GET['term'].'%" OR t.apellido LIKE "%'.$_GET['term'].'%"'));

			foreach ($clientes as $key => $cliente) {
				$response[] = array(
					'id'=>$cliente->usuario,
					'label'=>'['.$cliente->identificacion.'] '.$cliente->nombre.' '.$cliente->apellido,
					'value'=>$cliente->identificacion
				);
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
		$model = Usuarios::model()->findByAttributes(array('id'=>$id), array('condition'=>'t.estado != 2'));
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
