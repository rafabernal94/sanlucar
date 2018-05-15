<?php

namespace app\controllers;

use app\models\Pasajeros;
use app\models\Solicitudes;
use app\models\Trayectos;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PasajerosController implements the CRUD actions for Pasajeros model.
 */
class PasajerosController extends Controller
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
        ];
    }

    /**
     * Deletes an existing Pasajeros model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param mixed $usuarioId
     * @param mixed $trayectoId
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEliminar($usuarioId, $trayectoId)
    {
        $model = Pasajeros::findOne([
            'usuario_id' => $usuarioId,
            'trayecto_id' => $trayectoId,
        ]);

        $solicitud = Solicitudes::findOne([
            'usuario_id' => $usuarioId,
            'trayecto_id' => $trayectoId,
        ]);

        $trayecto = Trayectos::findOne($trayectoId);
        $model->delete();
        $solicitud->delete();
        $trayecto->plazas += 1;
        if ($trayecto->save()) {
            Yii::$app->session->setFlash('success', 'Te has retirado del trayecto correctamente.');
            return $this->redirect(['/trayectos/detalles', 'id' => $trayectoId]);
        }
    }

    /**
     * Finds the Pasajeros model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Pasajeros the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pasajeros::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
