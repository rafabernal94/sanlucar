<?php

namespace app\controllers;

use app\models\Trayectos;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * TrayectosController implements the CRUD actions for Trayectos model.
 */
class TrayectosController extends Controller
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
                'only' => [
                    'publicar',
                    'trayectos-publicados',
                    'eliminar',
                    'modificar',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'publicar',
                            'trayectos-publicados',
                            'eliminar',
                            'modificar',
                        ],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lista los trayectos de un determinado usuario.
     * @return mixed
     */
    public function actionTrayectosPublicados()
    {
        $usuario = Yii::$app->user->identity;
        $trayectos = Trayectos::find()
            ->where(['conductor' => $usuario->id])
            ->orderBy(['fecha' => SORT_ASC])->all();

        return $this->render('trayectos_publicados', [
            'trayectos' => $trayectos,
            'usuario' => $usuario,
        ]);
    }

    /**
     * Crea un nuevo modelo de Trayectos.
     * @return mixed
     */
    public function actionPublicar()
    {
        $model = new Trayectos();
        $model->conductor = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'El trayecto se ha publicado correctamente.');
            return $this->goHome();
        }

        return $this->render('publicar', [
            'model' => $model,
        ]);
    }

    /**
     * Modifica un modelo de Trayectos.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException Si no encuentra el modelo
     */
    public function actionModificar($id)
    {
        $model = $this->findModel($id);

        if ($model->conductor !== Yii::$app->user->id) {
            throw new NotFoundHttpException('No tienes permisos para modificar este trayecto.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'El trayecto se ha modificado correctamente.');
            return $this->redirect(['trayectos/trayectos-publicados']);
        }

        return $this->render('modificar', [
            'model' => $model,
        ]);
    }

    /**
     * Elimina un modelo de Trayectos.
     * @return mixed
     * @param mixed $id
     */
    public function actionEliminar($id)
    {
        if (($model = Trayectos::findOne($id)) === null) {
            throw new NotFoundHttpException('El trayecto no existe');
        }
        $model->delete();
        Yii::$app->session->setFlash('success', 'El trayecto ha sido eliminado correctamente.');
        return $this->redirect(['/trayectos/trayectos-publicados']);
    }

    public function actionMasPlazaAjax()
    {
        if (($id = Yii::$app->request->post('id')) === null) {
            throw new NotFoundHttpException('Falta el id del trayecto.');
        }

        if (($trayecto = Trayectos::findOne($id)) === null) {
            throw new NotFoundHttpException('El trayecto no existe.');
        }

        $trayecto->plazas += 1;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($trayecto->save()) {
            return $trayecto->plazas;
        }
        return 0;
    }

    public function actionMenosPlazaAjax()
    {
        if (($id = Yii::$app->request->post('id')) === null) {
            throw new NotFoundHttpException('Falta el id del trayecto.');
        }

        if (($trayecto = Trayectos::findOne($id)) === null) {
            throw new NotFoundHttpException('El trayecto no existe.');
        }

        $trayecto->plazas -= 1;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($trayecto->save()) {
            return $trayecto->plazas;
        }
        return 0;
    }

    /**
     * Finds the Trayectos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Trayectos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trayectos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
