<?php

/**
 * This is the model class for table "registros".
 *
 * The followings are the available columns in table 'registros':
 * @property integer $id
 * @property integer $dispositivo
 * @property double $corriente_1
 * @property double $corriente_2
 * @property double $corriente_3
 * @property string $fecha
 *
 * The followings are the available model relations:
 * @property Dispositivos $dispositivo0
 */
class Registros extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'registros';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dispositivo, corriente_1, corriente_2, corriente_3', 'required'),
			array('dispositivo', 'numerical', 'integerOnly'=>true),
			array('corriente_1, corriente_2, corriente_3', 'numerical'),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, dispositivo, corriente_1, corriente_2, corriente_3, fecha', 'safe', 'on'=>'search'),
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
			'dispositivo0' => array(self::BELONGS_TO, 'Dispositivos', 'dispositivo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'dispositivo' => 'Dispositivo',
			'corriente_1' => 'Corriente 1',
			'corriente_2' => 'Corriente 2',
			'corriente_3' => 'Corriente 3',
			'fecha' => 'Fecha',
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
		$criteria->compare('dispositivo',$this->dispositivo);
		$criteria->compare('corriente_1',$this->corriente_1);
		$criteria->compare('corriente_2',$this->corriente_2);
		$criteria->compare('corriente_3',$this->corriente_3);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Registros the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
