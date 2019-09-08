<?php

namespace App\Shell;
use App\Controller\HomeController;
use Cake\Console\Shell;
class TestShell extends Shell
{
public function main(){
$Users = new HomeController();
$Users->getCsv('myfile');
}
}