<?php
namespace App\Imports;
use App\Models\Event;
use Maatwebsite\Excel\Concerns\ToModel;

class Events implements ToModel
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
      'description'   => trim(nl2br($row[1])),
      'host'          => trim($row[2]),
      'host_title'    => trim($row[3]),
      'category'      => trim($row[4]),
      'target_group'  => trim($row[5]),
      'date'          => trim($row[6]),
      'time'          => trim(str_replace(' - ', ' – ', $row[7])),
      'duration'      => trim($row[8]),
      'location'      => trim($row[9]),
      'cost'          => trim($row[10]),
      'hasForm'       => trim($row[11]),
      'email'         => trim($row[12]),
      'state'         => trim($row[13]),
    ]);
  }
}
