<?php

namespace MirakmalSulton\PManager;

use Illuminate\Database\Eloquent\Collection;

trait PManager
{
    public function movePositionUp()
    {
        $rows = $this->getCollection();
        $position = 1;
        $prevRow = null;
        foreach ($rows as $row) {
            if ($row->id != $this->id) {
                $prevRow = $row;
                $row->update([$this->fieldName() => $position]);
                $position++;
                continue;
            }

            if ($prevRow) {
                $positionForPrevTariff = $position;
                $prevRow->update([$this->fieldName() => $positionForPrevTariff]);

                $positionForCurrentTariff = $position - 1;
                $row->update([$this->fieldName() => $positionForCurrentTariff]);
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
                $prevRow->update([$this->fieldName() => $positionForCurrentTariff]);

                $positionForPrevTariff = $position - 1;
                $row->update([$this->fieldName() => $positionForPrevTariff]);

                $prevRow = null;
                $position++;
                continue;
            }

            $row->update([$this->fieldName() => $position]);

            $position++;
        }
    }

    private function getCollection(): Collection
    {
        return static::orderBy($this->fieldName())->get();
    }
    
    private function fieldName(): string
    {
        return config('pmanager.field_name');
    }
}
