<?php

/**
 * This is the model class for table "sites_consumos_energeticos".
 *
 * The followings are the available columns in table 'sites_consumos_energeticos':
 * @property integer $id
 * @property integer $site_consumo
 * @property integer $energetico
 * @property integer $consumo
 * @property integer $precio_unidad
 * @property string $consumo_meses
 *
 * The followings are the available model relations:
 * @property Energeticos $energetico0
 * @property SitesConsumos $siteConsumo
 */
class SitesConsumosEnergeticos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sites_consumos_energeticos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_consumo, energetico', 'required'),
			array('site_consumo, energetico, consumo, precio_unidad', 'numerical', 'integerOnly'=>true),
			array('consumo_meses', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, site_consumo, energetico, consumo, precio_unidad, consumo_meses', 'safe', 'on'=>'search'),
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
			'energetico0' => array(self::BELONGS_TO, 'Energeticos', 'energetico'),
			'siteConsumo' => array(self::BELONGS_TO, 'SitesConsumos', 'site_consumo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'site_consumo' => 'Site Consumo',
			'energetico' => 'Energetico',
			'consumo' => 'Consumo',
			'precio_unidad' => 'Precio Unidad',
			'consumo_meses' => 'Consumo Meses',
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
		$criteria->compare('site_consumo',$this->site_consumo);
		$criteria->compare('energetico',$this->energetico);
		$criteria->compare('consumo',$this->consumo);
		$criteria->compare('precio_unidad',$this->precio_unidad);
		$criteria->compare('consumo_meses',$this->consumo_meses,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SitesConsumosEnergeticos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
