<?php

namespace app\models;

/**
 * This is the model class for table "conversaciones".
 *
 * @property int $id
 * @property int $usuario1_id
 * @property int $usuario2_id
 *
 * @property UsuariosId $usuario1
 * @property UsuariosId $usuario2
 */
class Conversaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conversaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario1_id', 'usuario2_id'], 'required'],
            [['usuario1_id', 'usuario2_id'], 'default', 'value' => null],
            [['usuario1_id', 'usuario2_id'], 'integer'],
            [['usuario1_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['usuario1_id' => 'id']],
            [['usuario2_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosId::className(), 'targetAttribute' => ['usuario2_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario1_id' => 'Usuario1 ID',
            'usuario2_id' => 'Usuario2 ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario1()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario1_id'])->inverseOf('conversaciones');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario2()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario2_id'])->inverseOf('conversaciones0');
    }
}
