<?php

return [
  'stockFile'=> [
    'rows'   => [
      'firstRow' => 0,
    ],
    'columns' => [
      'stockCodeColumn'   => 0,
      'shortNameColumn'   => 1,
      'sectorCodeColumn'  => 2,
      'companyNameColumn' => 4,
      'industryCodeColumn'=> 14,
    ],
  ],
  'industrySectorFile'=> [
    'columns'         => [
      'firstColumn'       => 0,
      'industryNameColumn'=> 1,
      'industryCodeColumn'=> 0,
      'sectorCodeColumn'  => 0,
      'sectorNameColumn'  => 1,
    ]
  ],
  'fundamentalFile'=> [
    'columns'      => [
      'fundamentalStartColumn'=> 12,
      'thirdColumn'           => 2,
    ],
    'rows' => [
      'fyeRow'          => 0,
      'peRow'           => 1,
      'dyRow'           => 2,
      'epsRow'          => 3,
      'dpsRow'          => 4,
      'netProfitGrRow'  => 5,
      'roeRow'          => 6,
      'debtEquityRow'   => 7,
      'netMarginRow'    => 8,
      'gearingRow'      => 9,
      'shareQtyRow'     => 10,
      'fcfShareRow'     => 11,
      'shortTermLoanRow'=> 12,
      'longTermLoanRow' => 13,
      'totalCashRow'    => 14,
      'gpCashRow'       => 15,
      'firstRow'        => 0,
    ],
  ],
];