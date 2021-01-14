<?php
namespace App\Imports;
use App\Models\Event;
use Maatwebsite\Excel\Concerns\ToModel;

class EventsImport implements ToModel
{
  /**
  * @param array $row
  *
  * @return \Illuminate\Database\Eloquent\Model|null
  */
  public function model(array $row)
  {
    return new Event([
      'title'         => trim($row[0]),
      'host'          => trim($row[1]),
      'host_title'    => trim($row[2]),
      'category'      => trim($row[3]),
      'target_group'  => trim($row[4]),
      'date'          => trim($row[5]),
      'time'          => trim($row[6]),
      'duration'      => trim($row[7]),
      'location'      => trim($row[8]),
    ]);
  }
}
