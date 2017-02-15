<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = Usuarios::model()->findByAttributes(array('email'=>$this->username,'estado'=>1));

		if(!is_object($user))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		//else if(crypt($this->password, $user->password) != $user->password)
		else if($this->authenticateAccess($user, $this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{
			$this->errorCode=self::ERROR_NONE;

			$this->setState('_userId',$user->id);
			$this->setState('_userName',$user->usuario);
			$this->setState('_userEmail',$user->email);
			$this->setState('_userRol',$user->rol);
		}
		return !$this->errorCode;
	}

	private function authenticateAccess($user, $pass){
		$passModel = UsuarioPasswords::model()->findByAttributes(array('usuario'=>$user->id));
		if($passModel == null)
			return false;
		else if(crypt($pass, $passModel->password) != $passModel->password)
			return false;
		return true;
	}
}