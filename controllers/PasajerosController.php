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
     * Si el usuario realiza el pago mediante PayPal correctamente.
     * @return mixed
     */
    public function actionPagar()
    {
        $pasajero_id = $_COOKIE['paypal_pasajero_id'];
        $pasajero = $this->findModel($pasajero_id);
        $pasajero->pagado = true;
        if ($pasajero->save()) {
            Yii::$app->session->setFlash('success', 'Pago realizado correctamente.');
            return $this->redirect(['/trayectos/detalles', 'id' => $pasajero->trayecto_id]);
        }
    }

    /**
     * Si el usuario cancela el pago mediante PayPal.
     * @return mixed
     */
    public function actionCancelar()
    {
        $pasajero_id = $_COOKIE['paypal_pasajero_id'];
        $pasajero = $this->findModel($pasajero_id);
        Yii::$app->session->setFlash('info', 'Has cancelado el pago del trayecto.');
        return $this->redirect(['/trayectos/detalles', 'id' => $pasajero->trayecto_id]);
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
