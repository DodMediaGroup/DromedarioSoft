<?php

/**
 * This is the model class for table "sites_censo_energeticos".
 *
 * The followings are the available columns in table 'sites_censo_energeticos':
 * @property integer $id
 * @property integer $censo
 * @property integer $energetico
 * @property string $area
 * @property string $equipo
 * @property integer $cantidad
 * @property integer $horas_uso_dia
 * @property integer $dias_uso_mes
 * @property integer $energia_mes
 *
 * The followings are the available model relations:
 * @property Energeticos $energetico0
 * @property SitesCensosCarga $censo0
 */
class SitesCensoEnergeticos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sites_censo_energeticos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('censo, energetico, area, equipo, horas_uso_dia, dias_uso_mes, energia_mes', 'required'),
			array('censo, energetico, cantidad, horas_uso_dia, dias_uso_mes, energia_mes', 'numerical', 'integerOnly'=>true),
			array('area, equipo', 'length', 'max'=>65),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, censo, energetico, area, equipo, cantidad, horas_uso_dia, dias_uso_mes, energia_mes', 'safe', 'on'=>'search'),
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
			'censo0' => array(self::BELONGS_TO, 'SitesCensosCarga', 'censo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'censo' => 'Censo',
			'energetico' => 'Energetico',
			'area' => 'Area',
			'equipo' => 'Equipo',
			'cantidad' => 'Cantidad',
			'horas_uso_dia' => 'Horas Uso Dia',
			'dias_uso_mes' => 'Dias Uso Mes',
			'energia_mes' => 'Energia Mes',
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
		$criteria->compare('censo',$this->censo);
		$criteria->compare('energetico',$this->energetico);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('equipo',$this->equipo,true);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('horas_uso_dia',$this->horas_uso_dia);
		$criteria->compare('dias_uso_mes',$this->dias_uso_mes);
		$criteria->compare('energia_mes',$this->energia_mes);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SitesCensoEnergeticos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
