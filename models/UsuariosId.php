<?php

namespace app\models;

/**
 * This is the model class for table "usuarios_id".
 *
 * @property int $id
 *
 * @property Coches[] $coches
 * @property Trayectos[] $trayectos
 * @property Usuarios $usuarios
 */
class UsuariosId extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios_id';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id'])->inverseOf('usuarioId');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrayectos()
    {
        return $this->hasMany(Trayectos::className(), ['conductor_id' => 'id'])->inverseOf('conductor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoches()
    {
        return $this->hasMany(Coches::className(), ['usuario_id' => 'id'])->inverseOf('usuarioId');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPasajero()
    {
        return $this->hasMany(Pasajeros::className(), ['usuario_id' => 'id'])->inverseOf('usuarioId');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudes()
    {
        return $this->hasMany(Solicitudes::className(), ['usuario_id' => 'id'])->inverseOf('usuarioId');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensajes()
    {
        return $this->hasMany(Mensajes::className(), ['usuario_id' => 'id'])->inverseOf('usuarioId');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversaciones()
    {
        return $this->hasMany(Conversaciones::className(), ['id' => 'emisor_id'])->inverseOf('emisor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversaciones0()
    {
        return $this->hasMany(Conversaciones::className(), ['id' => 'receptor_id'])->inverseOf('receptor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValoraciones()
    {
        return $this->hasMany(Valoraciones::className(), ['valorador_id' => 'id'])->inverseOf('valorador');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValoraciones0()
    {
        return $this->hasMany(Valoraciones::className(), ['valorado_id' => 'id'])->inverseOf('valorado');
    }
}
