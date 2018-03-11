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
    const ESCENARIO_CREATE = 'create';
    const ESCENARIO_UPDATE = 'update';

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
            [['email', 'nombre', 'apellido'], 'required'],
            [['password', 'passwordRepeat'], 'required', 'on' => self::ESCENARIO_CREATE],
            [['created_at', 'updated_at'], 'safe'],
            [['email', 'password', 'nombre', 'apellido', 'biografia', 'auth_key', 'token_val'], 'string', 'max' => 255],
            [
                ['passwordRepeat'],
                'compare',
                'compareAttribute' => 'password',
                'skipOnEmpty' => false,
                'on' => [self::ESCENARIO_UPDATE, self::ESCENARIO_CREATE],
                'message' => 'Las contraseñas deben ser iguales',
            ],
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
                if ($this->scenario === self::ESCENARIO_CREATE) {
                    $this->token_val = Yii::$app->security->generateRandomString();
                    $this->password = Yii::$app->security
                        ->generatePasswordHash($this->password);
                }
            } else {
                if ($this->scenario === self::ESCENARIO_UPDATE) {
                    if ($this->password === '') {
                        $this->password = $this->getOldAttribute('password');
                    } else {
                        $this->password = Yii::$app
                            ->security->generatePasswordHash($this->password);
                    }
                }
            }
            return true;
        }
        return false;
    }
}
