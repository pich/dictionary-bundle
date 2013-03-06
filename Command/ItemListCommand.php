<?php
namespace Webit\Common\DictionaryBundle\Command;

use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryProviderInterface;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ItemListCommand extends ContainerAwareCommand {
	/**
	 * 
	 * @var DictionaryProviderInterface
	 */
	private $provider;
	
	protected function configure() {
		parent::configure();
		$this->setName('webit:dictionary:items')
		->addArgument('dictionary',InputArgument::REQUIRED)
		->setDescription('List dictionary items');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Symfony\Component\Console\Command.Command::initialize()
	 */
	protected function initialize(InputInterface $input, OutputInterface $output) {
		$this->provider = $this->getContainer()->get('webit_common_dictionary.dictionary_provider');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output) {
		$dictionaryName = $input->getArgument('dictionary');
		$dictionary = $this->provider->getDictionary($dictionaryName);
		$output->writeln('Items of <info>'.$dictionaryName.'</info> dictionary:');
		foreach($dictionary->getItems() as $item) {
			$output->writeln("\t".'<info>'.$item->getCode().'</info> => <info>'.(string)$item.'</info>');
		}
	}
}
?>
