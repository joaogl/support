<?php namespace jlourenco\support\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use File;
use jlourenco\support\Helpers\FileLoader;
use Setting;
use Schema;

class MigrateCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'jlourenco:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to setup all the migrations for the jlourenco packages';

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
        if (!$this->confirm('Running this command will deleted the sentinel users table and add some default data to the jlourenco tables. Are you sure? '))
        {
            $this->info('Command was aborted by the user.');
            return;
        }

        Schema::dropIfExists('users');
        $this->addData();

        $this->info('Command ran successfully');
    }

    private function addData()
    {

    }

}
