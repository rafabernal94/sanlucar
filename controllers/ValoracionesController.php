<?php

namespace app\controllers;

use app\models\Usuarios;
use app\models\Valoraciones;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ValoracionesController implements the CRUD actions for Valoraciones model.
 */
class ValoracionesController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'valoraciones',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'valoraciones',
                        ],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Creates a new Valoraciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @param null|mixed $valorado
     */
    public function actionCrear($valorado = null)
    {
        $idAct = Yii::$app->user->id;
        $model = new Valoraciones();

        if ($valorado !== null) {
            if (Usuarios::findOne($valorado) === null) {
                throw new NotFoundHttpException('El usuario a valorar no existe.');
            }
            $model->valorado_id = $valorado;
        }
        $model->valorador_id = $idAct;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Has valorado al usuario correctamente.');
            return $this->redirect(['valoraciones', 'id' => $valorado]);
        }

        return $this->renderAjax('crear', [
            'model' => $model,
        ]);
    }

    /**
     * Lista las valoraciones de un determinado usuario.
     * @param  int $id ID del usuario
     * @return mixed
     */
    public function actionValoraciones($id)
    {
        if ($id === null) {
            throw new NotFoundHttpException('Falta el id.');
        }
        if (($usuario = Usuarios::findOne($id)) === null) {
            throw new NotFoundHttpException('No existe el usuario.');
        }
        $valoraciones = Valoraciones::find()
            ->where(['valorado_id' => $usuario->id])
            ->orderBy(['created_at' => SORT_ASC])->all();

        return $this->render('valoraciones', [
            'valoraciones' => $valoraciones,
            'usuario' => $usuario,
        ]);
    }

    /**
     * Finds the Valoraciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Valoraciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Valoraciones::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
