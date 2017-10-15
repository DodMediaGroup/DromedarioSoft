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
		/*$clientes = Usuarios::model()->findAllByAttributes(
											array('rol'=>2),
											array('condition'=>'t.estado != 2'));*/
		$clientes = Clientes::model()->findAll();

		$this->render('admin', array(
			'clientes'=>$clientes
		));
	}

	public function actionCreate(){
		$load = Yii::app()->getClientScript();
		$load->registerScriptFile(Yii::app()->request->baseUrl.'/js/modules/clientes.js',CClientScript::POS_END);


		$model = new Usuarios();
		$modelCliente = new Clientes();
		$modelRepresentanteLegal = new ClientesPersonas();
		$modelResponsablePrograma = new ClientesPersonas();
		$modelPassword = new UsuarioPasswords();

		$passDefault = 'Dromedario_'.rand(100, 1000);
		$modelPassword->password = $passDefault;


		$this->render('create', array(
			'model'=>$model,
			'modelCliente'=>$modelCliente,
			'modelRepresentanteLegal'=>$modelRepresentanteLegal,
			'modelResponsablePrograma'=>$modelResponsablePrograma,
			'modelPassword'=>$modelPassword
		));
	}
	public function actionCreate__ajax(){
		if(Yii::app()->getRequest()->getIsAjaxRequest() && isset($_POST['Clientes'])){
			$response = array(
			    'status'=>'error',
                'title'=> 'Error validación',
                'message'=>'Error en la validación de los datos!!!'
            );
			$error = false;

            $model = new Usuarios();

            $model->attributes = $_POST['Usuarios'];
            $model->usuario = $_POST['Clientes']['razon_social'];
            $model->rol = 2;

            $currentUser = Usuarios::model()->findByAttributes(array(
                'email'=>$model->email
            ));

            if($currentUser != null){
                $response['message'] = 'Ya existe un usuario con este email';
            }
            else{
                $modelPassword = new UsuarioPasswords();
                $modelPassword->password = MyMethods::crypt_blowfish($_POST['UsuarioPasswords']['password']);
                $modelPassword->usuario = 0;

                if($model->validate(null, false) && $modelPassword->validate(null, false)){
                    if(isset($_POST['Clientes']) && isset($_POST['ClientesPersonas']) && count($_POST['ClientesPersonas']) >= 2){
                        $modelCliente = new Clientes();
                        $modelRepresentanteLegal = new ClientesPersonas();
                        $modelResponsablePrograma = new ClientesPersonas();

                        $modelResponsablePrograma->attributes = $_POST['ClientesPersonas'][1];
                        if(!$modelResponsablePrograma->validate(null, false)){
                            $response['message'] = 'Error en la validación de los datos del responsable acompañamiento del programa PSG';
                            $error = true;
                        }

                        $modelRepresentanteLegal->attributes = $_POST['ClientesPersonas'][0];
                        if(!$modelRepresentanteLegal->validate(null, false)){
                            $response['message'] = 'Error en la validación de los datos del representante legal';
                            $error = true;
                        }

                        $modelCliente->attributes = $_POST['Clientes'];
                        $modelCliente->usuario = 0;
                        $modelCliente->representante_legal = 0;
                        $modelCliente->responsable_programa_sge = 0;

                        if(!$modelCliente->validate(null, false)){
                            $response['message'] = 'Error en la validación de los datos de la empresa';
                            $error = true;
                        }

                        if(!$error){
                            $model->save();

                            $modelPassword->usuario = $model->id;
                            $modelPassword->save();

                            $modelRepresentanteLegal->save();
                            $modelResponsablePrograma->save();

                            $modelCliente->usuario = $model->id;
                            $modelCliente->representante_legal = $modelRepresentanteLegal->id;
                            $modelCliente->responsable_programa_sge = $modelResponsablePrograma->id;
                            $modelCliente->save();

                            $response['title'] = 'Hecho';
                            $response['message'] = 'El cliente se agrego con exito.';
                            $response['status'] = 'success';
                            $response['new'] = $modelCliente->id;
                        }
                    }
                }
                else{
                    $response['message'] = 'Verifique los campos de "Datos de acceso"';
                }
            }

			echo CJSON::encode($response);
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}



	public function actionEstaciones($id){
		$cliente = $this->loadModel($id);
		$estaciones = SitesExtend::model()->findAllByAttributes(array(
		    'cliente'=>$cliente->id
        ));

		$this->render('//estaciones/admin', array(
			'cliente'=>$cliente,
			'estaciones'=>$estaciones
		));
	}



	public function actionAutocomplete__json(){
		if(Yii::app()->getRequest()->getIsAjaxRequest() && isset($_GET['term'])){
			$response = array();

			$clientes = Clientes::model()->findAll(array(
			    'condition'=>'t.nit LIKE "%'.$_GET['term'].'%" OR t.razon_social LIKE "%'.$_GET['term'].'%"'
            ));

			foreach ($clientes as $key => $cliente) {
				$response[] = array(
					'id'=>$cliente->id,
					'label'=>'['.$cliente->nit.'] '.$cliente->razon_social,
					'value'=>$cliente->nit
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
		$model = Clientes::model()->findByAttributes(array(
		    'id'=>$id
        ), array());
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
