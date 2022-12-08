<?php
class Shape
{
  public $data1;
  public $data2;
  public $data3;
  public $data4;
  public $data5;
  public function toString(): string
  {
    return sprintf('%d,%d,%d,%d,%d', $this->data1, $this->data2, $this->data3, $this->data4, $this->data5);
  }
}


// Модули
require_once getFileUnderRoot('vendor/autoload.php');
require_once getFileUnderRoot('jpgraph/jpgraph.php');
require_once getFileUnderRoot('jpgraph/jpgraph_line.php');
require_once getFileUnderRoot('jpgraph/jpgraph_bar.php');
require_once getFileUnderRoot('jpgraph/jpgraph_pie.php');
use Nelmio\Alice\Loader\NativeLoader as AliceFixtures;

/**
 * @suppress PHP0413
 */
class funAliceFixtures extends AliceFixtures
{
  public function getSeed()
  {
    srand(mktime(0));
    return (rand());
  }
}

/** Игнорирование невидимости
 * @suppress PHP0413
 * @suppress PHP0415
 * @suppress PHP0418
 */
class graphModel extends baseModel
{
  // Размеры изображений
  protected $width = 500;
  protected $height = 500;
  protected $graphs_num = 25;
  public function generateImages()
  {
    // Создание фикстур
    $fixtures = $this->generateFixtures();
    $encodedImages = array();
    foreach ($fixtures as $i => $fixture) {
      // Чередование
      preg_match('/(\d+)$/', $i, $graphType);
      $graphType = $graphType[0] % 3;
      // Изображение
      $image = $this->addWatermark($this->createGraphImage($graphType, $fixture));
      // Преобразование изображения в base64
      array_push($encodedImages, 'data:image/png;base64,' . base64_encode($image));
    }
    return $encodedImages;
  }
  protected function generateFixtures()
  {
    $objNames = 'fixture{1..' . $this->graphs_num . '}';
    $loader = new funAliceFixtures(); // Случайные графики
    //$loader = new AliceFixtures();
    $objectSet = $loader->loadData([
      Shape::class => [
        $objNames => [
          'data1' => '<numberBetween(100, 750)>',
          'data2' => '<numberBetween(100, 750)>',
          'data3' => '<numberBetween(100, 750)>',
          'data4' => '<numberBetween(100, 750)>',
          'data5' => '<numberBetween(100, 750)>'
        ],
      ]
    ]);
    $fixtures = $objectSet->getObjects();
    return $fixtures;
  }

  protected function plotType(int $type, $data)
  {
    return match ($type) {
      0 => new PiePlot($data),
      1 => new BarPlot($data),
      2 => new LinePlot($data)
    };
  }

  function createGraphImage($graphType, $fixture)
  {
    // Данные фикстуры
    $data = explode(',', $fixture->toString());
    if ($graphType != 0) {
      // Холст
      $graph = new Graph($this->width, $this->height);
      $graph->SetScale('intint');
      // Заголовки
      $graph->title->Set(($graphType == 1 ? 'BAR' : 'LINEAR') . ' GRAPH');
      $graph->xaxis->title->Set('X');
      $graph->yaxis->title->Set('Y');
      // Добавить линию/столб на холст
      $graph->Add($this->plotType($graphType, $data));
    } else {
      // Холст
      $graph = new PieGraph($this->width, $this->height);
      // Заголовки
      $graph->title->Set("PIE GRAPH");
      // Добавить диаграмму на холст
      $pie = $this->plotType($graphType, $data);
      $graph->Add($pie);
      // Цвета
      $pie->SetSliceColors(array('#FF0000', '#00FF00', '#0000FF', '#FF00FF', '#00FFFF'));
    }
    $graph->img->SetImgFormat('png');
    return $graph->Stroke(_IMG_HANDLER);
  }

  protected function addWatermark($image)
  {
    $stamp = imagecreatefrompng(getFileFromRoot('/graph/_watermark.png'));
    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);
    // Подстроить размер под фото
    $stamp = imagescale($stamp, $imageWidth, $imageHeight);
    $stampWidth = imagesx($stamp);
    $stampHeight = imagesy($stamp);
    imagecopy(
      // Исходники
      $image,
      $stamp,
        // Старт на изображении - всегда в центре
      ($imageWidth - $stampWidth) / 2,
      ($imageHeight - $stampHeight) / 2,
      // Старт вотермарка - отображать полностью
      0,
      0,
      // Длина ширина штампа - отображать полностью
      $stampWidth,
      $stampHeight
    );
    // Захват потока
    ob_start();
    // Создание потока
    imagepng($image);
    // Сохранение потока
    $rawImageBytes = ob_get_clean();
    // Очистка потока из памяти
    imagedestroy($image);
    // Возврат сохраненного потока
    return $rawImageBytes;
  }
}
?>