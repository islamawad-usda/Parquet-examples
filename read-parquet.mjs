// Import the Hyparquet functions used to open and read Parquet files.
import { asyncBufferFromFile, parquetReadObjects } from "hyparquet";
// Import support for compressed Parquet files.
import { compressors } from "hyparquet-compressors";

// Open the normal Parquet test file.
const file = await asyncBufferFromFile("NC_counties_temperatures.parquet");

// Read only the columns needed for graphing.
const rows = await parquetReadObjects({
  file,
  columns: ["county_fips", "date", "temperature_f"],
  compressors,
});

// Convert the returned rows into a simple JavaScript array.
const graphData = rows.map((row) => ({
  countyFips: row.county_fips,
  date: row.date,
  temperature: row.temperature_f,
}));
// Print the first five records so the result can be checked.
console.log("Normal Parquet data:");
console.log(graphData.slice(0, 5));

// Open the GeoParquet test file.
const geoFile = await asyncBufferFromFile(
  "NC_counties_temperatures.geoparquet",
);
// Read the graph fields plus the GeoParquet geometry.
const geoRows = await parquetReadObjects({
  file: geoFile,
  columns: ["county_fips", "date", "temperature_f", "geometry"],
  compressors,
});

// Convert the GeoParquet rows into another normal JavaScript array.
const geoGraphData = geoRows.map((row) => ({
  countyFips: row.county_fips,
  date: row.date,
  temperature: row.temperature_f,
  geometry: row.geometry,
}));
// Print one GeoParquet record to verify the data and geometry.
console.log("\nGeoParquet data:");
console.log(geoGraphData[0]);
