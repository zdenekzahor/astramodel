<?php
declare(strict_types=1);

namespace ZdenekZahor\Astramodel\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ProductCommand extends Command {

	/** @var string */
	private const NAME = 'product';

	/** @var string */
	private const ARG__URl = 'url';

	/** @var string */
	private const OPT__ONLY_COUNT = 'only-count';

	/** @var string */
	private const OPT__ONLY_NAME = 'only-name';

	protected function configure(): void {
		$this->setName(self::NAME);

		$this->setDescription('Load and show products from zipped XML file');

		$this->addArgument(self::ARG__URl, InputArgument::REQUIRED, 'URL of zipped XML file');

		$this->addOption(self::OPT__ONLY_COUNT, null, InputOption::VALUE_OPTIONAL, 'Show only product count', false);
		$this->addOption(self::OPT__ONLY_NAME, null, InputOption::VALUE_OPTIONAL, 'Show only product names', true);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int {
		$url = (string)$input->getArgument(self::ARG__URl);

		$onlyProductCountOptionValue = $input->getOption(self::OPT__ONLY_COUNT);
		if (false === $onlyProductCountOptionValue) {
			$onlyProductCount = false;
		} elseif (null === $onlyProductCountOptionValue) {
			$onlyProductCount = true;
		} else {
			$output->writeln('Wrong usage of "--' . self::OPT__ONLY_COUNT . '" option');
			return 1;
		}

		$onlyProductNameOptionValue = $input->getOption(self::OPT__ONLY_NAME);
		if (true === $onlyProductNameOptionValue) {
			$onlyProductName = true;
		} elseif (null === $onlyProductNameOptionValue) {
			$onlyProductName = false;
		} else {
			$output->writeln('Wrong usage of "--' . self::OPT__ONLY_NAME . '" option');
			return 1;
		}

		$returnCode = 0;
		return $returnCode;
	}
}
