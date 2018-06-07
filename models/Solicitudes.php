<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solicitudes".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $trayecto_id
 *
 * @property Trayectos $trayecto
 * @property UsuariosId $usuario
 * @property bool $aceptada
 */
class Solicitudes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solicitudes';
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
            [['aceptada'], 'boolean'],
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
            'aceptada' => 'Aceptada',
        ];
    }

    /**
     * Devuelve el número de solicitudes pendientes que tiene el usuario conectado.
     * @return int El número de solicitudes pendientes
     */
    public static function getPendientes()
    {
        return self::find()
            ->joinWith('trayecto')
            ->where(['solicitudes.aceptada' => false])
            ->andWhere(['trayectos.conductor_id' => Yii::$app->user->id])
            ->count();
    }

    /**
     * Comprueba si una solicitud está aceptada o no.
     * @return bool True si está aceptada, false si no lo está.
     */
    public function estaAceptada()
    {
        return $this->aceptada;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrayecto()
    {
        return $this->hasOne(Trayectos::className(), ['id' => 'trayecto_id'])->inverseOf('solicitudes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioId()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id'])->inverseOf('solicitudes');
    }
}
