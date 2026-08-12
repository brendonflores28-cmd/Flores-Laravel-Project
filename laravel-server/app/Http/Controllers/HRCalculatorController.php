<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HRCalculatorController extends Controller
{
 public function getSalaryInfo($employmentType, $positionTier)
 {
    if($employmentType == "COS")
    {
        return [
                "baseSalary" => 18000,
                "sss" => 0,
                "philhealth" => 0,
                "pagibig" => 0,
        ];
    }
   elseif ($employmentType == "Regular" && $positionTier == "Junior")
   {
            return [
                "baseSalary" => 25000,
                "sss" => 1125,
                "philhealth" => 625,
                "pagibig" => 200,
            ];
   }
   elseif ($employmentType == "Regular" && $positionTier == "Senior") {
            return [
                "baseSalary" => 40000,
                "sss" => 1800,
                "philhealth" => 1000,
                "pagibig" => 200,
            ];
        } else {
            return [
                "baseSalary" => 0,
                "sss" => 0,
                "philhealth" => 0,
                "pagibig" => 0,
            ];
        }
 }

    public function getDaysPresent($daysAbsent)
    {
        return 22 - $daysAbsent;
    }
    public function getDailyRate($baseSalary)
    {
        return $baseSalary / 22;
    }
    public function getHourlyRate($dailyRate)
    {
        return $dailyRate / 8;
    }

    public function getLateDeduction($hourlyRate, $minutesLate)
    {
        return ($hourlyRate / 60) * $minutesLate;
    }

    public function getAbsentDeduction($dailyRate, $daysAbsent)
    {
        return $dailyRate * $daysAbsent;
    }

    public function getOvertimePay($overtimeHours, $hourlyRate)
    {
        return $overtimeHours * ($hourlyRate * 1.25);
    }

    public function getGrossPay($baseSalary, $lateDeduction, $absentDeduction, $overtimePay)
    {
        return $baseSalary - $lateDeduction - $absentDeduction + $overtimePay;
    }

    public function getTotalDeductions($sss, $philhealth, $pagibig)
    {
        return $sss + $philhealth + $pagibig;
    }

    public function getNetPay($grossPay, $totalDeductions)
    {
        return $grossPay - $totalDeductions;
    }

    public function calculate(Request $request)
    {
        $employmentType = $request->input('employmentType');
        $positionTier = $request->input('positionTier');
        $daysAbsent = $request->input('daysAbsent');
        $minutesLate = $request->input('minutesLate');
        $overtimeHours = $request->input('overtimeHours');

        $salaryInfo = $this->getSalaryInfo($employmentType, $positionTier);
        $baseSalary = $salaryInfo['baseSalary'];
        $sss = $salaryInfo['sss'];
        $philhealth = $salaryInfo['philhealth'];
        $pagibig = $salaryInfo['pagibig'];

        $daysPresent = $this->getDaysPresent($daysAbsent);
        $dailyRate = $this->getDailyRate($baseSalary);
        $hourlyRate = $this->getHourlyRate($dailyRate);

        $lateDeduction = $this->getLateDeduction($hourlyRate, $minutesLate);
        $absentDeduction = $this->getAbsentDeduction($dailyRate, $daysAbsent);
        $overtimePay = $this->getOvertimePay($overtimeHours, $hourlyRate);

        $grossPay = $this->getGrossPay($baseSalary, $lateDeduction, $absentDeduction, $overtimePay);
        $totalDeductions = $this->getTotalDeductions($sss, $philhealth, $pagibig);
        $netPay = $this->getNetPay($grossPay, $totalDeductions);

        return response()->json([
            "employmentType" => $employmentType,
            "positionTier" => $positionTier,
            "baseSalary" => $baseSalary,
            "daysPresent" => $daysPresent,
            "dailyRate" => round($dailyRate, 2),
            "hourlyRate" => round($hourlyRate, 2),
            "lateDeduction" => round($lateDeduction, 2),
            "absentDeduction" => round($absentDeduction, 2),
            "overtimePay" => round($overtimePay, 2),
            "grossPay" => round($grossPay, 2),
            "sss" => $sss,
            "philhealth" => $philhealth,
            "pagibig" => $pagibig,
            "totalDeductions" => $totalDeductions,
            "netPay" => round($netPay, 2),
        ]);
    }
}
