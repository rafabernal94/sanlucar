<?php

namespace app\controllers;

use app\models\Conversaciones;
use app\models\Mensajes;
use app\models\Usuarios;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MensajesController implements the CRUD actions for Mensajes model.
 */
class MensajesController extends Controller
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
     * Creates a new Mensajes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @param mixed $receptor
     */
    public function actionCrear($receptor = null)
    {
        $idAct = Yii::$app->user->id;
        $model = new Mensajes();

        if ($receptor !== null) {
            if (($usuario = Usuarios::findOne($receptor)) === null) {
                throw new NotFoundHttpException('El usuario receptor no existe.');
            }
            $conversacion = Conversaciones::find()
                ->where(['usuario1_id' => $idAct])->andWhere(['usuario2_id' => $receptor])->one();

            if ($conversacion === null) {
                $conversacion = Conversaciones::find()
                    ->where(['usuario1_id' => $receptor])->andWhere(['usuario2_id' => $idAct])->one();
                if ($conversacion === null) {
                    $conversacion = new Conversaciones([
                            'usuario1_id' => $idAct,
                            'usuario2_id' => $receptor,
                        ]);
                    $conversacion->save();
                }
            }
        }
        $model->usuario_id = $idAct;
        $model->conversacion_id = $conversacion->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Mensaje enviado correctamente.');
            return $this->goHome();
        }

        return $this->renderAjax('crear', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Mensajes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Mensajes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mensajes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
