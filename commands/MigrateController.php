<?php

namespace application\commands;

use application\models\Defines;
use yii\console\controllers\MigrateController as BaseMigrateController;
use yii;

class MigrateController extends BaseMigrateController
{

    private $baseMigrationPath;

    /**
     * Module name to perform migration for
     *
     * @var string
     */
    public string $migrationModule = '';

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return array_merge(
            parent::options($actionID),
            ['migrationModule']
        );
    }

    /**
     * @inheritdoc
     */
    public function optionAliases()
    {
        return array_merge(
            parent::optionAliases(),
            [
                'm' => 'migrationModule',
            ]
        );
    }

    /**
     * Returns migration base path using input parameters
     *
     * @return string
     */
    public function getMigrationBasePath()
    {
        if (yii::$app->hasModule($this->migrationModule)) {
            /** @var yii\base\Module $module */
            $module = yii::$app->getModule($this->migrationModule);
            $path = $module->getBasePath() . DIRECTORY_SEPARATOR . 'migrations';
        } else {
            $path = $this->migrationPath;
            if (is_array($path)) {
                $path = $path[0];
            }
        }

        return $path;
    }

    /**
     * Executes specific business logic before action
     *
     * @param $action
     *
     * @return bool
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->baseMigrationPath = $this->migrationPath;
            $path = $this->getMigrationBasePath();
            if ('create' == $action->id) {
                if (yii::$app->hasModule($this->migrationModule)) {
                    /** @var yii\base\Module $module */
                    $module = yii::$app->getModule($this->migrationModule);
                    $path .= DIRECTORY_SEPARATOR . $module->getVersion();
                } else {
                    $path .= DIRECTORY_SEPARATOR . Defines\Api::VERSION;
                }
            }
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $this->migrationPath = $path;

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    protected function getNewMigrations()
    {
        $applied = [];
        foreach ($this->getMigrationHistory(-1) as $version => $time) {
            $pos = strrpos($version, DIRECTORY_SEPARATOR);
            $ver = $pos !== false ? substr($version, $pos + 1) : $version;
            $applied[$ver] = true;
        }

        $migrations = [];
        $this->processMigrationFolder($this->migrationPath, $migrations, $applied);

        sort($migrations);

        return $migrations;
    }

    /**
     * Recursive method for searching new migrations
     *
     * @param $folder
     * @param $migrations
     * @param $applied
     */
    private function processMigrationFolder($folder, &$migrations, $applied, $version = '')
    {
        $handle = opendir($folder);
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $folder . DIRECTORY_SEPARATOR . $file;

            if (is_dir($path)) {
                $this->processMigrationFolder($path, $migrations, $applied, $file);
            } elseif (preg_match('/^(m\d{6}_\d{6}_.*?)\.php$/', $file, $matches)
                && is_file($path) && !isset($applied[$matches[1]])
            ) {
                $migrations[] = $version . DIRECTORY_SEPARATOR . $matches[1];
            }
        }
        closedir($handle);
    }

    /**
     * @inheritdoc
     */
    protected function createMigration($class)
    {
        $class = trim($class, DIRECTORY_SEPARATOR);
        if (strpos($class, DIRECTORY_SEPARATOR) !== false) {
            $file = $this->migrationPath . DIRECTORY_SEPARATOR . $class . '.php';
            require_once($file);
        }

        $tmp = explode(DIRECTORY_SEPARATOR, $class);
        $class = array_pop($tmp);

        return new $class();
    }

    /**
     * Retrieves folder of a specified file by file name
     *
     * @param        $fileName
     * @param string $parentFolder
     *
     * @return null|string
     */
    private function getFileFolder($fileName, $parentFolder = '')
    {
        $folder = null;

        $folderPath = $this->migrationPath . $parentFolder . DIRECTORY_SEPARATOR;
        if (is_file($folderPath . $fileName)) {
            return $parentFolder;
        }

        $handle = opendir($folderPath);
        while ($file = readdir($handle)) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $path = $folderPath . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)
                && ($folder = $this->getFileFolder($fileName, $parentFolder . DIRECTORY_SEPARATOR . $file)) !== null
            ) {
                break;
            }
        }
        closedir($handle);

        return $folder;
    }

    /**
     * Retrieves migration template content
     *
     * @return string
     */
    protected function getTemplate()
    {
        return <<<TPL
<?php

use application\components\ExtendedCDbMigration;

class {ClassName} extends ExtendedCDbMigration
{
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "{ClassName} does not support migration down.\\n";
        return false;
    }
}
TPL;
    }
}
