<?php

namespace App;

/**
 * @method appointments()
 * @method materialUsages()
 */
trait HasFinancials
{
    public function calculateIncome($startDate, $endDate)
    {
        return $this->appointments()
            ->whereBetween('start_time', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('price');
    }

    public function calculateMaterialCosts($startDate, $endDate)
    {
        return $this->materialUsages()
            ->whereHas('appointment', function ($query) use ($startDate, $endDate): void {
                $query->whereBetween('start_time', [$startDate, $endDate])
                    ->where('status', 'completed');
            })
            ->with('material')
            ->get()
            ->sum('cost');
    }
}
