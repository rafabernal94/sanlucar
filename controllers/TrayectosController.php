<?php

namespace app\controllers;

use app\models\Preferencias;
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
        $trayectosAct = Trayectos::find()
            ->where(['conductor_id' => $usuario->id])
            ->andWhere('fecha >= now()')
            ->orderBy(['fecha' => SORT_ASC])->all();

        $trayectosPas = Trayectos::find()
            ->where(['conductor_id' => $usuario->id])
            ->andWhere('fecha < now()')
            ->orderBy(['fecha' => SORT_ASC])->all();

        return $this->render('trayectos_publicados', [
            'trayectosAct' => $trayectosAct,
            'trayectosPas' => $trayectosPas,
            'usuario' => $usuario,
        ]);
    }

    /**
     * Displays a single Usuarios model.
     * @param  int   $id
     * @return mixed
     */
    public function actionDetalles($id)
    {
        $model = $this->findModel($id);
        $conductor = $model->conductor->usuario;
        $pref = $model->preferencias;
        return $this->render('detalles', [
            'model' => $model,
            'conductor' => $conductor,
            'pref' => $pref,
        ]);
    }

    /**
     * Crea un nuevo modelo de Trayectos.
     * @return mixed
     */
    public function actionPublicar()
    {
        $model = new Trayectos();
        $model->conductor_id = Yii::$app->user->id;

        $pref = new Preferencias();
        $pref->musica = true;
        $pref->ninos = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $pref->trayecto_id = $model->id;
            if ($pref->load(Yii::$app->request->post()) && $pref->save()) {
                Yii::$app->session->setFlash('success', 'El trayecto se ha publicado correctamente.');
                return $this->redirect(['trayectos/trayectos-publicados']);
            }
        }

        return $this->render('publicar', [
            'model' => $model,
            'pref' => $pref,
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
        $pref = $model->preferencias;

        if ($model->conductor_id !== Yii::$app->user->id) {
            throw new NotFoundHttpException('No tienes permisos para modificar este trayecto.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($pref->load(Yii::$app->request->post()) && $pref->save()) {
                Yii::$app->session->setFlash('success', 'El trayecto se ha modificado correctamente.');
                return $this->redirect(['trayectos/trayectos-publicados']);
            }
        }

        return $this->render('modificar', [
            'model' => $model,
            'pref' => $pref,
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
        if (($pref = $model->preferencias) === null) {
            throw new NotFoundHttpException('Las preferencias de este trayecto no existen');
        }
        $pref->delete();
        $model->delete();
        Yii::$app->session->setFlash('success', 'El trayecto ha sido eliminado correctamente.');
        return $this->redirect(['/trayectos/trayectos-publicados']);
    }

    /**
     * Permite modificar las plazas de un trayecto mediante Ajax.
     * @return int El número de plazas disponibles
     */
    public function actionModificarPlazasAjax()
    {
        if (($idTrayecto = Yii::$app->request->post('idTrayecto')) === null) {
            throw new NotFoundHttpException('Falta el id del trayecto.');
        }

        if (($idBtn = Yii::$app->request->post('idBtn')) === null) {
            throw new NotFoundHttpException('Falta el id del botón.');
        }

        if (($trayecto = Trayectos::findOne($idTrayecto)) === null) {
            throw new NotFoundHttpException('El trayecto no existe.');
        }

        substr($idBtn, 0, 6) === 'btnMas' ? $trayecto->plazas += 1 : $trayecto->plazas -= 1;

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
