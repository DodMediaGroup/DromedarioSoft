<?php

/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property integer $id
 * @property string $usuario
 * @property string $email
 * @property integer $rol
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Dispositivos[] $dispositivoses
 * @property Personas[] $personases
 * @property UsuarioPasswords[] $usuarioPasswords
 * @property UsuarioRoles $rol0
 */
class Usuarios extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, email, rol', 'required'),
			array('rol, estado', 'numerical', 'integerOnly'=>true),
			array('usuario, email', 'length', 'max'=>155),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, usuario, email, rol, estado', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'dispositivoses' => array(self::HAS_MANY, 'Dispositivos', 'usuario'),
			'personases' => array(self::HAS_MANY, 'Personas', 'usuario'),
			'usuarioPasswords' => array(self::HAS_MANY, 'UsuarioPasswords', 'usuario'),
			'rol0' => array(self::BELONGS_TO, 'UsuarioRoles', 'rol'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario' => 'Usuario',
			'email' => 'Email',
			'rol' => 'Rol',
			'estado' => 'Estado',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('rol',$this->rol);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuarios the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
