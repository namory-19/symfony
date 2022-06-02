<?php

namespace App\Command;

use App\Repository\DealRepository;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'deal:price:increase',
    description: 'This command allow increase the price',
)]
class DealPriceIncreaseCommand extends Command
{
    private DealRepository $dealRepository;

    public function __construct(DealRepository $dealRepository)
    {
        $this->dealRepository = $dealRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('price', InputArgument::REQUIRED, 'Value for price')
            ->addOption('id', null, InputOption::VALUE_REQUIRED, 'increase the value id price')
            ->addOption('all', null, InputOption::VALUE_NONE, 'increase all prices');
    }

    /**
     * @throws Exception
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('id') && $input->getOption('all')) {
            throw new Exception('You cannot use the command id and all in the same time');
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        if ($input->getOption('id')) {
            $deal = $this->dealRepository->find($input->getOption('id'));
            if (!$deal) {
                $io->error('no deal find');
                return Command::FAILURE;
            }

            $oldPrice = $deal->getPrice();
            $deal->setPrice($oldPrice + $input->getArgument('price'));
            $this->dealRepository->add($deal, true);
            $io->success("deal {$deal->getId()} : price updated. Old price : {$oldPrice}. New Price : {$deal->getPrice()}");
        } elseif ($input->getOption('all')) {
            $deals = $this->dealRepository->findAll();
            $table = new Table($output);
            $table->setHeaders(array('ID', 'Old Price', 'New Price'));

            foreach ($deals as $deal) {
                $oldPrice = $deal->getPrice();
                $deal->setPrice($oldPrice + $input->getArgument('price'));
                $table->addRow(array($deal->getId(), $oldPrice, $deal->getPrice()));
                $this->dealRepository->add($deal, true);
            }

            $table->render();
            $io->success('Deals prices had been updated successfully.');
        } else {
            $io->error('You must use --id={value} or --all');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
