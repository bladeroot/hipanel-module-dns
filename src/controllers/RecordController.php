<?php

namespace hipanel\modules\dns\controllers;

use hipanel\modules\dns\models\Zone;
use hiqdev\hiart\Collection;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class RecordController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
            ],
            'validate-form' => [
                'class' => 'hipanel\actions\ValidateFormAction',
            ],
        ];
    }

    public function actionCreate()
    {
        $collection = (new Collection([
            'model' => $this->newModel(['scenario' => 'create'])
        ]))->load();

        if ($collection->count() && $collection->save()) {
            return $this->renderZoneView($collection->first->hdomain_id);
        } elseif ($id = $collection->first->hdomain_id) {
            return $this->redirect(['@dns/zone/view', 'id' => $id]);
        }

        throw new BadRequestHttpException('Bad request');
    }

    public function actionUpdate($id = null, $hdomain_id = null) {
        if ($id && $hdomain_id && $model = $this->newModel()->findOne(compact('id', 'hdomain_id'))) {
            $model->scenario = 'update';
            return $this->renderAjax('update', ['model' => $model]);
        }

        $collection = (new Collection([
            'model' => $this->newModel(['scenario' => 'update'])
        ]))->load();

        if ($collection->first->id && $collection->save()) {
            return $this->renderZoneView($collection->first->hdomain_id);
        }
        throw new BadRequestHttpException('Bad request123');
    }

    public function actionDelete()
    {
        $collection = (new Collection([
            'model' => $this->newModel(['scenario' => 'delete'])
        ]))->load();

        if ($collection->validate() && $collection->save()) {
            return $this->renderZoneView($collection->first->hdomain_id);
        } elseif ($id = $collection->first->hdomain_id) {
            return $this->redirect(['@dns/zone/view', 'id' => $id]);
        }

        throw new BadRequestHttpException('Bad request');
    }

    public function renderZoneView($id) {
        $model = Zone::find()->joinWith('records')->where(['id' => $id])->one();
        $recordsDataProvider = new ArrayDataProvider(['allModels' => $model->records]);

        return $this->render('/zone/view', [
            'model' => $model,
            'recordsDataProvider' => $recordsDataProvider
        ]);
    }
}