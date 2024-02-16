<?php
/**
 * The base class for simple test cases:
 *  - No Database
 *  - No Controller
 */

namespace application\tests\TestCase;

use PHPUnit\Framework\TestCase;
use yii\base\Controller;

class SimpleTestCase extends TestCase
{

    /**
     * Returns called class file path
     *
     * @return string
     */
    protected function getPath()
    {
        $reflection = new \ReflectionClass($this);

        return dirname($reflection->getFileName());
    }

    protected function getClassName()
    {
        $reflection = new \ReflectionClass($this);

        return $reflection->getShortName();
    }

    /**
     * Returns called class data file full path
     *
     * @param string $fileName data file name
     *
     * @return string
     */
    protected function getDataPath($fileName = '')
    {
        $path = $this->getPath()
            . DIRECTORY_SEPARATOR . '_testData'
            . DIRECTORY_SEPARATOR . $this->getClassName();
        if (empty($fileName)) {
            return $path;
        }

        return $path . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * Returns called class data file data, json decoded if required
     *
     * @param string    $fileName Data file name
     * @param bool|true $decode   Flag indicating weather if json decoding should be applied
     *
     * @return mixed|string
     */
    protected function getData($fileName, $decode = true)
    {
        $data = file_get_contents($this->getDataPath($fileName));
        if ($decode) {
            $data = json_decode($data, true);
        }

        return $data;
    }

    /**
     * Stores called class file data, json encoded
     *
     * @param string    $fileName Data file name
     * @param mixed     $data     Daa to be stored
     * @param bool|true $encode   Flag indicating weather if json encoding should be applied
     *
     * @return mixed|string
     */
    protected function setData($fileName, $data, $encode = true)
    {
        if ($encode) {
            $data = json_encode($data, true);
        }
        file_put_contents($this->getDataPath($fileName), $data);
    }

    public function assertControllerActions(Controller $controller)
    {
        $this->assertTrue(method_exists($controller, 'actions'), "Not found method actions in ".get_class($controller));

        $actions = $controller->actions();
        array_walk($actions, function($action) {

            try {
                $this->assertTrue(class_exists($action), "class $action not exist");
            } catch (\Exception $e) {
                $this->fail($e->getMessage());
            }
        });
    }
}
