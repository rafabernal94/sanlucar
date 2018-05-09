<?php

namespace app\models;

/**
 * This is the model class for table "coches".
 *
 * @property int $id
 * @property string $marca
 * @property string $modelo
 * @property string $matricula
 * @property int $usuario_id
 * @property string $plazas
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UsuariosId $usuario
 */
class Coches extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coches';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['marca', 'modelo', 'usuario_id', 'plazas'], 'required'],
            [['usuario_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['plazas'], 'number'],
            [['created_at', 'updated_at', 'matricula'], 'safe'],
            [['marca', 'modelo'], 'string', 'max' => 255],
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
            'marca' => 'Marca',
            'modelo' => 'Modelo',
            'matricula' => 'Matrícula',
            'usuario_id' => 'Usuario ID',
            'plazas' => 'Plazas',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioId()
    {
        return $this->hasOne(UsuariosId::className(), ['id' => 'usuario_id'])->inverseOf('coches');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['coche_fav' => 'id'])->inverseOf('cocheFav');
    }
}
