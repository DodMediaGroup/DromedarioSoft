<?php

/**
 * This is the model class for table "dispositivos".
 *
 * The followings are the available columns in table 'dispositivos':
 * @property integer $id
 * @property integer $estacion
 * @property string $llave
 * @property string $nombre
 *
 * The followings are the available model relations:
 * @property Estaciones $estacion0
 * @property Registros[] $registroses
 */
class Dispositivos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dispositivos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estacion, llave, nombre', 'required'),
			array('estacion', 'numerical', 'integerOnly'=>true),
			array('llave', 'length', 'max'=>65),
			array('nombre', 'length', 'max'=>155),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, estacion, llave, nombre', 'safe', 'on'=>'search'),
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
			'estacion0' => array(self::BELONGS_TO, 'Estaciones', 'estacion'),
			'registroses' => array(self::HAS_MANY, 'Registros', 'dispositivo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'estacion' => 'Estacion',
			'llave' => 'Llave',
			'nombre' => 'Nombre',
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
		$criteria->compare('estacion',$this->estacion);
		$criteria->compare('llave',$this->llave,true);
		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dispositivos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
