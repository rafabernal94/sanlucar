<?php

namespace app\controllers;

use app\models\EmailRecuperarForm;
use app\models\Usuarios;
use app\models\UsuariosId;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'eliminar' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['registrar', 'modificar', 'eliminar'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['registrar'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['modificar', 'eliminar'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Valida un usuario que se ha registrado.
     * @param  string $token Token de validación
     * @return mixed
     */
    public function actionValidar($token)
    {
        $usuario = Usuarios::findOne(['token_val' => $token]);

        if ($usuario === null) {
            Yii::$app->session->setFlash('error', 'Esta cuenta ya ha sido validada.');
        } else {
            $usuario->token_val = null;
            $usuario->save(false);
            Yii::$app->session->setFlash('success', 'Cuenta validada correctamente.');
        }
        return $this->redirect(['site/login']);
    }

    /**
     * Crea un nuevo modelo de Usuarios.
     * @return mixed
     */
    public function actionRegistrar()
    {
        $model = new Usuarios(['scenario' => Usuarios::ESCENARIO_CREATE]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $usuarioId = new UsuariosId();
            $usuarioId->save();
            $model->id = $usuarioId->id;
            $model->url_avatar = 'https://www.dropbox.com/s/u52msq5uguwea2s/avatar-default.png?dl=1';
            $model->save();
            $this->enviarEmail($model);
            Yii::$app->session->setFlash('success', 'Se ha enviado un email a su correo electrónico para confirmar la cuenta.');
            return $this->redirect(['site/login']);
        }

        return $this->render('registrar', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Usuarios model.
     * @param  int   $id
     * @return mixed
     */
    public function actionPerfil($id)
    {
        return $this->render('perfil', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param mixed $option
     * @param null|mixed $layout
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionModificar($option, $layout = null)
    {
        $model = Yii::$app->user->identity;
        $model->scenario = Usuarios::ESCENARIO_UPDATE;
        $model->password = '';

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->foto = UploadedFile::getInstance($model, 'foto');
            if ($model->validate() && $model->upload()) {
                if ($model->foto !== null) {
                    $model->foto = null;
                    $model->url_avatar = str_replace('dl=0', 'dl=1', $model->uploadDropbox());
                }
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Datos modificados correctamente.');
                    return $this->redirect(['modificar', 'option' => $option]);
                }
            }
        }

        if ($layout !== null) {
            $this->layout = $layout;
            return $this->render('foto_ventana', [
                'model' => $model,
            ]);
        }

        return $this->render('modificar', [
            'model' => $model,
            'option' => $option,
        ]);
    }

    /**
     * Elimina un modelo de Usuarios.
     * @return mixed
     */
    public function actionEliminar()
    {
        $model = Yii::$app->user->identity;
        $model->delete();
        Yii::$app->session->setFlash('success', 'Su cuenta ha sido eliminada correctamente.');
        return $this->goHome();
    }

    /**
     * Renderiza un formulario para restaurar la contraseña de un usuario.
     * @param  string $token El token de contraseña del usuario
     * @return mixed
     */
    public function actionRestaurarPass($token)
    {
        if (($model = Usuarios::findOne(['token_pass' => $token])) === null) {
            return $this->goHome();
        }

        $model->scenario = Usuarios::ESCENARIO_RECUPERAR;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->token_pass = null;
            $model->save();
            Yii::$app->session->setFlash(
                'success',
                'Tu contraseña se ha modificado correctamente.'
            );
            return $this->redirect(['site/login']);
        }
        $model->password = '';

        return $this->render('recuperar', [
            'model' => $model,
        ]);
    }

    /**
     * Envía un email al usuario que ha solicitado recuperar su contraseña.
     * @return mixed
     */
    public function actionRecuperarPass()
    {
        $form = new EmailRecuperarForm();
        $email = Yii::$app->request->post('email');
        if ($email !== null) {
            $form->email = $email;
            if ($form->validate()) {
                $token = Yii::$app->security->generateRandomString();
                $model = Usuarios::findOne(['email' => $email]);
                $model->token_pass = $token;
                if ($model->save()) {
                    $this->enviarEmail($model, true);
                    Yii::$app->session->setFlash(
                        'info',
                        'Recibirás un correo con instrucciones para restaurar tu contraseña.'
                    );
                    return $this->goHome();
                }
            }
        }

        return $this->render('email_recuperar', [
            'model' => $form,
        ]);
    }

    /**
     * Envía un email de confirmación al usuario que se registra.
     * @param  Usuarios $model El usuario al cuál se le envía el email
     * @param mixed $recuperar True si el correo es de recuperación de pass
     * @return bool            Devuelve true si se ha enviado correctamente,
     *                         false en caso contrario
     */
    public function enviarEmail($model, $recuperar = false)
    {
        $asunto = 'Validación de cuenta';
        $texto = 'Te has registrado correctamente en <strong>SanLuCar</strong>';
        $enlace = Html::a(
            'Click aquí para activar su cuenta',
            Url::to([
                'usuarios/validar',
                'token' => $model->token_val,
            ], true)
        );
        if ($recuperar) {
            $asunto = 'Restauración de contraseña';
            $texto = 'Has solicitado un cambio de contraseña';
            $enlace = Html::a('Modificar contraseña', Url::to([
                    'usuarios/restaurar-pass',
                    'token' => $model->token_pass,
                ], true));
        }
        $cuerpo = "¡Hola $model->nombre!<br>$texto.<br><br>$enlace";
        return Yii::$app->mailer->compose('template', [
            'usuario' => $model,
            'cuerpo' => $cuerpo,
        ])
        ->setFrom(Yii::$app->params['adminEmail'])
        ->setTo($model->email)
        ->setSubject($asunto)
        ->send();
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
