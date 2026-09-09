<?php
// Load the Flow PHP Parquet library installed through Composer.
require __DIR__ . '/vendor/autoload.php';

use Flow\Parquet\Reader;
// Create the Parquet reader.
$reader = new Reader();

// Open the normal Parquet test file.
$file = $reader->read(__DIR__ . '/NC_counties_temperatures.parquet');
// Create an empty array for the graph data.
$graphData = [];
// Read only the county, date, and temperature columns.
foreach ($file->values(['county_fips', 'date', 'temperature_f']) as $row) {
    // Add each Parquet row to a normal PHP array.
    $graphData[] = [
        'countyFips' => $row['county_fips'],
        'date' => $row['date'],
        'temperature' => $row['temperature_f'],
    ];
}
// Print the first five records so the result can be checked.
echo "Normal Parquet data:\n";
print_r(array_slice($graphData, 0, 5));

// Open the GeoParquet test file.
$geoFile = $reader->read(__DIR__ . '/NC_counties_temperatures.geoparquet');
// Create another array for the GeoParquet temperature data.
$geoGraphData = [];
// Read the same graphable columns from the GeoParquet file.
foreach ($geoFile->values(['county_fips', 'date', 'temperature_f']) as $row) {
    // Add each GeoParquet row to a normal PHP array.
    $geoGraphData[] = [
        'countyFips' => $row['county_fips'],
        'date' => $row['date'],
        'temperature' => $row['temperature_f'],
    ];
}
// Print the first five GeoParquet records.
echo "\nGeoParquet data:\n";
print_r(array_slice($geoGraphData, 0, 5));
