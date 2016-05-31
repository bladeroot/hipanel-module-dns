<?php

use hipanel\modules\dns\grid\ZoneGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\IndexLayoutSwitcher;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('hipanel/dns', 'DNS zones');
$this->breadcrumbs[] = $this->title;
$this->subtitle = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');

?>









<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

        <?= $page->setSearchFormData(compact([])) ?>

        <?php $page->beginContent('main-actions') ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('show-actions') ?>
            <?= IndexLayoutSwitcher::widget() ?>
            <?= $page->renderSorter([
                'attributes' => [
                    'client',
                    'domain',
                    'dns_on',
                ],
            ]) ?>
            <?= $page->renderPerPage() ?>
            <?= $page->renderRepresentation() ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('bulk-actions') ?>
            <?= $page->renderBulkButton(Yii::t('hipanel/dns', 'Export DNS records'), Url::to(['@dns/record/export-hosts']))?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= ZoneGridView::widget([
                'boxed' => false,
                'dataProvider' => $dataProvider,
                'filterModel' => $model,
                'columns' => [
                    'checkbox',
                    'client',

                    'domain',
                    'nss',
                    'dns_on',
                    'bound_to',

                    'actions',
                ],
            ]) ?>
        <?php $page->endBulkForm() ?>
        <?php $page->endContent() ?>
    <?php $page->end() ?>
<?php Pjax::end() ?>
