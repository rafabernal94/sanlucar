<?php

namespace app\models;

/**
 * This is the model class for table "pasajeros".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $trayecto_id
 *
 * @property Trayectos $trayecto
 * @property UsuariosId $usuario
 */
class Pasajeros extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pasajeros';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'trayecto_id'], 'required'],
            [['usuario_id', 'trayecto_id'], 'default', 'value' => null],
            [['usuario_id', 'trayecto_id'], 'integer'],
            [['trayecto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trayectos::className(), 'targetAttribute' => ['trayecto_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'trayecto_id' => 'Trayecto ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrayecto()
    {
        return $this->hasOne(Trayectos::className(), ['id' => 'trayecto_id'])->inverseOf('pasajeros');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioId()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id'])->inverseOf('pasajero');
    }
}
