<?php

namespace app\controllers;

use app\models\Usuarios;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
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
                    'delete' => ['POST'],
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
        $model = new Usuarios();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->enviarEmailConfirmacion($model);
            Yii::$app->session->setFlash('success', 'Se ha enviado un email a su correo electrónico para confirmar la cuenta.');
            return $this->redirect(['site/login']);
        }

        return $this->render('registrar', [
            'model' => $model,
        ]);
    }

    /**
     * Envía un email de confirmación al usuario que se registra.
     * @param  Usuarios $model El usuario al cuál se le envía el email
     * @return bool            Devuelve true si se ha enviado correctamente,
     *                         false en caso contrario
     */
    public function enviarEmailConfirmacion($model)
    {
        return Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($model->email)
            ->setSubject('Email de validación de cuenta')
            ->setHtmlBody(
                'Te has registrado correctamente en <strong>SanLuCar</strong>.<br><br>' .
                Html::a(
                    'Click aquí para activar su cuenta',
                    Url::to([
                        'usuarios/validar',
                        'token' => $model->token_val,
                    ], true)
                )
            )->send();
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
