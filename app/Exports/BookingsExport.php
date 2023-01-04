<?php

namespace App\Exports;

use App\Models\Reserves\EventBooking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingsExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $event;
    private $status;
    private $search;
    private $date_start;
    private $date_end;
    private $sort;
    private $direction;

    public function setEvent(int $event)
    {
        $this->event = $event;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function setSearch(string $search)
    {
        $this->search = $search;
    }

    public function setDateS($date_start)
    {
        $this->date_start = $date_start;
    }

    public function setDateE(string $date_end)
    {
        $this->date_end = $date_end;
    }

    public function setSort(string $sort)
    {
        $this->sort = $sort;
    }

    public function setDirection(string $direction)
    {
        $this->direction = $direction;
    }

    public function collection()
    {
        return EventBooking::select('order_id', 'client', 'adults', 'childrem', 'subtotal', 'discount', 'total', 'price_adult', 'price_childrem', 'area', 'seats', 'status', 'created_at')
                            ->where('event_id', $this->event)
                            ->where('status', $this->status)
                            ->where('client', 'LIKE', '%' . $this->search . '%')
                            ->whereBetween('created_at', [$this->date_start, $this->date_end])
                            ->orderby($this->sort, $this->direction)->get();
    }

    public function headings(): array
    {
        return ["ID Orden", "Cliente", "Adultos", "Niños", "Subtotal", "Descuento", "Total", "Precio Adulto", "Precio Niño", "Grupo", "Asientos", "Estado", "Fecha"];
    }
}
