<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $nombre
 * @property string $apellido
 * @property string $biografia
 * @property string $auth_key
 * @property string $token_val
 * @property string $created_at
 * @property string $updated_at
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $passwordRepeat;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['passwordRepeat']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'nombre', 'apellido', 'passwordRepeat'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['email', 'password', 'nombre', 'apellido', 'biografia', 'auth_key', 'token_val'], 'string', 'max' => 255],
            [['passwordRepeat'], 'compare', 'compareAttribute' => 'password'],
            [['email'], 'unique'],
            [['token_val'], 'unique'],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
            'passwordRepeat' => 'Confirma tu contraseña',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'biografia' => 'Biografía',
            'auth_key' => 'Auth Key',
            'token_val' => 'Token Val',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword(
            $password,
            $this->password
        );
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->token_val = Yii::$app->security->generateRandomString();
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }
}
