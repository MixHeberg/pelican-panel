<?php

namespace Pterodactyl\Console\Commands\Node;

use Pterodactyl\Models\Node;
use Illuminate\Console\Command;

class NodeConfigurationCommand extends Command
{
    protected $signature = 'p:node:configuration
                            {node : The ID or UUID of the node to return the configuration for.}
                            {--format=yaml : The output format. Options are "yaml" and "json".}';

    protected $description = 'Displays the configuration for the specified node.';

    public function handle()
    {
        /** @var \Pterodactyl\Models\Node $node */
        $node = Node::query()->findOrFail($this->argument('node'));

        $format = $this->option('format');
        if (!in_array($format, ['yaml', 'yml', 'json'])) {
            $this->error('Invalid format specified. Valid options are "yaml" and "json".');

            return 1;
        }

        if ($format === 'json') {
            $this->output->write($node->getJsonConfiguration(true));
        } else {
            $this->output->write($node->getYamlConfiguration());
        }

        $this->output->newLine();

        return 0;
    }
}
