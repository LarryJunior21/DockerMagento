<?php
namespace Newmodule\Changecollors\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Store\Api\StoreRepositoryInterface as Repository;

/**
 * Class Changecollor
 * @package Newmodule\Changecollors\Console
 */
class Changecollor extends Command
{
    const COLOR = 'hex';
    const STORE = 'storeid';

    private function getStoreData(){
        /** @var Repository $repository */
        $storeManagerDataList = $this->$repository->getStores();
        $options = array();

        foreach ($storeManagerDataList as $key => $value) {
            $options[] = ['label' => $value['name'].' - '.$value['code'], 'value' => $key];
        }
        return $options;
    }

    protected function configure()
    {
        $options = [
            new InputOption(
                self::COLOR,
                null,
                InputOption::VALUE_REQUIRED,
                'hex'
            ),
            new InputOption(
                self::STORE,
                null,
                InputOption::VALUE_REQUIRED,
                'storeId'
            ),
        ];

        $this->setName('color:change');
        $this->setDescription('This is a command to change
                                default button colors of magento 2 theme.');
        $this->setDefinition($options);

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Since it requires a VALUE_REQUIRED to come to execute() I will no put an if
        //To verify if $color or $store are inputted

        try {
            $color = $input->getOption(self::COLOR);
            $store = $input->getOption(self::STORE);

            $m = "";

            ctype_xdigit($color) ? (
                is_numeric($store) ? "" :
                    $m = 'storeid must be numeric'
            ) : $m = 'hex must an hex value';

            if(!empty($m))
                $output->writeln($m);
            else {
                $output->writeln($this->getStoreData()['label']);
            }
        } catch (\Exception $e) {
            $output->writeln($e);
        }
    }
}
