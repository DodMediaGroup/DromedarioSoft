<?php

/**
 * This is the model class for table "sites_estados_iniciales_items".
 *
 * The followings are the available columns in table 'sites_estados_iniciales_items':
 * @property integer $id
 * @property integer $estado_inicial
 * @property integer $item
 * @property string $observaciones
 * @property string $responsable
 * @property string $ubicacion
 *
 * The followings are the available model relations:
 * @property EstadosInicialesItems $item0
 * @property SitesEstadosIniciales $estadoInicial
 */
class SitesEstadosInicialesItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sites_estados_iniciales_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estado_inicial, item', 'required'),
			array('estado_inicial, item', 'numerical', 'integerOnly'=>true),
			array('observaciones, responsable, ubicacion', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, estado_inicial, item, observaciones, responsable, ubicacion', 'safe', 'on'=>'search'),
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
			'item0' => array(self::BELONGS_TO, 'EstadosInicialesItems', 'item'),
			'estadoInicial' => array(self::BELONGS_TO, 'SitesEstadosIniciales', 'estado_inicial'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'estado_inicial' => 'Estado Inicial',
			'item' => 'Item',
			'observaciones' => 'Observaciones',
			'responsable' => 'Responsable',
			'ubicacion' => 'Ubicacion',
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
		$criteria->compare('estado_inicial',$this->estado_inicial);
		$criteria->compare('item',$this->item);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('responsable',$this->responsable,true);
		$criteria->compare('ubicacion',$this->ubicacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SitesEstadosInicialesItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
