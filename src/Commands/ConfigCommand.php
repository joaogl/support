<?php namespace jlourenco\support\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use File;
use jlourenco\support\Helpers\FileLoader;
use Setting;
use Schema;

class ConfigCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'jlourenco:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to setup all the configurations for the jlourenco packages';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        if (!$this->confirm('Running this command will reset all jlourenco config files. Are you sure? '))
        {
            $this->info('Command was aborted by the user.');
            return;
        }

        $this->compileConfigFiles();
        // $this->checkSentinelConfigFiles();

        $this->info('Command ran successfully');
    }

    private function compileConfigFiles()
    {
        $path = base_path('/config');
        $mainFile = $path . '/jlourenco.php';
        $fileExists = file_exists($mainFile);

        $files = array_filter(scandir($path), function ($var) {
            return (!(stripos($var, 'jlourenco.') === false) && $var != 'jlourenco.php');
        });

        if ($fileExists)
            unlink($mainFile);

        touch($mainFile);

        $content = "<?php\n";
        $content .= "return [\n\n";

        foreach ($files as $file)
        {
            $in = fopen($path . '/' . $file, "r");

            while ($line = fgets($in))
            {
                if ((stripos($line, '<?php') === false) && (stripos($line, '];') === false) && (stripos($line, 'return [') === false))
                    $content .= $line;
            }

            fclose($in);

            unlink($path . '/' . $file);
        }

        $content .= "];\n";

        $bytesWritten = File::append($mainFile, $content);

        if ($bytesWritten === false)
            $this->info('Couldn\'t write to config file.');

        $this->info('Config files compiled');
    }

    private function checkSentinelConfigFiles()
    {
        Setting::set('cartalyst.sentinel.users.model', 'jlourenco\base\Models\BaseUser');
        Setting::set('cartalyst.sentinel.roles.model', 'jlourenco\base\Models\Group');

        /*
        $l = new FileLoader(
            new \Illuminate\Filesystem\Filesystem(),
            base_path().'/config/cartalyst.sentinel.php'
        );

        $conf = ['' => ''];
        $conf2 = ['cartalyst.sentinel.roles.model' => 'jlourenco\base\Models\Group'];

        $l->save($conf, '', 'cartalyst.sentinel');
        */
    }

}
