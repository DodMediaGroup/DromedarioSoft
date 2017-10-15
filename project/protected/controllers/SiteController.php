<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if(!Yii::app()->user->isGuest){
            if(Yii::app()->user->getState('_userRol') == 1){
                $clientes = Personas::model()->findAll();
                $estaciones = Estaciones::model()->findAll();
                $dispositivos = Dispositivos::model()->findAll();

                $this->render('index__admin', array(
                    'clientes'=>$clientes,
                    'estaciones'=>$estaciones,
                    'dispositivos'=>$dispositivos
                ));
            }
            else{
                $estaciones = Estaciones::model()->findAllByAttributes(array(
                    'usuario'=>Yii::app()->user->getState('_userId')
                ));
                $dispositivos = [];
                foreach ($estaciones as $key=>$estacion){
                    $dispositivosRows = Dispositivos::model()->findAllByAttributes(array(
                        'estacion'=>$estacion->id
                    ));
                    foreach ($dispositivosRows as $index=>$dispositivo){
                        $dispositivos[] = $dispositivo;
                    }
                }

                $consumo = $registro = MyMethods::querySql('SELECT
                        sum(r.corriente_1 + r.corriente_2 + r.corriente_3) as consumo
                    FROM registros r
                    inner join dispositivos d on r.dispositivo=d.id
                    inner join estaciones e on d.estacion=e.id
                    where e.usuario = '.Yii::app()->user->getState('_userId').'
                    group by usuario;');

                $this->render('index__user', array(
                    'estaciones'=>$estaciones,
                    'dispositivos'=>$dispositivos,

                    'consumo'=>$consumo[0]
                ));
            }
		}
		else
			$this->redirect(array('login'));
	}

	public function actionSave(){
		if(isset($_GET['d']) && isset($_GET['v1']) && isset($_GET['v2']) && isset($_GET['v2'])){
			$llave = trim($_GET['d']);

			$dispositivo = Dispositivos::model()->findByAttributes(array('llave'=>$llave));
			if($dispositivo != null){
				$registro = new Registros;
				$registro->dispositivo = $dispositivo->id;
				$registro->corriente_1 = trim($_GET['v1']);
				$registro->corriente_2 = trim($_GET['v2']);
				$registro->corriente_3 = trim($_GET['v3']);
				
				if(!$registro->save())
					throw new CHttpException(404,'The requested page does not exist.');
			}
			else
				throw new CHttpException(404,'The requested page does not exist.');
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}


	public function actionDeviceTest(){
		$cant = 50;
		/*while ($cant > 0) {
			set_time_limit(20);

			$registro = new Registros;
			$registro->dispositivo = 5;
			$registro->corriente_1 = (0 + (rand(1,100) / 100));
			$registro->corriente_2 = (0 + (rand(1,100) / 100));
			$registro->corriente_3 = (0 + (rand(1,100) / 100));
			$registro->save();

			$cant--;

			sleep(rand(12,15));
		}*/

		//$segundos = 300;
		/*$segundos = 3600*24*35;
		while ($segundos > 0) {
			set_time_limit(20);

			$registro = new Registros;
			$registro->dispositivo = 2;
			$registro->corriente_1 = (0 + (rand(1,70) / 100));
			$registro->corriente_2 = (0 + (rand(1,70) / 100));
			$registro->corriente_3 = (0 + (rand(1,70) / 100));
            $registro->fecha = new CDbExpression('DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL '.$segundos.' SECOND)');
            //$registro->fecha = new CDbExpression('DATE_SUB("2017-02-01", INTERVAL '.$segundos.' SECOND)');
			$registro->save();

			$segundos = $segundos - rand(11,15);
		}*/
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = '//layouts/login';
		$model=new LoginForm;

		if(Yii::app()->getRequest()->getIsAjaxRequest()){
			$response = array('status'=>'error');

			$model->attributes=$_POST['LoginForm'];
			$model->login();
			if (CActiveForm::validate($model) != "[]"){
				$response = array(
					'status'=>'error',
					'title'=>'Error de validación',
					'message'=>'Nombre de usuario o password incorrecto.'
				);
			}
			else{
				$response = array(
					'status'=>'success',
					'title'=>'Exito',
					'message'=>'La validación se realizo correctamente.'
				);
			}
			echo CJSON::encode($response);
			Yii::app()->end();
		}
		else{
			if (Yii::app()->user->isGuest) {
				$this->render('login',array('model'=>$model));
			}
			else{
				Yii::app()->user->setReturnUrl('index');
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}