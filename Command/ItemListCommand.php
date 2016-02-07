<?php
namespace Webit\Common\DictionaryBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryProviderInterface;

class ItemListCommand extends ContainerAwareCommand
{
    /**
     * @var DictionaryProviderInterface
     */
    private $provider;

    protected function configure()
    {
        parent::configure();
        $this->setName('webit:dictionary:items')
            ->addArgument('dictionary', InputArgument::REQUIRED)
            ->setDescription('List dictionary items');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->provider = $this->getContainer()->get('webit_common_dictionary.dictionary_provider');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dictionaryName = $input->getArgument('dictionary');
        $dictionary = $this->provider->getDictionary($dictionaryName);
        $output->writeln(
            sprintf('Items of <info>%s</info> dictionary:', $dictionaryName)
        );

        foreach ($dictionary->getItems() as $item) {
            $output->writeln(
                sprintf("\t<info>%s</info> => <info>%s</info>", $item->getCode(), (string) $item)
            );
        }
    }
}
