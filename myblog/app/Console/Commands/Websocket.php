<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class Websocket extends Command
{
    public $server;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:action {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test swoole websocket';

    /**
     * Create a new command instance.
     *
     * @return void
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
    public function handle()
    {
        //
        $arg = $this->getArguments('action');

        $server = new Swoole\WebSocket\Server('0.0.0.0', 9501);

        $server->on('open', function (Swoole\WebSocket\Server $server, $request) {
           echo "server: handshake success with fd{$request->fd}\n";
        });

        $server->start();

//        echo $arg;

    }

    protected function getArguments()
    {
        return array(
            array('action', InputArgument::REQUIRED, 'start|stop|restart'),
        );
    }
}
