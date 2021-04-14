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
      'category'         => trim($row[0]),
      'title'            => trim($row[1]),
      'description'      => trim(nl2br($row[2])),
      'target_group'     => trim($row[3]),
      'date'             => trim($row[4]),
      'time'             => trim(str_replace(' - ', ' – ', $row[5])),
      'location'         => trim($row[6]),
      'host'             => trim($row[7]),
      'host_title'       => trim($row[8]),
      'cost'             => trim($row[9]),
      'dateDeadline'     => trim($row[10]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]) : null,
      'hasForm'          => trim($row[11]),
      'email'            => trim($row[12]),
      'state'            => trim($row[13]),
      'dateShowUntil'    => trim($row[14]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[14]) : null,
      'isBildungskrippe' => !empty($row[15]) ? trim($row[15]) : null,
      'isKita'           => !empty($row[16]) ? trim($row[16]) : null,
      'isLeadership'     => !empty($row[17]) ? trim($row[17]) : null,
      'isCompany'        => !empty($row[18]) ? trim($row[18]) : null,
      'isOther'          => !empty($row[19]) ? trim($row[19]) : null
    ]);
  }
}
