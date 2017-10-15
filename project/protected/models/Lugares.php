<?php

/**
 * This is the model class for table "lugares".
 *
 * The followings are the available columns in table 'lugares':
 * @property integer $id
 * @property integer $tipo
 * @property string $nombre
 * @property integer $lugar
 *
 * The followings are the available model relations:
 * @property Clientes[] $clientes
 * @property Lugares $lugar0
 * @property Lugares[] $lugares
 * @property LugaresTipos $tipo0
 */
class Lugares extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lugares';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo, nombre', 'required'),
			array('tipo, lugar', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>155),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tipo, nombre, lugar', 'safe', 'on'=>'search'),
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
			'clientes' => array(self::HAS_MANY, 'Clientes', 'municipio'),
			'lugar0' => array(self::BELONGS_TO, 'Lugares', 'lugar'),
			'lugares' => array(self::HAS_MANY, 'Lugares', 'lugar'),
			'tipo0' => array(self::BELONGS_TO, 'LugaresTipos', 'tipo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tipo' => 'Tipo',
			'nombre' => 'Nombre',
			'lugar' => 'Lugar',
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
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('lugar',$this->lugar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Lugares the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
