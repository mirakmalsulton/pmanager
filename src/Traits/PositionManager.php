<?php

namespace MirakmalSulton\PManager\Traits;

use Illuminate\Database\Eloquent\Collection;

trait PositionManager
{
    public function movePositionUp()
    {
        $rows = $this->getCollection();
        $position = 1;
        $prevRow = null;
        foreach ($rows as $row) {
            if ($row->id != $this->id) {
                $prevRow = $row;
                $row->update([config('p_manager.field_name') => $position]);
                $position++;
                continue;
            }

            if ($prevRow) {
                $positionForPrevTariff = $position;
                $prevRow->update([config('p_manager.field_name') => $positionForPrevTariff]);

                $positionForCurrentTariff = $position - 1;
                $row->update([config('p_manager.field_name') => $positionForCurrentTariff]);
            }

            $position++;
        }
    }

    public function movePositionDown()
    {
        $rows = $this->getCollection();
        $position = 1;
        $prevRow = null;
        foreach ($rows as $row) {
            if ($row->id == $this->id) {
                $prevRow = $row;
                $position++;
                continue;
            }

            if ($prevRow) {
                $positionForCurrentTariff = $position;
                $prevRow->update([config('p_manager.field_name') => $positionForCurrentTariff]);

                $positionForPrevTariff = $position - 1;
                $row->update([config('p_manager.field_name') => $positionForPrevTariff]);

                $prevRow = null;
                $position++;
                continue;
            }

            $row->update([config('p_manager.field_name') => $position]);

            $position++;
        }
    }

    private function getCollection(): Collection
    {
        return static::orderBy(config('p_manager.field_name'))->get();
    }
}
