<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class TransactionChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(array $transactionData): \ArielMejiaDev\LarapexCharts\BarChart
    {
        return $this->chart->barChart()
            ->setTitle('2024 Transactions')
            ->setSubtitle('')
            ->addData('Repair and Transactions', $transactionData)
            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
    }
}
