<?php

namespace Wealthbot\RiaBundle\Service\Manager;

use Doctrine\ORM\EntityManager;
use Wealthbot\ClientBundle\Entity\Bill;
use Wealthbot\ClientBundle\Entity\ClientAccount;
use Wealthbot\ClientBundle\Entity\SystemAccount;
use Wealthbot\ClientBundle\Entity\BillItem;
use Wealthbot\ClientBundle\Repository\ClientAccountRepository;
use Wealthbot\UserBundle\Entity\Profile;
use Wealthbot\AdminBundle\Manager\FeeManager;

class BillingReportManager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var \Wealthbot\RiaBundle\Service\Manager\SummaryInformationManager
     */
    protected $summaryInformationManager;

    /**
     * @var \Wealthbot\AdminBundle\Manager\FeeManager
     */
    protected $feeManager;

    /**
     * @var PeriodManager
     */
    protected $periodManager;

    /**
     * @param EntityManager $em
     * @param \Twig_Environment $twig
     * @param SummaryInformationManager $summaryInformationManager
     * @param FeeManager $feeManager
     * @param PeriodManager $periodManager
     */
    public function __construct(EntityManager $em, \Twig_Environment $twig, SummaryInformationManager $summaryInformationManager, FeeManager $feeManager, PeriodManager $periodManager)
    {
        $this->em = $em;
        $this->twig = $twig;
        $this->summaryInformationManager = $summaryInformationManager;
        $this->feeManager = $feeManager;
        $this->periodManager = $periodManager;
    }

    /**
     * @param $sheet
     * @param array $params
     * @return mixed
     */
    protected function setHeader($sheet, array $params)
    {
        $fontSize = 10;
        $fontName = 'Calibri';

        // Table header
        $table = array(
            "Client Last Name",
            "Client First Name",
            "Account Type",
            "Account Number",
            "Billing Schedule",
            "Custodied/Held Away",
            "Average Account Value",
            "Days in Portfolio",
            "wealthbot.io' Fee",
            "{$params['ria_name']} Fee",
            "Final Fee"
        );

        $column = 'A';
        foreach ($table as $val) {
            $sheet->setCellValue("{$column}7", $val);
            $sheet->getColumnDimension($column)->setAutoSize(true);
            $column++;
        }

        // Set font style
        $font = $sheet->getStyle("A7:{$column}7")->getFont();
        $font->setName($fontName)->setSize($fontSize);
        $font->setBold(true);

        $header = array(
            'Company Name',
            'Billing Period Start',
            'Billing Period End',
            'Days in Period',
            'Primary Custodian'
        );

        $index = 1;
        foreach ($header as $val) {
            $sheet->setCellValue("A{$index}", $val);

            $value = str_replace(' ', '_', strtolower($val));
            $sheet->setCellValue("B{$index}", isset($params[$value]) ? $params[$value] : '');

            // Set background
            $sheet->getStyle("A{$index}:K{$index}")->getFill()->applyFromArray(array('type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'CCFFCC')));

            // Set text align to left
            $sheet->getStyle("B{$index}")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            // Set font style
            $font = $sheet->getStyle("A{$index}")->getFont();
            $font->setName($fontName)->setSize($fontSize);
            $font->setBold(true);

            $font = $sheet->getStyle("B{$index}")->getFont();
            $font->setName($fontName)->setSize($fontSize);

            $index++;
        }

        return $sheet;
    }

    /**
     * @param $sheet
     * @param $ria
     * @param $clients
     * @param $year
     * @param $quarter
     * @return mixed
     */
    protected function billTable($sheet, $ria, $clients, $year, $quarter)
    {
        $index = 9;

        // Set table head background
        $sheet->getStyle("A{$index}:K{$index}")->getFill()->applyFromArray(array('type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => '8EB4E3')));

        $totals = "";
        $totalCell = "K{$index}";

        foreach ($clients as $client) {
            // Get client accounts
            $clientAccounts = $this->summaryInformationManager->getAccountsInformationByClient($client, $year, $quarter);
            foreach ($clientAccounts as $account) {
                $index++;

                $clientAccount = $this->em->getRepository('WealthbotClientBundle:ClientAccount')->find($account['id']);
                $billItem = $this->em->getRepository('WealthbotClientBundle:BillItem')->getByAccountAndPeriod($clientAccount, $year, $quarter);

                $sheet->setCellValue("A{$index}", $client->getLastName());
                $sheet->setCellValue("B{$index}", $client->getFirstName());
                $sheet->setCellValue("C{$index}", SystemAccount::getTypeName($account['type']));
                $sheet->setCellValue("D{$index}", $account['number']);
                $sheet->setCellValue("E{$index}", $client->getFeeShedule());
                $sheet->setCellValue("F{$index}", Profile::getPaymentMethodName($client->getPaymentMethod()));
                $sheet->setCellValue("G{$index}", $account['averageAccountValue']);
                $sheet->setCellValue("H{$index}", $account['daysInPortfolio']);
                $sheet->setCellValue("I{$index}", empty($billItem) ? 0 : $billItem->getAdminFee());
                $sheet->setCellValue("J{$index}", empty($billItem) ? 0 : $billItem->getRiaFee());
                $sheet->setCellValue("K{$index}", "=SUM(I{$index}:J{$index})");

                // Set currency USD format
                $sheet->getStyle("G{$index}")->applyFromArray(array('numberformat' => array('code' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD)));
                $sheet->getStyle("I{$index}:K{$index}")->applyFromArray(array('numberformat' => array('code' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD)));

                $font = $sheet->getStyle("A{$index}:K{$index}")->getFont();
                $font->setName('Arial')->setSize(10);

                // Save total cell
                $totals .= "K{$index},";

                // Set table body background
                $sheet->getStyle("A{$index}:K{$index}")->getFill()->applyFromArray(array('type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'DCE6F2')));
            }
        }

        // Calculate total
        $sheet->setCellValue($totalCell, "=SUM(" . substr($totals, 0, -1) . ")");
        $sheet->getStyle($totalCell)->getFont()->setBold(true);
        $sheet->getStyle($totalCell)->applyFromArray(array('numberformat' => array('code' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD)));

        return $sheet;
    }

    /**
     * Generate billing summary report (format: xlsx)
     *
     * @param $ria
     * @param $client
     * @param null $quarters
     * @return \PHPExcel
     */
    public function generateSummary($ria, $quarters = null)
    {
        $excel = new \PHPExcel();
        $excel->setActiveSheetIndex(0);
        $sheet = $excel->getActiveSheet();

        $index = 0;
        foreach ($quarters as $key => $quarter) {
            $sheet = $excel->createSheet($index);

            $params = array(
                'company_name'          => $ria->getRiaCompanyInformation()->getName(),
                'billing_period_start'  => $quarter['startDate']->format('m/d/Y'),
                'billing_period_end'    => $quarter['endDate']->modify('-1 day')->format('m/d/Y'),
                'days_in_period'        => $quarter['endDate']->diff($quarter['startDate'])->format('%a'),
                'primary_custodian'     => $ria->getRiaCompanyInformation()->getCustodian()->getName(),
                'ria_name'              => $ria->getFullName()
            );

            // Set header
            $sheet = $this->setHeader($sheet, $params);

            $clients = $this
                ->em
                ->getRepository('WealthbotUserBundle:User')
                ->findRiaClientsByDate($ria, $quarter['endDate'])
            ;

            $year = $quarter['startDate']->format('Y');

            // Bill table
            $sheet = $this->billTable($sheet, $ria, $clients, $year, $key);

            $sheet->setTitle("Billing Summary-Q{$key} {$year}");

            $index++;
        }

        return $excel;
    }

    /**
     * @param $ria
     * @param $client
     * @param $accounts
     * @param $year
     * @param $quarter
     * @return string
     */
    public function generateBillPdf($ria, $client, $accounts, $year, $quarter)
    {
        list($accounts, $total) = $this->getAccountsInfo($accounts, $year, $quarter, BillItem::STATUS_BILL_APPROVED);

        return $this->twig->render('WealthbotRiaBundle:Billing/Report:bill_pdf.pdf.twig', array(
            'ria'            => $ria,
            'client'         => $client,
            'clientAccounts' => $accounts,
            'feeTotal'       => $total
        ));
    }

    /**
     * @param $client
     * @param $year
     * @param $quarter
     * @return array
     */
    public function getClientAccounts($client, $year, $quarter, $billItemStatus = null)
    {
        $accounts = $this->em->getRepository('WealthbotClientBundle:ClientAccount')->findByClient($client);

        return $this->getAccountsInfo($accounts, $year, $quarter, $billItemStatus);
    }

    /**
     * @param array $accounts
     * @param $year
     * @param $quarter
     * @param $billItemStatus
     *
     * @return array
     */
    public function getAccountsInfo(array $accounts, $year, $quarter, $billItemStatus = null)
    {
        $data   = array();
        $total  = 0;
        $period = $this->periodManager->getPeriod($year, $quarter);

        foreach ($accounts as $account) {
            $billItem  = $this->em->getRepository('WealthbotClientBundle:BillItem')->getByAccountAndPeriod($account, $year, $quarter);
            $feeBilled = $this->summaryInformationManager->getAccountFeeBilled($account, $year, $quarter);

            $item = array(
                'name'                => $account->getOwnerNames(),
                'type'                => SystemAccount::getTypeName($account->getSystemType()),
                'number'              => $this->summaryInformationManager->getAccountNumber($account),
                'status'              => $this->summaryInformationManager->getAccountStatus($account),
                'averageAccountValue' => $this->summaryInformationManager->getAccountAverageValue($account, $period['startDate'], $period['endDate']),
                'daysInPortfolio'     => $this->summaryInformationManager->getAccountDaysInPortfolio($account, $period['startDate'], $period['endDate']),
                'fee'                 => $feeBilled
            );

            if (!empty($billItemStatus)) {
                if ($billItem && $billItem->getStatus() == $billItemStatus) {
                    $data[] = $item;
                }
            } else {
                $data[] = $item;
            }

            $total += $feeBilled;
        }

        return array($data, $total);
    }

    /**
     * Makes array of ClientAccount which must be used for Custodian Fee File generator.
     *
     * @param $riaUser
     * @param $selectedAccounts
     * @param $year
     * @param $quarter
     *
     * @return array
     * @throws \Exception
     */
    public function getAccountsForCustodianFeeFile($riaUser, $selectedAccounts, $year, $quarter)
    {
        $now = new \DateTime();
        $interval = new \DateInterval('P3D');
        $periods = $this->periodManager->getPeriod($year, $quarter);

        /* @var ClientAccountRepository $clientAccountRepo */
        $clientAccountRepo = $this->em->getRepository('WealthbotClientBundle:ClientAccount');
        $accounts = $clientAccountRepo->filterAccountsForCustodianFeeFile($riaUser, $selectedAccounts, $periods['endDate']);

        $firstAccount = reset($accounts);
        if ($firstAccount) {
            $approveDate = $this->summaryInformationManager->getClientBillApproveDate($firstAccount->getClient(), $year, $quarter);
            if ($now->sub($interval) < $approveDate) {
                throw new \Exception('You must wait 3 days after bill approval in order to create Custodian Fee File');
            }
        }

        return $accounts;
    }

    /**
     * Makes table data for Custodian Fee File
     *
     * @param array $clientAccounts
     * @param $year
     * @param $quarter
     *
     * @return array
     */
    public function getTableDataForCustodianFeeFile(array $clientAccounts, $year, $quarter)
    {
        $tableData = array();
        $accounts = array();

        $accountsInfo = $this->summaryInformationManager->getAccountsInformation($clientAccounts, $year, $quarter);
        foreach ($accountsInfo as $accountInfo) {
            if (!$accountInfo['number']) {
                continue;
            }
            if ($accountInfo['feeBilled'] == 0) {
                continue;
            }

            if ($accountInfo['paysFor']) {
                $accountNumber = $accountInfo['paysFor'];
            }else{
                $accountNumber = $accountInfo['number'];
            }

            if (!isset($accounts[$accountNumber])) {
                $accounts[$accountNumber] = 0;
            }
            $accounts[$accountNumber] += $accountInfo['feeBilled'];
        }

        foreach ($accounts as $number => $sum) {
            $tableData[] = array(
                $number,
                'Q',
                $sum
            );
        }

        return $tableData;
    }

    /**
     * It makes file content data for Custodian Fee File.
     *
     * @param array $accounts
     * @param $year
     * @param $quarter
     *
     * @return string
     */
    public function getCustodianFeeFile(array $accounts, $year, $quarter)
    {
        $tableData = $this->getTableDataForCustodianFeeFile($accounts, $year, $quarter);

        ob_start();
        $f = fopen('php://output', 'w');

        foreach($tableData as $line){
            fputcsv($f, $line, ';', '"');
        }

        fclose($f);
        $data = ob_get_contents();
        ob_end_clean();

        return $data;
    }
}