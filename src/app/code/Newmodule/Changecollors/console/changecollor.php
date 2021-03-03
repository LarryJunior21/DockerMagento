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
            $storeManager = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Store\Model\StoreManagerInterface::class);

            $ST = $storeManager->getStore($store);

            $array = [];
            $array['button__color'] = '#'.$color;
            $array['button__background'] ='#'.$color;

            try {
                $om = \Magento\Framework\App\ObjectManager::getInstance();
                $filesystem = $om->get('Magento\Framework\Filesystem');
                $directoryList = $om->get('Magento\Framework\App\Filesystem\DirectoryList');
                $media = $filesystem->getDirectoryWrite($directoryList::MEDIA);
                $contents = "ddddddddddddddddddddddddddd";
                $media->writeFile("module1/sample.txt",$contents);
            } catch(Exception $e) {
                echo $e->getMessage();
            }


        }
    }

}
