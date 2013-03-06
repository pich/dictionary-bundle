<?php
namespace Webit\Common\DictionaryBundle\Command;

use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryProviderInterface;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class DictionaryListCommand extends ContainerAwareCommand {
	/**
	 * 
	 * @var DictionaryProviderInterface
	 */
	private $provider;
	
	protected function configure() {
		parent::configure();
		$this->setName('webit:dictionary:list')
		->setDescription('List registered dictionaries');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Symfony\Component\Console\Command.Command::initialize()
	 */
	protected function initialize(InputInterface $input, OutputInterface $output) {
		$this->provider = $this->getContainer()->get('webit_common_dictionary.dictionary_provider');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output) {
		foreach($this->provider->getDictionaries() as $dictionaryName => $dictionary) {
			$output->writeln('Dictionary <info>'.$dictionaryName.'</info> is maneged by <info>'.get_class($dictionary).'</info>');
		}
	}
}
?>
