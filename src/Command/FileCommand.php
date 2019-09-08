<?php

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

use Cake\I18n\Time;

use App\Controller\HomeController;

class FileCommand extends Command
{	
	public function initialize()
    {
        parent::initialize();
    }

    protected function buildOptionParser(ConsoleOptionParser $parser)
    {
        $parser->addArgument('name', [
            'help' => 'Enter name of the file'
        ]);
        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
        $date = $args->getArgument('name');
        if (empty($args)) {
        	$io->out('Enter filename!');
        } else {
        
	        $something = new HomeController;

			$something->getCsv($date);  
        }

    }

}