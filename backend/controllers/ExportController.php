<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;
use common\models\MessageBoard;
use common\models\ImageResource;
use common\models\HeroInfo;

class ExportController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [ 'allow' => true, 'roles' => ['admin'] ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDownload($type)
    {
        $type = trim((string)$type);
        $csv = ""; $filename = 'export_' . $type . '_' . date('Ymd_His') . '.csv';
        switch ($type) {
            case 'images':
                $csv = $this->exportImages();
                break;
            case 'heroes':
                $csv = $this->exportHeroes();
                break;
            case 'messages':
                $csv = $this->exportMessages();
                break;
            default:
                Yii::$app->session->setFlash('error', '不支持的导出类型');
                return $this->redirect(['index']);
        }

        return Yii::$app->response->sendContentAsFile($csv, $filename, [
            'mimeType' => 'text/csv',
            'inline' => false,
        ]);
    }

    private function exportImages(): string
    {
        // 表结构：img_id (PK), img_url, related_id, img_desc
        $rows = ImageResource::find()->orderBy(['img_id' => SORT_ASC])->limit(10000)->all();
        $out = [ ['img_id','img_url','host','related_id','img_desc'] ];
        foreach ($rows as $r) {
            $url = (string)($r->img_url ?? '');
            $host = $url !== '' ? (parse_url($url, PHP_URL_HOST) ?: '') : '';
            $out[] = [ $r->img_id, $url, $host, $r->related_id ?? '', $r->img_desc ?? '' ];
        }
        return $this->toCsv($out);
    }

    private function exportMessages(): string
    {
        if (!class_exists(MessageBoard::class)) return $this->toCsv([["error" => "MessageBoard 模型不存在"]]);
        $rows = MessageBoard::find()->orderBy(['msg_time' => SORT_ASC])->limit(10000)->all();
        $out = [ ['id','nickname','content','msg_time'] ];
        foreach ($rows as $r) {
            $id = '';
            if (method_exists($r, 'hasAttribute')) {
                if ($r->hasAttribute('id')) $id = (string)$r->getAttribute('id');
                elseif ($r->hasAttribute('msg_id')) $id = (string)$r->getAttribute('msg_id');
            }
            $content = preg_replace("/[\r\n]+/"," ", (string)($r->content ?? ''));
            $out[] = [ $id, $r->nickname ?? '', $content, $r->msg_time ?? '' ];
        }
        return $this->toCsv($out);
    }
    

    private function toCsv(array $rows): string
    {
        $fh = fopen('php://temp', 'r+');
        foreach ($rows as $row) {
            fputcsv($fh, $row);
        }
        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);
        return $csv ?: '';
    }
}
