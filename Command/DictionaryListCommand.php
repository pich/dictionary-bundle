<?php
namespace Webit\Common\DictionaryBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryProviderInterface;

class DictionaryListCommand extends ContainerAwareCommand
{
    /**
     * @var DictionaryProviderInterface
     */
    private $provider;

    protected function configure()
    {
        $this->setName('webit:dictionary:list')
            ->setDescription('List registered dictionaries');
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
        foreach ($this->provider->getDictionaries() as $dictionaryName => $dictionary) {
            $output->writeln(
                sprintf(
                    'Dictionary <info>%s</info>info is managed by <info>%s</info>',
                    $dictionaryName,
                    get_class($dictionary)
                )
            );
        }
    }
}
