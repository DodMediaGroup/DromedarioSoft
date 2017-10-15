<?php

/**
 * This is the model class for table "clientes_personas".
 *
 * The followings are the available columns in table 'clientes_personas':
 * @property integer $id
 * @property string $nombre
 * @property integer $identificacion
 * @property integer $tipo_identificacion
 * @property integer $cargo
 * @property string $email
 * @property integer $celular
 * @property string $telefono
 * @property integer $telefono_ext
 *
 * The followings are the available model relations:
 * @property Clientes[] $clientes
 * @property Clientes[] $clientes1
 * @property CargosPersonas $cargo0
 * @property TiposIdentificacion $tipoIdentificacion
 * @property SitesMantenimientosRegistros[] $sitesMantenimientosRegistroses
 */
class ClientesPersonas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'clientes_personas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, cargo, celular', 'required'),
			array('identificacion, tipo_identificacion, cargo, celular, telefono_ext', 'numerical', 'integerOnly'=>true),
			array('nombre, email', 'length', 'max'=>155),
			array('telefono', 'length', 'max'=>25),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, identificacion, tipo_identificacion, cargo, email, celular, telefono, telefono_ext', 'safe', 'on'=>'search'),
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
			'clientes' => array(self::HAS_MANY, 'Clientes', 'representante_legal'),
			'clientes1' => array(self::HAS_MANY, 'Clientes', 'responsable_programa_sge'),
			'cargo0' => array(self::BELONGS_TO, 'CargosPersonas', 'cargo'),
			'tipoIdentificacion' => array(self::BELONGS_TO, 'TiposIdentificacion', 'tipo_identificacion'),
			'sitesMantenimientosRegistroses' => array(self::HAS_MANY, 'SitesMantenimientosRegistros', 'responsable'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'identificacion' => 'Identificacion',
			'tipo_identificacion' => 'Tipo Identificacion',
			'cargo' => 'Cargo',
			'email' => 'Email',
			'celular' => 'Celular',
			'telefono' => 'Telefono',
			'telefono_ext' => 'Telefono Ext',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('identificacion',$this->identificacion);
		$criteria->compare('tipo_identificacion',$this->tipo_identificacion);
		$criteria->compare('cargo',$this->cargo);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('celular',$this->celular);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('telefono_ext',$this->telefono_ext);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClientesPersonas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
